@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ $task->title }}</h1>
            <p class="mt-1 text-sm text-slate-600">
                {{ str($task->status)->replace('_', ' ')->title() }} · {{ str($task->priority)->title() }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.edit', $task) }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Edit</a>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Archive this task?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl border border-red-200 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50">Archive</button>
            </form>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Details</h2>
            <dl class="space-y-2 text-sm">
                <div><dt class="text-slate-500">Due date</dt><dd class="text-slate-900">{{ $task->due_date?->format('Y-m-d') ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Assigned to</dt><dd class="text-slate-900">{{ $task->assignee?->name ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Created by</dt><dd class="text-slate-900">{{ $task->creator?->name ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Case</dt><dd class="text-slate-900">{{ $task->legalCase?->case_number ?? '—' }}</dd></div>
            </dl>
        </div>

        <div class="lg:col-span-2 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">Description</h2>
            <p class="whitespace-pre-wrap text-sm leading-6 text-slate-800">{{ $task->description ?: 'No description provided.' }}</p>
        </div>
    </div>
@endsection
