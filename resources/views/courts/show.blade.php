@extends('layouts.app')

@section('title', $court->name)

@section('content')
    <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $court->name }}</h1>
            <p class="mt-1 text-sm text-slate-600">
                {{ $court->type?->label() ?? 'Type not set' }}
                @if ($court->jurisdiction)
                    · {{ $court->jurisdiction }}
                @endif
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a
                href="{{ route('courts.edit', $court) }}"
                class="inline-flex rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Edit
            </a>
            <form action="{{ route('courts.destroy', $court) }}" method="post" onsubmit="return confirm('Archive this court?');">
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
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Details</h2>
            <dl class="grid gap-4 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-slate-500">Code</dt>
                    <dd class="font-medium text-slate-900">{{ $court->code ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">City</dt>
                    <dd class="font-medium text-slate-900">{{ $court->city ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Phone</dt>
                    <dd class="font-medium text-slate-900">{{ $court->phone ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Email</dt>
                    <dd class="font-medium text-slate-900">{{ $court->email ?? '—' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-500">Address</dt>
                    <dd class="font-medium text-slate-900">{{ $court->address ?? '—' }}</dd>
                </div>
                @if ($court->notes)
                    <div class="sm:col-span-2">
                        <dt class="text-slate-500">Notes</dt>
                        <dd class="whitespace-pre-wrap text-slate-800">{{ $court->notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Summary</h2>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $court->legal_cases_count }}</p>
            <p class="text-sm text-slate-600">Linked cases</p>
            @if ($court->is_active)
                <p class="mt-4 text-sm font-medium text-emerald-700">Active for new assignments</p>
            @else
                <p class="mt-4 text-sm font-medium text-slate-600">Inactive</p>
            @endif
        </div>
    </div>
@endsection
