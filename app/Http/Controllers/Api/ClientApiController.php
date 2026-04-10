<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ClientApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $clients = Client::query()
            ->withCount('legalCases')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15);

        return ClientResource::collection($clients);
    }

    public function store(StoreClientRequest $request): ClientResource
    {
        $client = Client::query()->create($request->validated());

        return new ClientResource($client->loadCount('legalCases'));
    }

    public function show(Client $client): ClientResource
    {
        return new ClientResource($client->loadCount('legalCases'));
    }

    public function update(UpdateClientRequest $request, Client $client): ClientResource
    {
        $client->update($request->validated());

        return new ClientResource($client->fresh()->loadCount('legalCases'));
    }

    public function destroy(Client $client): Response
    {
        if ($client->legalCases()->exists()) {
            abort(422, 'Remove or reassign cases before deleting this client.');
        }

        $client->delete();

        return response()->noContent();
    }
}
