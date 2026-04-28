<?php

namespace App\Http\Controllers;

use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Models\Client;
use App\Models\Document;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(): View
    {
        $documents = Document::query()
            ->with(['legalCase', 'client', 'creator'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('documents.index', ['documents' => $documents]);
    }

    public function create(): View
    {
        return view('documents.create', $this->formOptions() + [
            'document' => new Document(['status' => 'draft', 'type' => 'general']),
            'statuses' => ['draft', 'review', 'final', 'archived'],
            'types' => ['general', 'memo', 'defense_note', 'power_of_attorney', 'contract'],
        ]);
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $document = Document::query()->create($request->validated());

        return redirect()->route('documents.show', $document)
            ->with('success', __('Document created successfully.'));
    }

    public function show(Document $document): View
    {
        $document->load(['legalCase', 'client', 'creator']);

        return view('documents.show', ['document' => $document]);
    }

    public function edit(Document $document): View
    {
        return view('documents.edit', $this->formOptions() + [
            'document' => $document,
            'statuses' => ['draft', 'review', 'final', 'archived'],
            'types' => ['general', 'memo', 'defense_note', 'power_of_attorney', 'contract'],
        ]);
    }

    public function update(UpdateDocumentRequest $request, Document $document): RedirectResponse
    {
        $document->update($request->validated());

        return redirect()->route('documents.show', $document)
            ->with('success', __('Document updated successfully.'));
    }

    public function destroy(Document $document): RedirectResponse
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', __('Document archived successfully.'));
    }

    /**
     * @return array<string, mixed>
     */
    private function formOptions(): array
    {
        return [
            'cases' => LegalCase::query()->orderBy('title')->get(['id', 'title', 'case_number']),
            'clients' => Client::query()->orderBy('last_name')->orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'users' => User::query()->orderBy('name')->get(['id', 'name', 'email']),
        ];
    }
}
