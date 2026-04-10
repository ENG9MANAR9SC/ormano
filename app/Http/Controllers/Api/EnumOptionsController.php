<?php

namespace App\Http\Controllers\Api;

use App\Domain\Legal\Enums\CasePriority;
use App\Domain\Legal\Enums\CaseStatus;
use App\Domain\Legal\Enums\CaseType;
use App\Domain\Legal\Enums\CourtType;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserOptionResource;
use App\Models\Client;
use App\Models\Court;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class EnumOptionsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'court_types' => $this->enumOptions(CourtType::class),
            'case_types' => $this->enumOptions(CaseType::class),
            'case_statuses' => $this->enumOptions(CaseStatus::class),
            'case_priorities' => $this->enumOptions(CasePriority::class),
        ]);
    }

    public function users(): JsonResponse
    {
        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return UserOptionResource::collection($users)->response();
    }

    public function caseForm(): JsonResponse
    {
        $clients = Client::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name', 'email']);

        $clientOptions = $clients->map(fn (Client $c): array => [
            'id' => $c->id,
            'label' => $c->full_name.' — '.$c->email,
        ])->values()->all();

        $courts = Court::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Court $court): array => [
                'id' => $court->id,
                'label' => $court->name,
            ])
            ->values()
            ->all();

        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return response()->json([
            'clients' => $clientOptions,
            'courts' => $courts,
            'users' => UserOptionResource::collection($users)->resolve(),
        ]);
    }

    /**
     * @param  class-string<\BackedEnum>  $enumClass
     * @return list<array{value: string, label: string}>
     */
    private function enumOptions(string $enumClass): array
    {
        return collect($enumClass::cases())
            ->map(fn (\BackedEnum $case): array => [
                'value' => $case->value,
                'label' => method_exists($case, 'label') ? $case->label() : $case->name,
            ])
            ->values()
            ->all();
    }
}
