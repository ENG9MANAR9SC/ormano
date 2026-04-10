@php
    /** @var \App\Models\Court $court */
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <x-form-input name="name" label="Court name" :value="$court->name" required />

    <x-form-input name="code" label="Code" :value="$court->code" help="Optional short reference (unique)." />

    <x-form-select name="type" label="Court type">
        <option value="">— Not set —</option>
        @foreach ($courtTypes as $t)
            <option value="{{ $t->value }}" @selected(old('type', $court->type?->value) === $t->value)>
                {{ $t->label() }}
            </option>
        @endforeach
    </x-form-select>

    <x-form-input name="jurisdiction" label="Jurisdiction" :value="$court->jurisdiction" />

    <x-form-input name="city" label="City" :value="$court->city" />

    <x-form-input name="phone" label="Phone" :value="$court->phone" />

    <x-form-input type="email" name="email" label="Email" :value="$court->email" />

    <div class="md:col-span-2">
        <x-form-textarea name="address" label="Address" rows="2" :value="$court->address" />
    </div>

    <div class="md:col-span-2">
        <x-form-textarea name="notes" label="Notes" rows="3" :value="$court->notes" />
    </div>

    <div class="flex items-center gap-3 md:col-span-2">
        <input type="hidden" name="is_active" value="0" />
        <input
            type="checkbox"
            name="is_active"
            id="is_active"
            value="1"
            class="size-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
            @checked(old('is_active', $court->is_active ? '1' : '0') === '1')
        />
        <label for="is_active" class="text-sm font-medium text-slate-700">Active (accept new case links)</label>
    </div>
</div>
