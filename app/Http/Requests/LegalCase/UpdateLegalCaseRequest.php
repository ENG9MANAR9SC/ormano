<?php

namespace App\Http\Requests\LegalCase;

use App\Domain\Legal\Enums\CasePriority;
use App\Domain\Legal\Enums\CaseStatus;
use App\Domain\Legal\Enums\CaseType;
use App\Models\LegalCase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLegalCaseRequest extends FormRequest
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
        /** @var LegalCase $case */
        $case = $this->route('case');

        return [
            'case_number' => ['required', 'string', 'max:255', Rule::unique('cases', 'case_number')->ignore($case->id)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', Rule::enum(CaseType::class)],
            'status' => ['required', Rule::enum(CaseStatus::class)],
            'priority' => ['nullable', Rule::enum(CasePriority::class)],
            'filing_date' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'next_hearing_date' => ['nullable', 'date'],
            'client_id' => ['required', 'exists:clients,id'],
            'court_id' => ['nullable', 'exists:courts,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('priority') === '') {
            $this->merge(['priority' => null]);
        }

        if ($this->input('court_id') === '') {
            $this->merge(['court_id' => null]);
        }

        if ($this->input('assigned_to') === '') {
            $this->merge(['assigned_to' => null]);
        }
    }
}
