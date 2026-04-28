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
            'task_statuses' => $this->stringOptions(['open', 'in_progress', 'done', 'cancelled']),
            'task_priorities' => $this->stringOptions(['low', 'medium', 'high', 'urgent']),
            'document_statuses' => $this->stringOptions(['draft', 'review', 'final', 'archived']),
            'document_types' => $this->stringOptions(['general', 'memo', 'defense_note', 'power_of_attorney', 'contract']),
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

    public function taskForm(): JsonResponse
    {
        $cases = \App\Models\LegalCase::query()
            ->orderBy('title')
            ->get(['id', 'title', 'case_number'])
            ->map(fn (\App\Models\LegalCase $legalCase): array => [
                'id' => $legalCase->id,
                'label' => $legalCase->case_number.' — '.$legalCase->title,
            ])
            ->values()
            ->all();

        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return response()->json([
            'cases' => $cases,
            'users' => UserOptionResource::collection($users)->resolve(),
        ]);
    }

    public function documentForm(): JsonResponse
    {
        $cases = \App\Models\LegalCase::query()
            ->orderBy('title')
            ->get(['id', 'title', 'case_number'])
            ->map(fn (\App\Models\LegalCase $legalCase): array => [
                'id' => $legalCase->id,
                'label' => $legalCase->case_number.' — '.$legalCase->title,
            ])
            ->values()
            ->all();

        $clients = Client::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name', 'email'])
            ->map(fn (Client $client): array => [
                'id' => $client->id,
                'label' => $client->full_name.' — '.$client->email,
            ])
            ->values()
            ->all();

        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return response()->json([
            'cases' => $cases,
            'clients' => $clients,
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
                'label' => $this->enumLabel($case),
            ])
            ->values()
            ->all();
    }

    /**
     * @param  list<string>  $values
     * @return list<array{value: string, label: string}>
     */
    private function stringOptions(array $values): array
    {
        return collect($values)
            ->map(fn (string $value): array => [
                'value' => $value,
                'label' => str_replace('_', ' ', ucfirst($value)),
            ])
            ->values()
            ->all();
    }

    private function enumLabel(\BackedEnum $case): string
    {
        if (method_exists($case, 'label')) {
            /** @var callable(): string $labelGetter */
            $labelGetter = [$case, 'label'];

            return $labelGetter();
        }

        return $case->name;
    }
}
