<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'national_id' => ['nullable', 'string', 'max:255', 'unique:clients,national_id'],
            'email' => ['required', 'email', 'max:255', 'unique:clients,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('national_id') === '') {
            $this->merge(['national_id' => null]);
        }
    }
}
