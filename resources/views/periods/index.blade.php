<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Periods
                </h1>
                @auth
                    <a href="{{ route('periods.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Period
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Gelber Streifen mit Statistik -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6 text-[#313647]">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ $periods->count() }} Periods</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#435663]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <span class="font-medium">{{ $topLevelPeriods->count() }} Top-Level</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Section (Full Width) - Hidden on mobile -->
    <div class="hidden md:block bg-gray-100 border-b border-gray-200">
        <div class="w-full">
            <div class="bg-white overflow-visible border-y border-gray-200">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center max-w-7xl mx-auto">
                    <h2 class="font-semibold text-[#313647]">Timeline Overview (10,000 BCE – Today)</h2>
                    <div class="flex gap-4">
                        <button
                            onclick="zoomTimeline('out')"
                            class="text-sm text-[#435663] hover:text-[#313647] px-2 py-1 border border-gray-300 rounded hover:bg-gray-100"
                            title="Zoom Out"
                        >
                            −
                        </button>
                        <button
                            onclick="zoomTimeline('in')"
                            class="text-sm text-[#435663] hover:text-[#313647] px-2 py-1 border border-gray-300 rounded hover:bg-gray-100"
                            title="Zoom In"
                        >
                            +
                        </button>
                        <button
                            onclick="resetTimeline()"
                            class="text-sm text-[#435663] hover:text-[#313647] underline"
                        >
                            Reset View
                        </button>
                    </div>
                </div>
                <div id="timeline-wrapper" class="relative">
                    <div id="timeline-container" class="overflow-x-auto overflow-y-visible relative cursor-grab active:cursor-grabbing">
                        <div id="timeline-content" class="relative" style="min-width: 100%;">
                            <!-- Timeline will be rendered here by JavaScript -->
                        </div>
                    </div>
                    <div id="timeline-tooltip" class="timeline-tooltip"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <!-- Expand/Collapse All Controls -->
                    <div class="flex gap-4 mb-6" x-data>
                        <button
                            @click="$dispatch('expand-all')"
                            class="text-sm text-[#435663] hover:text-[#313647] underline"
                        >
                            Expand All
                        </button>
                        <button
                            @click="$dispatch('collapse-all')"
                            class="text-sm text-[#435663] hover:text-[#313647] underline"
                        >
                            Collapse All
                        </button>
                    </div>

                    @foreach ($topLevelPeriods as $period)
                        <div
                            class="mb-4"
                            x-data="{ open: false }"
                            @expand-all.window="open = true"
                            @collapse-all.window="open = false"
                        >
                            <!-- Accordion Header -->
                            <button
                                @click="open = !open"
                                class="w-full flex justify-between items-center text-lg font-semibold text-[#313647] border-b border-[#A3B087] pb-2 hover:text-[#435663] transition-colors text-left"
                            >
                                <span class="flex items-center gap-3">
                                    {{ $period->label_en }}
                                    <span class="text-sm font-normal text-gray-500">
                                        ({{ $period->children->count() + 1 }} {{ $period->children->count() + 1 === 1 ? 'entry' : 'entries' }})
                                    </span>
                                </span>
                                <svg
                                    class="w-5 h-5 transform transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Accordion Content -->
                            <div
                                x-show="open"
                                x-collapse
                                x-cloak
                                class="mt-4"
                            >
                                <!-- Top-Level Period -->
                                <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200 mb-2">
                                    <div class="flex-1">
                                        <span class="text-xs text-gray-400">{{ $period->identifier }}</span>
                                        <h4 class="font-medium text-[#313647]">
                                            <a href="{{ route('periods.show', $period) }}" class="hover:text-[#435663] transition-colors">
                                                {{ $period->label_en }}
                                            </a>
                                        </h4>
                                        @if ($period->start_year || $period->end_year)
                                            <p class="text-sm text-[#435663]">
                                                @if ($period->start_year)
                                                    {{ $period->start_year < 0 ? abs($period->start_year) . ' BCE' : $period->start_year . ' CE' }}{{ $period->start_uncertain ? '?' : '' }}
                                                @else
                                                    ?
                                                @endif
                                                –
                                                @if ($period->end_year)
                                                    {{ $period->end_year < 0 ? abs($period->end_year) . ' BCE' : $period->end_year . ' CE' }}{{ $period->end_uncertain ? '?' : '' }}
                                                @else
                                                    ?
                                                @endif
                                            </p>
                                        @endif
                                        @if ($period->description_en)
                                            <p class="text-[#435663] text-sm mt-1">{{ Str::limit($period->description_en, 200) }}</p>
                                        @endif
                                    </div>
                                    @auth
                                        <a href="{{ route('periods.edit', $period) }}" class="text-blue-600 hover:underline ml-4">
                                            Edit
                                        </a>
                                    @endauth
                                </div>

                                <!-- Second Level (Children) -->
                                @if ($period->children->count() > 0)
                                    <div class="ml-6 space-y-2">
                                        @foreach ($period->children->sortBy('start_year') as $child)
                                            <div class="flex justify-between items-start p-4 bg-white rounded-lg border border-gray-200">
                                                <div class="flex-1">
                                                    <span class="text-xs text-gray-400">{{ $child->identifier }}</span>
                                                    <h4 class="font-medium text-[#313647]">
                                                        <a href="{{ route('periods.show', $child) }}" class="hover:text-[#435663] transition-colors">
                                                            {{ $child->label_en }}
                                                        </a>
                                                    </h4>
                                                    @if ($child->start_year || $child->end_year)
                                                        <p class="text-sm text-[#435663]">
                                                            @if ($child->start_year)
                                                                {{ $child->start_year < 0 ? abs($child->start_year) . ' BCE' : $child->start_year . ' CE' }}{{ $child->start_uncertain ? '?' : '' }}
                                                            @else
                                                                ?
                                                            @endif
                                                            –
                                                            @if ($child->end_year)
                                                                {{ $child->end_year < 0 ? abs($child->end_year) . ' BCE' : $child->end_year . ' CE' }}{{ $child->end_uncertain ? '?' : '' }}
                                                            @else
                                                                ?
                                                            @endif
                                                        </p>
                                                    @endif
                                                    @if ($child->description_en)
                                                        <p class="text-[#435663] text-sm mt-1">{{ Str::limit($child->description_en, 200) }}</p>
                                                    @endif
                                                </div>
                                                @auth
                                                    <a href="{{ route('periods.edit', $child) }}" class="text-blue-600 hover:underline ml-4">
                                                        Edit
                                                    </a>
                                                @endauth
                                            </div>

                                            <!-- Third Level (Grandchildren) -->
                                            @if ($child->children->count() > 0)
                                                <div class="ml-6 space-y-2">
                                                    @foreach ($child->children->sortBy('start_year') as $grandchild)
                                                        <div class="flex justify-between items-start p-4 bg-gray-100 rounded-lg border border-gray-200">
                                                            <div class="flex-1">
                                                                <span class="text-xs text-gray-400">{{ $grandchild->identifier }}</span>
                                                                <h4 class="font-medium text-[#313647]">
                                                                    <a href="{{ route('periods.show', $grandchild) }}" class="hover:text-[#435663] transition-colors">
                                                                        {{ $grandchild->label_en }}
                                                                    </a>
                                                                </h4>
                                                                @if ($grandchild->start_year || $grandchild->end_year)
                                                                    <p class="text-sm text-[#435663]">
                                                                        @if ($grandchild->start_year)
                                                                            {{ $grandchild->start_year < 0 ? abs($grandchild->start_year) . ' BCE' : $grandchild->start_year . ' CE' }}{{ $grandchild->start_uncertain ? '?' : '' }}
                                                                        @else
                                                                            ?
                                                                        @endif
                                                                        –
                                                                        @if ($grandchild->end_year)
                                                                            {{ $grandchild->end_year < 0 ? abs($grandchild->end_year) . ' BCE' : $grandchild->end_year . ' CE' }}{{ $grandchild->end_uncertain ? '?' : '' }}
                                                                        @else
                                                                            ?
                                                                        @endif
                                                                    </p>
                                                                @endif
                                                                @if ($grandchild->description_en)
                                                                    <p class="text-[#435663] text-sm mt-1">{{ Str::limit($grandchild->description_en, 200) }}</p>
                                                                @endif
                                                            </div>
                                                            @auth
                                                                <a href="{{ route('periods.edit', $grandchild) }}" class="text-blue-600 hover:underline ml-4">
                                                                    Edit
                                                                </a>
                                                            @endauth
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if ($periods->isEmpty())
                        <p class="text-gray-400">No periods defined yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .timeline-bar {
                transition: all 0.2s ease;
            }
            .timeline-bar:hover {
                filter: brightness(1.1);
                transform: scaleY(1.1);
            }
            .timeline-tooltip {
                position: absolute;
                background: #313647;
                color: #FFF8D4;
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 12px;
                white-space: nowrap;
                z-index: 1000;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.2s;
            }
            .timeline-tooltip.visible {
                opacity: 1;
            }
            .timeline-tooltip::after {
                content: '';
                position: absolute;
                top: 100%;
                left: 50%;
                transform: translateX(-50%);
                border: 6px solid transparent;
                border-top-color: #313647;
            }
            #timeline-wrapper {
                overflow: visible;
            }
            #timeline-container::-webkit-scrollbar {
                height: 0;
                display: none;
            }
            #timeline-container {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Period data from Laravel (only periods with start_year)
            const periods = [
                @foreach($periods as $p)
                    @if($p->start_year)
                    {
                        id: {{ $p->id }},
                        label: "{{ addslashes($p->label_en) }}",
                        start: {{ $p->start_year }},
                        end: {{ $p->end_year ?? $p->start_year }},
                        startUncertain: {{ $p->start_uncertain ? 'true' : 'false' }},
                        endUncertain: {{ $p->end_uncertain ? 'true' : 'false' }},
                        level: {{ $p->parent_id ? ($p->parent->parent_id ? 2 : 1) : 0 }},
                        parentId: {{ $p->parent_id ?? 'null' }},
                        url: "{{ route('periods.show', $p) }}",
                        identifier: "{{ $p->identifier }}"
                    },
                    @endif
                @endforeach
            ];

            // Color palette for different top-level periods
            const colors = [
                '#313647', // Dark blue-gray
                '#435663', // Steel blue
                '#5c6b73', // Slate
                '#6b7c5e', // Olive
                '#7d6b5e', // Brown
                '#5e6b7d', // Blue-gray
                '#6b5e7d', // Purple-gray
            ];

            let zoomLevel = 1;
            let isDragging = false;
            let startX, scrollLeft;

            const container = document.getElementById('timeline-container');
            const content = document.getElementById('timeline-content');

            function formatYear(year, uncertain = false) {
                const suffix = uncertain ? '?' : '';
                if (year < 0) {
                    return Math.abs(year).toLocaleString() + ' BCE' + suffix;
                }
                return year.toLocaleString() + ' CE' + suffix;
            }

            function renderTimeline() {
                if (periods.length === 0) {
                    content.innerHTML = '<p class="text-gray-400 p-4">No periods with dates defined yet.</p>';
                    return;
                }

                // Fixed scale: 10,000 BCE to current year
                const minYear = -10000;
                const maxYear = new Date().getFullYear();
                const totalSpan = maxYear - minYear;

                // Filter periods that fall within our range
                const visiblePeriods = periods.filter(p => {
                    return p.end >= minYear && p.start <= maxYear;
                }).map(p => ({
                    ...p,
                    displayStart: Math.max(p.start, minYear),
                    displayEnd: Math.min(p.end, maxYear)
                }));

                // Calculate width based on zoom
                const baseWidth = container.clientWidth;
                const contentWidth = Math.max(baseWidth, baseWidth * zoomLevel);
                content.style.width = contentWidth + 'px';

                // Horizontal padding (approximately bar height)
                const horizontalPadding = 14;
                const usableWidth = contentWidth - (2 * horizontalPadding);

                // Helper function to convert year to pixel position with padding
                function yearToPercent(year) {
                    const relativePos = (year - minYear) / totalSpan;
                    const pixelPos = horizontalPadding + (relativePos * usableWidth);
                    return (pixelPos / contentWidth) * 100;
                }

                // Group by top-level parent, sorted by start date
                const topLevelPeriods = visiblePeriods.filter(p => p.level === 0).sort((a, b) => a.displayStart - b.displayStart);

                // Build hierarchical groups
                const groups = topLevelPeriods.map((topLevel, index) => {
                    const children = visiblePeriods.filter(p => p.parentId === topLevel.id).sort((a, b) => a.displayStart - b.displayStart);
                    const grandchildren = visiblePeriods.filter(p => {
                        const parent = periods.find(pp => pp.id === p.parentId);
                        return parent && parent.parentId === topLevel.id;
                    }).sort((a, b) => a.displayStart - b.displayStart);

                    return {
                        topLevel,
                        children,
                        grandchildren,
                        colorIndex: index
                    };
                });

                // Layout settings
                const rowHeight = 12;
                const rowGap = 2;
                const groupGap = 14;
                const topPadding = 15;
                const axisHeight = 30;
                const axisPadding = 50;

                // Function to calculate rows needed for overlapping periods
                // Allows 1-year overlap (e.g., 500-1000 and 1000-1500 can be on same row)
                function calculateRows(items) {
                    if (items.length === 0) return { rows: [], rowCount: 0 };

                    const rows = []; // Each row tracks its end year
                    const itemRows = []; // Which row each item is in

                    items.forEach((item, idx) => {
                        const startYear = item.displayStart;
                        const endYear = item.displayEnd;

                        // Find first row where this item fits
                        // Allow overlap of up to 1 year (startYear >= endYear of previous - 1)
                        let rowIndex = 0;
                        for (let i = 0; i < rows.length; i++) {
                            if (startYear >= rows[i] - 1) {
                                rowIndex = i;
                                break;
                            }
                            rowIndex = i + 1;
                        }

                        // Assign to row
                        rows[rowIndex] = endYear;
                        itemRows.push(rowIndex);
                    });

                    return {
                        itemRows,
                        rowCount: rows.length
                    };
                }

                // Calculate positions for each group
                let currentTop = topPadding;
                const groupLayouts = [];

                groups.forEach(group => {
                    const layout = { topLevelTop: currentTop };

                    // Top level always 1 row
                    currentTop += rowHeight + rowGap;

                    // Children with overlap handling
                    if (group.children.length > 0) {
                        const childRows = calculateRows(group.children);
                        layout.childrenTop = currentTop;
                        layout.childrenRows = childRows.itemRows;
                        currentTop += childRows.rowCount * (rowHeight + rowGap);
                    }

                    // Grandchildren with overlap handling
                    if (group.grandchildren.length > 0) {
                        const grandchildRows = calculateRows(group.grandchildren);
                        layout.grandchildrenTop = currentTop;
                        layout.grandchildrenRows = grandchildRows.itemRows;
                        currentTop += grandchildRows.rowCount * (rowHeight + rowGap);
                    }

                    currentTop += groupGap;
                    groupLayouts.push(layout);
                });

                const totalHeight = currentTop + axisHeight;
                content.style.height = totalHeight + 'px';

                // Build HTML
                let html = '';

                // Add vertical guide lines for each top-level period (in background)
                groups.forEach((group) => {
                    const topLevel = group.topLevel;
                    const startPercent = yearToPercent(topLevel.displayStart);
                    const endPercent = yearToPercent(topLevel.displayEnd);

                    // Start line
                    html += `<div class="absolute top-0 w-px bg-gray-200" style="left: ${startPercent}%; height: calc(100% - ${axisHeight}px);"></div>`;
                    // End line
                    html += `<div class="absolute top-0 w-px bg-gray-200" style="left: ${endPercent}%; height: calc(100% - ${axisHeight}px);"></div>`;
                });

                // Add time axis at bottom
                html += `<div class="absolute left-0 right-0 h-8 border-t border-gray-300 bg-gray-50" style="bottom: 0;">`;

                const pixelsPerYear = usableWidth / totalSpan;
                let tickInterval = 1000;
                if (pixelsPerYear > 0.5) tickInterval = 500;
                if (pixelsPerYear > 1) tickInterval = 200;
                if (pixelsPerYear > 2) tickInterval = 100;
                if (pixelsPerYear > 5) tickInterval = 50;
                if (pixelsPerYear < 0.2) tickInterval = 2000;
                if (pixelsPerYear < 0.1) tickInterval = 5000;

                const firstTick = Math.ceil(minYear / tickInterval) * tickInterval;
                for (let year = firstTick; year <= maxYear; year += tickInterval) {
                    const pos = yearToPercent(year);
                    const pixelPos = (pos / 100) * contentWidth;

                    if (pixelPos < axisPadding && year === firstTick) continue;
                    if (pixelPos > contentWidth - axisPadding && year + tickInterval > maxYear) continue;

                    html += `<div class="absolute text-xs text-gray-500" style="left: ${pos}%; transform: translateX(-50%); top: 4px;">
                        ${formatYear(year)}
                    </div>`;
                    html += `<div class="absolute w-px h-2 bg-gray-300" style="left: ${pos}%; top: 0;"></div>`;
                }
                html += '</div>';

                // Render each group
                groups.forEach((group, groupIndex) => {
                    const layout = groupLayouts[groupIndex];
                    const color = colors[group.colorIndex % colors.length];
                    const borderColor = '#FFF8D4';

                    // Render top-level
                    const topLevel = group.topLevel;
                    const tlStartPos = yearToPercent(topLevel.displayStart);
                    const tlEndPos = yearToPercent(topLevel.displayEnd);
                    const tlWidth = Math.max(tlEndPos - tlStartPos, 0.3);

                    html += `<a href="${topLevel.url}"
                        class="timeline-bar absolute rounded cursor-pointer block"
                        style="left: ${tlStartPos}%; width: ${tlWidth}%; height: ${rowHeight}px; top: ${layout.topLevelTop}px; background-color: ${color}; border: 1px solid ${borderColor}; box-sizing: border-box;"
                        data-label="${topLevel.label}"
                        data-start="${formatYear(topLevel.start, topLevel.startUncertain)}"
                        data-end="${formatYear(topLevel.end, topLevel.endUncertain)}"
                        onmouseenter="showTooltip(event, this)"
                        onmouseleave="hideTooltip()"
                        onmousemove="moveTooltip(event)"
                    ></a>`;

                    // Render children
                    if (group.children.length > 0) {
                        group.children.forEach((child, idx) => {
                            const startPos = yearToPercent(child.displayStart);
                            const endPos = yearToPercent(child.displayEnd);
                            const width = Math.max(endPos - startPos, 0.3);
                            const rowOffset = layout.childrenRows[idx] * (rowHeight + rowGap);
                            const top = layout.childrenTop + rowOffset;

                            html += `<a href="${child.url}"
                                class="timeline-bar absolute rounded cursor-pointer block"
                                style="left: ${startPos}%; width: ${width}%; height: ${rowHeight}px; top: ${top}px; background-color: ${color}; opacity: 0.75; border: 1px solid ${borderColor}; box-sizing: border-box;"
                                data-label="${child.label}"
                                data-start="${formatYear(child.start, child.startUncertain)}"
                                data-end="${formatYear(child.end, child.endUncertain)}"
                                onmouseenter="showTooltip(event, this)"
                                onmouseleave="hideTooltip()"
                                onmousemove="moveTooltip(event)"
                            ></a>`;
                        });
                    }

                    // Render grandchildren
                    if (group.grandchildren.length > 0) {
                        group.grandchildren.forEach((grandchild, idx) => {
                            const startPos = yearToPercent(grandchild.displayStart);
                            const endPos = yearToPercent(grandchild.displayEnd);
                            const width = Math.max(endPos - startPos, 0.3);
                            const rowOffset = layout.grandchildrenRows[idx] * (rowHeight + rowGap);
                            const top = layout.grandchildrenTop + rowOffset;

                            html += `<a href="${grandchild.url}"
                                class="timeline-bar absolute rounded cursor-pointer block"
                                style="left: ${startPos}%; width: ${width}%; height: ${rowHeight}px; top: ${top}px; background-color: ${color}; opacity: 0.55; border: 1px solid ${borderColor}; box-sizing: border-box;"
                                data-label="${grandchild.label}"
                                data-start="${formatYear(grandchild.start, grandchild.startUncertain)}"
                                data-end="${formatYear(grandchild.end, grandchild.endUncertain)}"
                                onmouseenter="showTooltip(event, this)"
                                onmouseleave="hideTooltip()"
                                onmousemove="moveTooltip(event)"
                            ></a>`;
                        });
                    }
                });

                content.innerHTML = html;
            }

            function showTooltip(event, element) {
                const tooltip = document.getElementById('timeline-tooltip');
                const label = element.dataset.label;
                const start = element.dataset.start;
                const end = element.dataset.end;
                tooltip.innerHTML = `<strong>${label}</strong><br>${start} – ${end}`;
                tooltip.classList.add('visible');
                moveTooltip(event);
            }

            function moveTooltip(event) {
                const tooltip = document.getElementById('timeline-tooltip');
                const wrapper = document.getElementById('timeline-wrapper');
                const wrapperRect = wrapper.getBoundingClientRect();

                // Position relative to wrapper, accounting for scroll
                let x = event.clientX - wrapperRect.left;
                let y = event.clientY - wrapperRect.top;

                // Center tooltip horizontally on cursor
                let tooltipX = x - (tooltip.offsetWidth / 2);
                let tooltipY = y - tooltip.offsetHeight - 10;

                // Keep tooltip within viewport horizontally
                const minX = -wrapperRect.left;
                const maxX = window.innerWidth - wrapperRect.left - tooltip.offsetWidth;
                tooltipX = Math.max(minX, Math.min(tooltipX, maxX));

                // If tooltip would go above viewport, show below cursor
                if (event.clientY - tooltip.offsetHeight - 10 < 0) {
                    tooltipY = y + 25;
                }

                tooltip.style.left = tooltipX + 'px';
                tooltip.style.top = tooltipY + 'px';
            }

            function hideTooltip() {
                const tooltip = document.getElementById('timeline-tooltip');
                tooltip.classList.remove('visible');
            }

            function zoomTimeline(direction) {
                const oldZoom = zoomLevel;
                if (direction === 'in') {
                    zoomLevel = Math.min(zoomLevel * 1.5, 20);
                } else {
                    zoomLevel = Math.max(zoomLevel / 1.5, 1);
                }

                // Maintain scroll position relative to center
                const scrollCenter = container.scrollLeft + container.clientWidth / 2;
                const scrollRatio = scrollCenter / (container.clientWidth * oldZoom);

                renderTimeline();

                container.scrollLeft = (scrollRatio * container.clientWidth * zoomLevel) - container.clientWidth / 2;
            }

            function resetTimeline() {
                zoomLevel = 1;
                renderTimeline();
                container.scrollLeft = 0;
            }

            // Drag to scroll
            container.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.pageX - container.offsetLeft;
                scrollLeft = container.scrollLeft;
                container.style.cursor = 'grabbing';
            });

            container.addEventListener('mouseleave', () => {
                isDragging = false;
                container.style.cursor = 'grab';
            });

            container.addEventListener('mouseup', () => {
                isDragging = false;
                container.style.cursor = 'grab';
            });

            container.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const x = e.pageX - container.offsetLeft;
                const walk = (x - startX) * 1.5;
                container.scrollLeft = scrollLeft - walk;
            });

            // Initial render
            document.addEventListener('DOMContentLoaded', renderTimeline);
            window.addEventListener('resize', renderTimeline);
        </script>
    @endpush
</x-app-layout>
