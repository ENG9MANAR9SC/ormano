<?php

namespace App\Http\Controllers;

use App\Domain\Legal\Enums\CasePriority;
use App\Domain\Legal\Enums\CaseStatus;
use App\Domain\Legal\Enums\CaseType;
use App\Http\Requests\LegalCase\StoreLegalCaseRequest;
use App\Http\Requests\LegalCase\UpdateLegalCaseRequest;
use App\Models\Client;
use App\Models\Court;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LegalCaseController extends Controller
{
    public function index(): View
    {
        $cases = LegalCase::query()
            ->with(['client', 'court', 'assignee'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('legal_cases.index', ['cases' => $cases]);
    }

    public function create(): View
    {
        return view('legal_cases.create', $this->formOptions() + [
            'legalCase' => new LegalCase([
                'status' => CaseStatus::OPEN,
            ]),
        ]);
    }

    public function store(StoreLegalCaseRequest $request): RedirectResponse
    {
        $legalCase = LegalCase::query()->create($request->validated());

        return redirect()->route('cases.show', $legalCase)
            ->with('success', __('Case created successfully.'));
    }

    public function show(LegalCase $case): View
    {
        $case->load(['client', 'court', 'assignee']);

        return view('legal_cases.show', ['legalCase' => $case]);
    }

    public function edit(LegalCase $case): View
    {
        return view('legal_cases.edit', $this->formOptions() + [
            'legalCase' => $case,
        ]);
    }

    public function update(UpdateLegalCaseRequest $request, LegalCase $case): RedirectResponse
    {
        $case->update($request->validated());

        return redirect()->route('cases.show', $case)
            ->with('success', __('Case updated successfully.'));
    }

    public function destroy(LegalCase $case): RedirectResponse
    {
        $case->delete();

        return redirect()->route('cases.index')
            ->with('success', __('Case archived successfully.'));
    }

    /**
     * @return array<string, mixed>
     */
    private function formOptions(): array
    {
        return [
            'caseTypes' => CaseType::cases(),
            'statuses' => CaseStatus::cases(),
            'priorities' => CasePriority::cases(),
            'clients' => Client::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
            'courts' => Court::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
            'users' => User::query()
                ->orderBy('name')
                ->get(['id', 'name', 'email']),
        ];
    }
}
