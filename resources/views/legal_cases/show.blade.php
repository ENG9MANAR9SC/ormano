@extends('layouts.app')

@section('title', $legalCase->case_number)

@section('content')
    <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-blue-700">{{ $legalCase->type->label() }}</p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">{{ $legalCase->title }}</h1>
            <p class="mt-1 text-sm text-slate-600">
                <span class="font-mono">{{ $legalCase->case_number }}</span>
                · {{ $legalCase->status->label() }}
                @if ($legalCase->priority)
                    · {{ $legalCase->priority->label() }} priority
                @endif
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a
                href="{{ route('cases.edit', $legalCase) }}"
                class="inline-flex rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Edit
            </a>
            <form
                action="{{ route('cases.destroy', $legalCase) }}"
                method="post"
                onsubmit="return confirm('Archive this case?');"
            >
                @csrf
                @method('delete')
                <button
                    type="submit"
                    class="inline-flex rounded-xl border border-red-200 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50"
                >
                    Archive
                </button>
            </form>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Summary</h2>
            @if ($legalCase->description)
                <p class="whitespace-pre-wrap text-sm text-slate-800">{{ $legalCase->description }}</p>
            @else
                <p class="text-sm text-slate-500">No description.</p>
            @endif

            <dl class="mt-6 grid gap-4 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-slate-500">Filing date</dt>
                    <dd class="font-medium text-slate-900">{{ $legalCase->filing_date?->format('Y-m-d') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Next hearing</dt>
                    <dd class="font-medium text-slate-900">{{ $legalCase->next_hearing_date?->format('Y-m-d') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Start</dt>
                    <dd class="font-medium text-slate-900">{{ $legalCase->start_date?->format('Y-m-d') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">End</dt>
                    <dd class="font-medium text-slate-900">{{ $legalCase->end_date?->format('Y-m-d') ?? '—' }}</dd>
                </div>
            </dl>

            @if ($legalCase->notes)
                <div class="mt-6 border-t border-slate-100 pt-6">
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Internal notes</h3>
                    <p class="mt-2 whitespace-pre-wrap text-sm text-slate-800">{{ $legalCase->notes }}</p>
                </div>
            @endif
        </div>

        <div class="space-y-4 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Parties & links</h2>
            <div class="text-sm">
                <p class="text-slate-500">Client</p>
                @if ($legalCase->client)
                    <a href="{{ route('clients.show', $legalCase->client) }}" class="font-medium text-blue-700 hover:underline">
                        {{ $legalCase->client->full_name }}
                    </a>
                @else
                    <p class="font-medium text-slate-900">—</p>
                @endif
            </div>
            <div class="text-sm">
                <p class="text-slate-500">Court</p>
                @if ($legalCase->court)
                    <a href="{{ route('courts.show', $legalCase->court) }}" class="font-medium text-blue-700 hover:underline">
                        {{ $legalCase->court->name }}
                    </a>
                @else
                    <p class="font-medium text-slate-900">—</p>
                @endif
            </div>
            <div class="text-sm">
                <p class="text-slate-500">Assigned to</p>
                <p class="font-medium text-slate-900">{{ $legalCase->assignee?->name ?? '—' }}</p>
            </div>
        </div>
    </div>
@endsection
