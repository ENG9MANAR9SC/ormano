@extends('layouts.app')

@section('title', 'Task Calendar')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Open Tasks Calendar</h1>
            <p class="mt-1 text-sm text-slate-600">Monthly view for open and in-progress tasks by due date.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Back to tasks</a>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">New task</a>
        </div>
    </div>

    <div class="mb-4 flex items-center justify-between rounded-2xl border border-slate-200/80 bg-white px-4 py-3 shadow-sm">
        <a href="{{ route('tasks.calendar', ['month' => $previousMonth]) }}" class="text-sm font-medium text-blue-600 hover:underline">Previous</a>
        <h2 class="text-lg font-semibold text-slate-900">{{ $month->format('F Y') }}</h2>
        <a href="{{ route('tasks.calendar', ['month' => $nextMonth]) }}" class="text-sm font-medium text-blue-600 hover:underline">Next</a>
    </div>

    <div class="grid grid-cols-7 gap-2 text-xs font-semibold uppercase tracking-wide text-slate-500">
        <div class="rounded-lg bg-slate-100 px-2 py-2 text-center">Mon</div>
        <div class="rounded-lg bg-slate-100 px-2 py-2 text-center">Tue</div>
        <div class="rounded-lg bg-slate-100 px-2 py-2 text-center">Wed</div>
        <div class="rounded-lg bg-slate-100 px-2 py-2 text-center">Thu</div>
        <div class="rounded-lg bg-slate-100 px-2 py-2 text-center">Fri</div>
        <div class="rounded-lg bg-slate-100 px-2 py-2 text-center">Sat</div>
        <div class="rounded-lg bg-slate-100 px-2 py-2 text-center">Sun</div>
    </div>

    <div class="mt-2 grid grid-cols-7 gap-2">
        @foreach ($days as $day)
            <div class="min-h-36 rounded-xl border {{ $day['isCurrentMonth'] ? 'border-slate-200 bg-white' : 'border-slate-100 bg-slate-50/60' }} p-2">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-xs font-semibold {{ $day['isCurrentMonth'] ? 'text-slate-700' : 'text-slate-400' }}">
                        {{ $day['date']->format('d') }}
                    </span>
                    @if ($day['tasks']->count() > 0)
                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">
                            {{ $day['tasks']->count() }}
                        </span>
                    @endif
                </div>

                <div class="space-y-1">
                    @foreach ($day['tasks']->take(3) as $task)
                        <a href="{{ route('tasks.show', $task) }}" class="block rounded-md border border-blue-100 bg-blue-50 px-2 py-1 text-xs text-blue-900 hover:bg-blue-100">
                            <span class="block truncate font-medium">{{ $task->title }}</span>
                            <span class="block truncate text-blue-700">{{ $task->assignee?->name ?? 'Unassigned' }}</span>
                        </a>
                    @endforeach

                    @if ($day['tasks']->count() > 3)
                        <p class="px-1 text-[11px] text-slate-500">+{{ $day['tasks']->count() - 3 }} more</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
