<?php

namespace App\Http\Controllers;

use App\Domain\Legal\Enums\CourtType;
use App\Http\Requests\Court\StoreCourtRequest;
use App\Http\Requests\Court\UpdateCourtRequest;
use App\Models\Court;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourtController extends Controller
{
    public function index(): View
    {
        $courts = Court::query()
            ->withCount('legalCases')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('courts.index', compact('courts'));
    }

    public function create(): View
    {
        return view('courts.create', [
            'court' => new Court(['is_active' => true]),
            'courtTypes' => CourtType::cases(),
        ]);
    }

    public function store(StoreCourtRequest $request): RedirectResponse
    {
        Court::query()->create($request->validated());

        return redirect()->route('courts.index')
            ->with('success', __('Court created successfully.'));
    }

    public function show(Court $court): View
    {
        $court->loadCount('legalCases');

        return view('courts.show', compact('court'));
    }

    public function edit(Court $court): View
    {
        return view('courts.edit', [
            'court' => $court,
            'courtTypes' => CourtType::cases(),
        ]);
    }

    public function update(UpdateCourtRequest $request, Court $court): RedirectResponse
    {
        $court->update($request->validated());

        return redirect()->route('courts.show', $court)
            ->with('success', __('Court updated successfully.'));
    }

    public function destroy(Court $court): RedirectResponse
    {
        $court->delete();

        return redirect()->route('courts.index')
            ->with('success', __('Court archived successfully.'));
    }
}
