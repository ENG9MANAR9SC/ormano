@extends('layouts.app')

@section('title', 'Courts')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Courts</h1>
            <p class="mt-1 text-sm text-slate-600">Manage courts and chambers for case filing.</p>
        </div>
        <a
            href="{{ route('courts.create') }}"
            class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
        >
            Add court
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Jurisdiction</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-end">Cases</th>
                    <th class="px-4 py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($courts as $court)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3 font-medium text-slate-900">
                            <a href="{{ route('courts.show', $court) }}" class="text-blue-700 hover:underline">
                                {{ $court->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $court->type?->label() ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $court->jurisdiction ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if ($court->is_active)
                                <span
                                    class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800"
                                >Active</span>
                            @else
                                <span
                                    class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600"
                                >Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end text-slate-600">{{ $court->legal_cases_count }}</td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('courts.edit', $court) }}" class="text-blue-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-slate-500">
                            No courts yet.
                            <a href="{{ route('courts.create') }}" class="font-medium text-blue-600 hover:underline">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $courts->links() }}</div>
@endsection
