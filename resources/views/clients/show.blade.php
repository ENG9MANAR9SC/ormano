@extends('layouts.app')

@section('title', $client->full_name)

@section('content')
    <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $client->full_name }}</h1>
            <p class="mt-1 text-sm text-slate-600">{{ $client->email }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a
                href="{{ route('clients.edit', $client) }}"
                class="inline-flex rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Edit
            </a>
            <form
                action="{{ route('clients.destroy', $client) }}"
                method="post"
                onsubmit="return confirm('Delete this client? Linked cases must be handled first.');"
            >
                @csrf
                @method('delete')
                <button
                    type="submit"
                    class="inline-flex rounded-xl border border-red-200 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50"
                >
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Profile</h2>
            <dl class="grid gap-4 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-slate-500">National ID</dt>
                    <dd class="font-medium text-slate-900">{{ $client->national_id ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Phone</dt>
                    <dd class="font-medium text-slate-900">{{ $client->phone ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Birth date</dt>
                    <dd class="font-medium text-slate-900">{{ $client->birth_date?->format('Y-m-d') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Location</dt>
                    <dd class="font-medium text-slate-900">
                        {{ $client->city ? $client->city.', ' : '' }}{{ $client->country }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-500">Address</dt>
                    <dd class="font-medium text-slate-900">{{ $client->address ?? '—' }}</dd>
                </div>
                @if ($client->father_name || $client->mother_name)
                    <div>
                        <dt class="text-slate-500">Father</dt>
                        <dd class="font-medium text-slate-900">{{ $client->father_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Mother</dt>
                        <dd class="font-medium text-slate-900">{{ $client->mother_name ?? '—' }}</dd>
                    </div>
                @endif
                @if ($client->notes)
                    <div class="sm:col-span-2">
                        <dt class="text-slate-500">Notes</dt>
                        <dd class="whitespace-pre-wrap text-slate-800">{{ $client->notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Cases</h2>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $client->legal_cases_count }}</p>
            <p class="text-sm text-slate-600">Recent matters</p>
        </div>
    </div>

    @if ($client->legalCases->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-3">
                <h2 class="text-sm font-semibold text-slate-900">Recent cases</h2>
            </div>
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Number</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($client->legalCases as $c)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3">
                                <a href="{{ route('cases.show', $c) }}" class="font-medium text-blue-700 hover:underline">
                                    {{ $c->case_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-slate-800">{{ $c->title }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $c->type->label() }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $c->status->label() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
