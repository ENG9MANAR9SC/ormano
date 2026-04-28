<?php

namespace App\Http\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Document */
class DocumentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'type_label' => str_replace('_', ' ', ucfirst($this->type)),
            'status' => $this->status,
            'status_label' => ucfirst($this->status),
            'content' => $this->content,
            'template_name' => $this->template_name,
            'case_id' => $this->case_id,
            'client_id' => $this->client_id,
            'created_by' => $this->created_by,
            'document_date' => $this->document_date?->toDateString(),
            'legal_case' => $this->whenLoaded('legalCase', fn (): ?array => $this->legalCase ? [
                'id' => $this->legalCase->id,
                'title' => $this->legalCase->title,
                'case_number' => $this->legalCase->case_number,
            ] : null),
            'client' => $this->whenLoaded('client', fn (): ?array => $this->client ? [
                'id' => $this->client->id,
                'full_name' => $this->client->full_name,
                'email' => $this->client->email,
            ] : null),
            'creator' => $this->whenLoaded('creator', fn (): ?array => $this->creator ? [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
                'email' => $this->creator->email,
            ] : null),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
