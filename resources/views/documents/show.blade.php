@extends('layouts.app')

@section('title', $document->title)

@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ $document->title }}</h1>
            <p class="mt-1 text-sm text-slate-600">
                {{ str($document->type)->replace('_', ' ')->title() }} · {{ str($document->status)->replace('_', ' ')->title() }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('documents.edit', $document) }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Edit</a>
            <form method="POST" action="{{ route('documents.destroy', $document) }}" onsubmit="return confirm('Archive this document?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl border border-red-200 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50">Archive</button>
            </form>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Metadata</h2>
            <dl class="space-y-2 text-sm">
                <div><dt class="text-slate-500">Case</dt><dd class="text-slate-900">{{ $document->legalCase?->case_number ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Client</dt><dd class="text-slate-900">{{ $document->client?->full_name ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Author</dt><dd class="text-slate-900">{{ $document->creator?->name ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Template</dt><dd class="text-slate-900">{{ $document->template_name ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Document date</dt><dd class="text-slate-900">{{ $document->document_date?->format('Y-m-d') ?? '—' }}</dd></div>
            </dl>
        </div>

        <div class="lg:col-span-2 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">Content</h2>
            <p class="whitespace-pre-wrap text-sm leading-6 text-slate-800">{{ $document->content ?: 'No content yet.' }}</p>
        </div>
    </div>
@endsection
