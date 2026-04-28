<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
            'type' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:draft,review,final,archived'],
            'template_name' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'document_date' => ['nullable', 'date'],
            'case_id' => ['nullable', 'integer', 'exists:cases,id'],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'created_by' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
