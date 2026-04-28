@php
    /** @var \App\Models\Task $task */
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <x-form-input name="title" label="Title" :value="$task->title" required />
    <x-form-input type="date" name="due_date" label="Due date" :value="$task->due_date?->format('Y-m-d')" />

    <x-form-select name="status" label="Status" required>
        @foreach ($statuses as $status)
            <option value="{{ $status }}" @selected(old('status', $task->status) === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
        @endforeach
    </x-form-select>

    <x-form-select name="priority" label="Priority" required>
        @foreach ($priorities as $priority)
            <option value="{{ $priority }}" @selected(old('priority', $task->priority) === $priority)>{{ str($priority)->replace('_', ' ')->title() }}</option>
        @endforeach
    </x-form-select>

    <x-form-select name="case_id" label="Case">
        <option value="">-- No case linked --</option>
        @foreach ($cases as $legalCase)
            <option value="{{ $legalCase->id }}" @selected((string) old('case_id', $task->case_id) === (string) $legalCase->id)>
                {{ $legalCase->case_number }} - {{ $legalCase->title }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="assigned_to" label="Assigned to">
        <option value="">-- Unassigned --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected((string) old('assigned_to', $task->assigned_to) === (string) $user->id)>
                {{ $user->name }} ({{ $user->email }})
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="created_by" label="Created by">
        <option value="">-- Unknown --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected((string) old('created_by', $task->created_by) === (string) $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </x-form-select>

    <div class="md:col-span-2">
        <x-form-textarea name="description" label="Description" rows="5" :value="$task->description" />
    </div>
</div>
