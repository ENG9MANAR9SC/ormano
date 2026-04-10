@extends('layouts.app')

@section('title', 'Edit client')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Edit client</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $client->full_name }}</p>
    </div>

    <form
        action="{{ route('clients.update', $client) }}"
        method="post"
        class="space-y-8 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm md:p-8"
    >
        @csrf
        @method('put')
        @include('clients._form', ['client' => $client])

        <div class="flex flex-wrap gap-3">
            <button
                type="submit"
                class="inline-flex rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
            >
                Update client
            </button>
            <a
                href="{{ route('clients.show', $client) }}"
                class="inline-flex rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Cancel
            </a>
        </div>
    </form>
@endsection
