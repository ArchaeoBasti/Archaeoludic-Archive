{{--
    Alternative Names Partial

    Usage: @include('partials.alternative-names', [
        'alternativeNames' => $model->alternativeNames,
        'vocabularyType' => 'person' // oder 'period', 'place', 'trope', etc.
    ])
--}}

<div class="mb-6">
    <h3 class="text-lg font-semibold text-[#313647] mb-4 border-b border-[#A3B087] pb-2">Alternative Names</h3>

    <div id="alternative-names-container">
        @forelse ($alternativeNames as $index => $altName)
            <div class="alt-name-row grid grid-cols-12 gap-2 mb-2">
                <div class="col-span-8">
                    <input type="text" name="alternative_names[{{ $index }}][name]" value="{{ $altName->name }}" placeholder="Alternative name"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                </div>
                <div class="col-span-3">
                    <select name="alternative_names[{{ $index }}][language]"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                        <option value="en" {{ $altName->language === 'en' ? 'selected' : '' }}>English</option>
                        <option value="de" {{ $altName->language === 'de' ? 'selected' : '' }}>German</option>
                        <option value="fr" {{ $altName->language === 'fr' ? 'selected' : '' }}>French</option>
                        <option value="es" {{ $altName->language === 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="it" {{ $altName->language === 'it' ? 'selected' : '' }}>Italian</option>
                        <option value="la" {{ $altName->language === 'la' ? 'selected' : '' }}>Latin</option>
                        <option value="grc" {{ $altName->language === 'grc' ? 'selected' : '' }}>Ancient Greek</option>
                        <option value="ar" {{ $altName->language === 'ar' ? 'selected' : '' }}>Arabic</option>
                        <option value="he" {{ $altName->language === 'he' ? 'selected' : '' }}>Hebrew</option>
                        <option value="egy" {{ $altName->language === 'egy' ? 'selected' : '' }}>Egyptian</option>
                        <option value="akk" {{ $altName->language === 'akk' ? 'selected' : '' }}>Akkadian</option>
                        <option value="sux" {{ $altName->language === 'sux' ? 'selected' : '' }}>Sumerian</option>
                    </select>
                </div>
                <div class="col-span-1 flex items-center">
                    <button type="button" onclick="removeAltName(this)" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <p id="no-alt-names" class="text-gray-500 text-sm mb-2">No alternative names yet.</p>
        @endforelse
    </div>

    <button type="button" onclick="addAltName()" class="mt-2 inline-flex items-center px-3 py-1 border border-[#A3B087] text-[#313647] text-sm rounded hover:bg-[#A3B087]/20">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Alternative Name
    </button>
</div>

<script>
    let altNameIndex = {{ $alternativeNames->count() ?? 0 }};

    function addAltName() {
        document.getElementById('no-alt-names')?.remove();

        const container = document.getElementById('alternative-names-container');
        const row = document.createElement('div');
        row.className = 'alt-name-row grid grid-cols-12 gap-2 mb-2';
        row.innerHTML = `
            <div class="col-span-8">
                <input type="text" name="alternative_names[${altNameIndex}][name]" placeholder="Alternative name"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
            </div>
            <div class="col-span-3">
                <select name="alternative_names[${altNameIndex}][language]"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#A3B087] focus:ring-[#A3B087]">
                    <option value="en">English</option>
                    <option value="de">German</option>
                    <option value="fr">French</option>
                    <option value="es">Spanish</option>
                    <option value="it">Italian</option>
                    <option value="la">Latin</option>
                    <option value="grc">Ancient Greek</option>
                    <option value="ar">Arabic</option>
                    <option value="he">Hebrew</option>
                    <option value="egy">Egyptian</option>
                    <option value="akk">Akkadian</option>
                    <option value="sux">Sumerian</option>
                </select>
            </div>
            <div class="col-span-1 flex items-center">
                <button type="button" onclick="removeAltName(this)" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;
        container.appendChild(row);
        altNameIndex++;
    }

    function removeAltName(button) {
        button.closest('.alt-name-row').remove();
    }
</script>
