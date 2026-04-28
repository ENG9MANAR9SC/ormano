@php
    /** @var \App\Models\Document $document */
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <x-form-input name="title" label="Title" :value="$document->title" required />

    <x-form-select name="type" label="Type" required>
        @foreach ($types as $type)
            <option value="{{ $type }}" @selected(old('type', $document->type) === $type)>{{ str($type)->replace('_', ' ')->title() }}</option>
        @endforeach
    </x-form-select>

    <x-form-select name="status" label="Status" required>
        @foreach ($statuses as $status)
            <option value="{{ $status }}" @selected(old('status', $document->status) === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
        @endforeach
    </x-form-select>

    <x-form-input name="template_name" label="Template name" :value="$document->template_name" />
    <x-form-input type="date" name="document_date" label="Document date" :value="$document->document_date?->format('Y-m-d')" />

    <x-form-select name="case_id" label="Case">
        <option value="">-- No case linked --</option>
        @foreach ($cases as $legalCase)
            <option value="{{ $legalCase->id }}" @selected((string) old('case_id', $document->case_id) === (string) $legalCase->id)>
                {{ $legalCase->case_number }} - {{ $legalCase->title }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="client_id" label="Client">
        <option value="">-- No client linked --</option>
        @foreach ($clients as $client)
            <option value="{{ $client->id }}" @selected((string) old('client_id', $document->client_id) === (string) $client->id)>
                {{ $client->first_name }} {{ $client->last_name }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-select name="created_by" label="Author">
        <option value="">-- Not assigned --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected((string) old('created_by', $document->created_by) === (string) $user->id)>
                {{ $user->name }} ({{ $user->email }})
            </option>
        @endforeach
    </x-form-select>

    <div class="md:col-span-2">
        <x-form-textarea name="content" label="Content" rows="8" :value="$document->content" />
    </div>
</div>
