<?php

namespace App\Http\Resources;

use App\Models\LegalCase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LegalCase
 */
class LegalCaseResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'case_number' => $this->case_number,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type->value,
            'type_label' => $this->type->label(),
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'priority' => $this->priority?->value,
            'priority_label' => $this->priority?->label(),
            'filing_date' => $this->filing_date?->format('Y-m-d'),
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'next_hearing_date' => $this->next_hearing_date?->format('Y-m-d'),
            'client_id' => $this->client_id,
            'court_id' => $this->court_id,
            'assigned_to' => $this->assigned_to,
            'notes' => $this->notes,
            'client' => ClientResource::make($this->whenLoaded('client')),
            'court' => CourtResource::make($this->whenLoaded('court')),
            'assignee' => UserOptionResource::make($this->whenLoaded('assignee')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
