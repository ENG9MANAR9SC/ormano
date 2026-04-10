<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::query()
            ->withCount('legalCases')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(12)
            ->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('clients.create', ['client' => new Client]);
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $client = Client::query()->create($request->validated());

        return redirect()->route('clients.show', $client)
            ->with('success', __('Client created successfully.'));
    }

    public function show(Client $client): View
    {
        $client->loadCount('legalCases');
        $client->load([
            'legalCases' => fn ($q) => $q->with(['court', 'assignee'])->latest()->limit(20),
        ]);

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('clients.show', $client)
            ->with('success', __('Client updated successfully.'));
    }

    public function destroy(Client $client): RedirectResponse
    {
        if ($client->legalCases()->exists()) {
            return redirect()->route('clients.show', $client)
                ->with('error', __('Remove or reassign cases before deleting this client.'));
        }

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', __('Client removed successfully.'));
    }
}
