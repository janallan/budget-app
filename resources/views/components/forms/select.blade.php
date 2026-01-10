<?php
    $attributes = $attributes->merge([
        'class' => 'form-select'
    ]);
?>
<div>
    <flux:select id="{{ $id }}"
            class="{{ $attributes->get('class')}}"
            {{ $attributes->except('class') }}
            placeholder="Choos {{ $label}} .."
        >
        @if (isset($options))
            @if ($hasEmptyOption)
                <option value="" {{ $hasEmptyOption ? '' : 'hidden' }}>Please select a {{ $label}}</option>
            @endif

            @foreach ($options as $ok => $ov)
                <flux:select.option
                    value="{{ isset($optionValueKey) ? $ov[$optionValueKey] : $ov }}"
                    label="{{ isset($optionLabelKey) ? $ov[$optionLabelKey] : $ok }}"
                />
            @endforeach
        @else
            {{ $slot}}
        @endif
    </flux:select>
    <flux:error name="{{ $error_key }}" />
</div>
