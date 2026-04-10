@php
    /** @var \App\Models\Client $client */
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <x-form-input name="first_name" label="First name" :value="$client->first_name" required />
    <x-form-input name="last_name" label="Last name" :value="$client->last_name" required />
    <x-form-input name="father_name" label="Father name" :value="$client->father_name" />
    <x-form-input name="mother_name" label="Mother name" :value="$client->mother_name" />
    <x-form-input name="national_id" label="National ID" :value="$client->national_id" help="Optional; must be unique if set." />
    <x-form-input type="email" name="email" label="Email" :value="$client->email" required />
    <x-form-input name="phone" label="Phone" :value="$client->phone" />
    <x-form-input type="date" name="birth_date" label="Birth date" :value="$client->birth_date?->format('Y-m-d')" />
    <x-form-input name="country" label="Country" :value="$client->country" required />
    <x-form-input name="city" label="City" :value="$client->city" />
    <div class="md:col-span-2">
        <x-form-textarea name="address" label="Address" rows="2" :value="$client->address" />
    </div>
    <div class="md:col-span-2">
        <x-form-textarea name="notes" label="Notes" rows="3" :value="$client->notes" />
    </div>
</div>
