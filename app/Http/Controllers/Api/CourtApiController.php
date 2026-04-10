<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Court\StoreCourtRequest;
use App\Http\Requests\Court\UpdateCourtRequest;
use App\Http\Resources\CourtResource;
use App\Models\Court;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CourtApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $courts = Court::query()
            ->withCount('legalCases')
            ->orderBy('name')
            ->paginate(15);

        return CourtResource::collection($courts);
    }

    public function store(StoreCourtRequest $request): CourtResource
    {
        $court = Court::query()->create($request->validated());

        return new CourtResource($court->loadCount('legalCases'));
    }

    public function show(Court $court): CourtResource
    {
        return new CourtResource($court->loadCount('legalCases'));
    }

    public function update(UpdateCourtRequest $request, Court $court): CourtResource
    {
        $court->update($request->validated());

        return new CourtResource($court->fresh()->loadCount('legalCases'));
    }

    public function destroy(Court $court): Response
    {
        $court->delete();

        return response()->noContent();
    }
}
