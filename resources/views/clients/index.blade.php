@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Clients</h1>
            <p class="mt-1 text-sm text-slate-600">People and entities you represent.</p>
        </div>
        <a
            href="{{ route('clients.create') }}"
            class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
        >
            Add client
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Country</th>
                    <th class="px-4 py-3 text-end">Cases</th>
                    <th class="px-4 py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($clients as $client)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3 font-medium text-slate-900">
                            <a href="{{ route('clients.show', $client) }}" class="text-blue-700 hover:underline">
                                {{ $client->full_name }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $client->email }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $client->country }}</td>
                        <td class="px-4 py-3 text-end text-slate-600">{{ $client->legal_cases_count }}</td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('clients.edit', $client) }}" class="text-blue-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-500">
                            No clients yet.
                            <a href="{{ route('clients.create') }}" class="font-medium text-blue-600 hover:underline">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $clients->links() }}</div>
@endsection
