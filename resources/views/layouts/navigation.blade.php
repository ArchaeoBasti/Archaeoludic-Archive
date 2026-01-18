<nav x-data="{ open: false, vocabOpen: false }" class="bg-archive-olive border-b border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('games')" :active="request()->routeIs('games')">
                        {{ __('Games') }}
                    </x-nav-link>

                    <!-- Vocabulary Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out {{ request()->routeIs('periods.*') || request()->routeIs('places.*') || request()->routeIs('gameplay-modes.*') || request()->routeIs('player-roles.*') ? 'border-b-2 border-[#A3B087]' : '' }}">
                            {{ __('Vocabulary') }}
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <a href="{{ route('periods.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Periods
                                </a>
                                <a href="{{ route('places.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Places
                                </a>
                                <a href="{{ route('gameplay-modes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Gameplay Modes
                                </a>
                                <a href="{{ route('player-roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Player Roles
                                </a>
                                <a href="{{ route('tropes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Tropes
                                </a>
                                <a href="{{ route('persons.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Historical Persons
                                </a>
                            </div>
                        </div>
                    </div>

                    <x-nav-link :href="route('bibliography')" :active="request()->routeIs('bibliography')">
                        {{ __('Bibliography') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown (nur für eingeloggte User) -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('register')">
                                    {{ __('Register New User') }}
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('games')" :active="request()->routeIs('games')">
                {{ __('Games') }}
            </x-responsive-nav-link>

            <!-- Vocabulary Links (Mobile) -->
            <div class="border-t border-gray-600 pt-2 mt-2">
                <div class="px-4 py-1 text-xs font-semibold text-gray-400 uppercase">Vocabulary</div>
                <x-responsive-nav-link :href="route('periods.index')" :active="request()->routeIs('periods.*')">
                    {{ __('Periods') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('places.index')" :active="request()->routeIs('places.*')">
                    {{ __('Places') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('gameplay-modes.index')" :active="request()->routeIs('gameplay-modes.*')">
                    {{ __('Gameplay Modes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('player-roles.index')" :active="request()->routeIs('player-roles.*')">
                    {{ __('Player Roles') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tropes.index')" :active="request()->routeIs('tropes.*')">
                    {{ __('Tropes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('persons.index')" :active="request()->routeIs('persons.*')">
                    {{ __('Historical Persons') }}
                </x-responsive-nav-link>
            </div>

            <x-responsive-nav-link :href="route('bibliography')" :active="request()->routeIs('bibliography')">
                {{ __('Bibliography') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About') }}
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                  <x-responsive-nav-link :href="route('dashboard')">
                      {{ __('Dashboard') }}
                  </x-responsive-nav-link>

                  <x-responsive-nav-link :href="route('profile.edit')">
                      {{ __('Profile') }}
                  </x-responsive-nav-link>

                    @if (Auth::user()->role === 'admin')
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register New User') }}
                        </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>
