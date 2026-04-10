@extends('layouts.app')

@section('title', 'Cases')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Cases</h1>
            <p class="mt-1 text-sm text-slate-600">Matter list with type, status, and parties.</p>
        </div>
        <a
            href="{{ route('cases.create') }}"
            class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
        >
            New case
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Number</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Court</th>
                    <th class="px-4 py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($cases as $legalCase)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3 font-medium text-slate-900">
                            <a href="{{ route('cases.show', $legalCase) }}" class="text-blue-700 hover:underline">
                                {{ $legalCase->case_number }}
                            </a>
                        </td>
                        <td class="max-w-xs truncate px-4 py-3 text-slate-800">{{ $legalCase->title }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $legalCase->type->label() }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $legalCase->status->label() }}</td>
                        <td class="px-4 py-3 text-slate-600">
                            @if ($legalCase->client)
                                <a href="{{ route('clients.show', $legalCase->client) }}" class="text-blue-600 hover:underline">
                                    {{ $legalCase->client->full_name }}
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $legalCase->court?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('cases.edit', $legalCase) }}" class="text-blue-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                            No cases yet.
                            <a href="{{ route('cases.create') }}" class="font-medium text-blue-600 hover:underline">Open a case</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $cases->links() }}</div>
@endsection
