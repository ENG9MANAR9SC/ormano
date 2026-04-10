<?php

namespace App\Http\Requests\Court;

use App\Domain\Legal\Enums\CourtType;
use App\Models\Court;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourtRequest extends FormRequest
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
        /** @var Court $court */
        $court = $this->route('court');

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255', Rule::unique('courts', 'code')->ignore($court->id)],
            'type' => ['nullable', Rule::enum(CourtType::class)],
            'jurisdiction' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('type') === '') {
            $this->merge(['type' => null]);
        }

        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
