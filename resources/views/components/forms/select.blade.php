<div>
    <flux:label class="mb-3">{{ $label }}</flux:label>

    <flux:select id="{{ $id }}"
            {{ $attributes }}
            placeholder="Choose {{ $label}} .."
        >
        @if (isset($options))
            @if ($hasEmptyOption)
                <flux:select.option value="">
                    Please select a {{ $label }}
                </flux:select.option>
            @endif

            @foreach ($options as $ok => $ov)
                <flux:select.option
                    value="{{ isset($optionValueKey) ? $ov[$optionValueKey] : $ov }}"
                >
                    {{ isset($optionLabelKey) ? $ov[$optionLabelKey] : $ok }}
                </flux:select.option>
            @endforeach
        @else
            {{ $slot}}
        @endif
    </flux:select>
    <flux:error name="{{ $error_key }}" />
</div>
