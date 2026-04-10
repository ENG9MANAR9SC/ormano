@props([
    'label',
    'name',
    'value' => null,
    'required' => false,
    'rows' => 4,
])

@php
    $id = $attributes->get('id', str_replace(['[', ']'], '_', $name));
@endphp

<div class="space-y-1">
    <label for="{{ $id }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
        @if ($required)
            <span class="text-red-500" aria-hidden="true">*</span>
        @endif
    </label>
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        @if ($required) required @endif
        {{ $attributes->class([
            'block w-full rounded-xl border px-3 py-2 text-sm shadow-sm transition',
            'border-slate-200 bg-white text-slate-900 placeholder:text-slate-400',
            'focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20',
            'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has($name),
        ]) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
