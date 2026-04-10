<?php

namespace App\Http\Resources;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Court
 */
class CourtResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type?->value,
            'type_label' => $this->type?->label(),
            'jurisdiction' => $this->jurisdiction,
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'is_active' => (bool) $this->is_active,
            'notes' => $this->notes,
            'legal_cases_count' => $this->whenCounted('legalCases'),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
