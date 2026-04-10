<?php

namespace App\Http\Requests\Client;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
        /** @var Client $client */
        $client = $this->route('client');

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'national_id' => ['nullable', 'string', 'max:255', Rule::unique('clients', 'national_id')->ignore($client->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($client->id)],
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
