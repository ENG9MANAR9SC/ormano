<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LegalCase\StoreLegalCaseRequest;
use App\Http\Requests\LegalCase\UpdateLegalCaseRequest;
use App\Http\Resources\LegalCaseResource;
use App\Models\LegalCase;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LegalCaseApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $cases = LegalCase::query()
            ->with(['client', 'court', 'assignee'])
            ->latest()
            ->paginate(15);

        return LegalCaseResource::collection($cases);
    }

    public function store(StoreLegalCaseRequest $request): LegalCaseResource
    {
        $legalCase = LegalCase::query()->create($request->validated());
        $legalCase->load(['client', 'court', 'assignee']);

        return new LegalCaseResource($legalCase);
    }

    public function show(LegalCase $case): LegalCaseResource
    {
        $case->load(['client', 'court', 'assignee']);

        return new LegalCaseResource($case);
    }

    public function update(UpdateLegalCaseRequest $request, LegalCase $case): LegalCaseResource
    {
        $case->update($request->validated());
        $case->load(['client', 'court', 'assignee']);

        return new LegalCaseResource($case->fresh());
    }

    public function destroy(LegalCase $case): Response
    {
        $case->delete();

        return response()->noContent();
    }
}
