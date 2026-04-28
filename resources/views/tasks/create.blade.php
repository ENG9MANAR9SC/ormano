@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Create task</h1>
        <p class="mt-1 text-sm text-slate-600">Add an open task and assign ownership.</p>
    </div>

    <form method="POST" action="{{ route('tasks.store') }}" class="space-y-6 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
        @csrf
        @include('tasks._form')

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Save task</button>
            <a href="{{ route('tasks.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel</a>
        </div>
    </form>
@endsection
