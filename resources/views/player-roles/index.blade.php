<x-app-layout>
    <!-- Header im Stil der Startseite -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                    Player Roles
                </h1>
                @auth
                    <a href="{{ route('player-roles.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#A3B087] text-[#313647] font-semibold rounded-lg hover:bg-[#FFF8D4] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Role
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="font-medium">{{ $playerRoles->count() }} Roles</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="space-y-4">
                        @foreach ($playerRoles as $role)
                            <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <span class="text-xs text-gray-400">{{ $role->identifier }}</span>
                                    <h4 class="font-medium text-[#313647]">
                                        <a href="{{ route('player-roles.show', $role) }}" class="hover:text-[#435663] transition-colors">
                                            {{ $role->label_en }}
                                        </a>
                                    </h4>
                                    @if ($role->description_en)
                                        <p class="text-[#435663] text-sm mt-1">{{ Str::limit($role->description_en, 200) }}</p>
                                    @endif
                                </div>
                                @auth
                                    <a href="{{ route('player-roles.edit', $role) }}" class="text-blue-600 hover:underline ml-4">
                                        Edit
                                    </a>
                                @endauth
                            </div>
                        @endforeach
                    </div>

                    @if ($playerRoles->isEmpty())
                        <p class="text-gray-400">No player roles defined yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
