<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DocumentApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $documents = Document::query()
            ->with(['legalCase', 'client', 'creator'])
            ->latest()
            ->paginate(15);

        return DocumentResource::collection($documents);
    }

    public function store(StoreDocumentRequest $request): DocumentResource
    {
        $document = Document::query()->create($request->validated());
        $document->load(['legalCase', 'client', 'creator']);

        return new DocumentResource($document);
    }

    public function show(Document $document): DocumentResource
    {
        $document->load(['legalCase', 'client', 'creator']);

        return new DocumentResource($document);
    }

    public function update(UpdateDocumentRequest $request, Document $document): DocumentResource
    {
        $document->update($request->validated());
        $document->load(['legalCase', 'client', 'creator']);

        return new DocumentResource($document->fresh());
    }

    public function destroy(Document $document): Response
    {
        $document->delete();

        return response()->noContent();
    }
}
