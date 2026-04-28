<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:open,in_progress,done,cancelled'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'due_date' => ['nullable', 'date'],
            'case_id' => ['nullable', 'integer', 'exists:cases,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'created_by' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
