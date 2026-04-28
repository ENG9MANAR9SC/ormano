@extends('layouts.app')

@section('title', 'Documents')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Documents</h1>
            <p class="mt-1 text-sm text-slate-600">Manage drafts, legal memos, and finalized records.</p>
        </div>
        <a href="{{ route('documents.create') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
            New document
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Case</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($documents as $document)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3 font-medium text-slate-900">
                            <a href="{{ route('documents.show', $document) }}" class="text-blue-700 hover:underline">{{ $document->title }}</a>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ str($document->type)->replace('_', ' ')->title() }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ str($document->status)->replace('_', ' ')->title() }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $document->legalCase?->case_number ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $document->document_date?->format('Y-m-d') ?? '—' }}</td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('documents.edit', $document) }}" class="text-blue-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-slate-500">No documents yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $documents->links() }}</div>
@endsection
