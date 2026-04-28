<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Task */
class TaskResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'status_label' => str_replace('_', ' ', ucfirst($this->status)),
            'priority' => $this->priority,
            'priority_label' => ucfirst($this->priority),
            'due_date' => $this->due_date?->toDateString(),
            'case_id' => $this->case_id,
            'assigned_to' => $this->assigned_to,
            'created_by' => $this->created_by,
            'legal_case' => $this->whenLoaded('legalCase', fn (): ?array => $this->legalCase ? [
                'id' => $this->legalCase->id,
                'title' => $this->legalCase->title,
                'case_number' => $this->legalCase->case_number,
            ] : null),
            'assignee' => $this->whenLoaded('assignee', fn (): ?array => $this->assignee ? [
                'id' => $this->assignee->id,
                'name' => $this->assignee->name,
                'email' => $this->assignee->email,
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
