{{--
    LOD Field with SKOS Mapping Partial

    Usage: @include('partials.lod-field', [
        'name' => 'gnd',
        'label' => 'GND',
        'value' => $person->gnd_id,
        'mappingValue' => $person->gnd_mapping,
        'mappingTypes' => $mappingTypes,
        'urlPrefix' => 'https://d-nb.info/gnd/',
        'placeholder' => 'e.g. 118598461'
    ])
--}}

<div class="grid grid-cols-3 gap-4 mb-4">
    <div class="col-span-2">
        <label for="{{ $name }}_id" class="block text-sm font-medium text-[#313647]">{{ $label }} ID</label>
        <input type="text" name="{{ $name }}_id" id="{{ $name }}_id" value="{{ $value ?? '' }}" placeholder="{{ $placeholder ?? '' }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
        @if (!empty($value))
            <a href="{{ $urlPrefix }}{{ $value }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">View in {{ $label }} ↗</a>
        @endif
    </div>
    <div>
        <label for="{{ $name }}_mapping" class="block text-sm font-medium text-[#313647]">SKOS Mapping</label>
        <select name="{{ $name }}_mapping" id="{{ $name }}_mapping"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
            <option value="">-- Select --</option>
            @foreach ($mappingTypes as $type)
                <option value="{{ $type }}" {{ ($mappingValue ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>
</div>
