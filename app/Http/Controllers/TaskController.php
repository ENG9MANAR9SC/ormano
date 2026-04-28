<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\LegalCase;
use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()
            ->with(['legalCase', 'assignee'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function calendar(Request $request): View
    {
        $month = (string) $request->query('month', now()->format('Y-m'));
        $currentMonth = CarbonImmutable::createFromFormat('Y-m', $month)->startOfMonth();
        $start = $currentMonth->startOfWeek();
        $end = $currentMonth->endOfMonth()->endOfWeek();

        $openTasks = Task::query()
            ->open()
            ->whereBetween('due_date', [$start->toDateString(), $end->toDateString()])
            ->with(['assignee', 'legalCase'])
            ->orderBy('due_date')
            ->get()
            ->groupBy(fn (Task $task) => $task->due_date?->toDateString());

        $days = [];
        for ($day = $start; $day->lte($end); $day = $day->addDay()) {
            $days[] = [
                'date' => $day,
                'tasks' => $openTasks->get($day->toDateString(), collect()),
                'isCurrentMonth' => $day->month === $currentMonth->month,
            ];
        }

        return view('tasks.calendar', [
            'days' => $days,
            'month' => $currentMonth,
            'previousMonth' => $currentMonth->subMonth()->format('Y-m'),
            'nextMonth' => $currentMonth->addMonth()->format('Y-m'),
        ]);
    }

    public function create(): View
    {
        return view('tasks.create', $this->formOptions() + [
            'task' => new Task(['status' => 'open', 'priority' => 'medium']),
            'statuses' => ['open', 'in_progress', 'done', 'cancelled'],
            'priorities' => ['low', 'medium', 'high', 'urgent'],
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = Task::query()->create($request->validated());

        return redirect()->route('tasks.show', $task)
            ->with('success', __('Task created successfully.'));
    }

    public function show(Task $task): View
    {
        $task->load(['legalCase', 'assignee', 'creator']);

        return view('tasks.show', ['task' => $task]);
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', $this->formOptions() + [
            'task' => $task,
            'statuses' => ['open', 'in_progress', 'done', 'cancelled'],
            'priorities' => ['low', 'medium', 'high', 'urgent'],
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()->route('tasks.show', $task)
            ->with('success', __('Task updated successfully.'));
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', __('Task archived successfully.'));
    }

    /**
     * @return array<string, mixed>
     */
    private function formOptions(): array
    {
        return [
            'cases' => LegalCase::query()->orderBy('title')->get(['id', 'title', 'case_number']),
            'users' => User::query()->orderBy('name')->get(['id', 'name', 'email']),
        ];
    }
}
