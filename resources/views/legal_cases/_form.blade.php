@php
    /** @var \App\Models\LegalCase $legalCase */
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <x-form-input name="case_number" label="Case number" :value="$legalCase->case_number" required />

    <x-form-input name="title" label="Title" :value="$legalCase->title" required />

    <x-form-select name="type" label="Case type" required>
        @foreach ($caseTypes as $t)
            <option value="{{ $t->value }}" @selected(old('type', $legalCase->type?->value) === $t->value)>
                {{ $t->label() }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="status" label="Status" required>
        @foreach ($statuses as $s)
            <option value="{{ $s->value }}" @selected(old('status', $legalCase->status?->value) === $s->value)>
                {{ $s->label() }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="priority" label="Priority">
        <option value="">— Not set —</option>
        @foreach ($priorities as $p)
            <option value="{{ $p->value }}" @selected(old('priority', $legalCase->priority?->value) === $p->value)>
                {{ $p->label() }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-input type="date" name="filing_date" label="Filing date" :value="$legalCase->filing_date?->format('Y-m-d')" />
    <x-form-input type="date" name="start_date" label="Start date" :value="$legalCase->start_date?->format('Y-m-d')" />
    <x-form-input type="date" name="end_date" label="End date" :value="$legalCase->end_date?->format('Y-m-d')" />
    <x-form-input type="date" name="next_hearing_date" label="Next hearing" :value="$legalCase->next_hearing_date?->format('Y-m-d')" />

    <x-form-select name="client_id" label="Client" required>
        <option value="">— Select —</option>
        @foreach ($clients as $c)
            <option value="{{ $c->id }}" @selected((string) old('client_id', $legalCase->client_id) === (string) $c->id)>
                {{ $c->full_name }} — {{ $c->email }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="court_id" label="Court">
        <option value="">— Not set —</option>
        @foreach ($courts as $court)
            <option value="{{ $court->id }}" @selected((string) old('court_id', $legalCase->court_id) === (string) $court->id)>
                {{ $court->name }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="assigned_to" label="Assigned to">
        <option value="">— Not set —</option>
        @foreach ($users as $u)
            <option value="{{ $u->id }}" @selected((string) old('assigned_to', $legalCase->assigned_to) === (string) $u->id)>
                {{ $u->name }}
            </option>
        @endforeach
    </x-form-select>

    <div class="md:col-span-2">
        <x-form-textarea name="description" label="Description" rows="3" :value="$legalCase->description" />
    </div>

    <div class="md:col-span-2">
        <x-form-textarea name="notes" label="Internal notes" rows="3" :value="$legalCase->notes" />
    </div>
</div>
