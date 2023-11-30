<nav x-data="{ open: false }" class="bg-purple-800 border-b border-gray-300">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block w-auto h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:block md:flex lg:flex xl:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-white ">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('departmentshow') }}" :active="request()->routeIs('departmentshow')" class="text-white ">
                        {{ __('ดูรหัสหน่วย') }}
                    </x-nav-link>

                    @if(Auth::user()->isAdmin())
                    <x-nav-link href="{{ route('department') }}" :active="request()->routeIs('department')" class="text-white ">
                        {{ __('จัดการหน่วย') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('battalion') }}" :active="request()->routeIs('battalion')"  class="text-white ">
                        {{ __('จัดการหน่วยกองพัน') }}
                     </x-nav-link>
                    <x-nav-link href="{{ route('userlist.index') }}" :active="request()->routeIs('userlist.index')"  class="text-white ">
                        {{ __('รายชื่อผู้ใช้งาน') }}
                    </x-nav-link>
                    @endif


                    <div class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white text-gray-500 transition duration-150 ease-in-out border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <span class="inline-flex ">
                                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                    {{ __('ข้อมูลกำลังพล') }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>

                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('เลือกข้อมูล') }}
                                </div>
                                <hr class="border border-2 opacity-80">
                                <x-dropdown-link href="{{ route('cco') }}" :active="request()->routeIs('cco')"  class="text-black ">
                                    {{ __('ข้อมูลนายทหาร') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('nco') }}" :active="request()->routeIs('nco')"  class="text-black ">
                                    {{ __('ข้อมูลนายสิบ') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('soldier') }}" :active="request()->routeIs('soldier')"  class="text-black">
                                    {{ __('ข้อมูลพลทหาร') }}
                                </x-dropdown-link>

                                {{-- <x-nav-link href="{{ route('cco') }}" :active="request()->routeIs('cco')"  class="text-black ">
                                    {{ __('ข้อมูลนายทหาร') }}
                                </x-nav-link>

                                <x-nav-link href="{{ route('nco') }}" :active="request()->routeIs('nco')"  class="text-black ">
                                    {{ __('ข้อมูลนายสิบ') }}
                                 </x-nav-link>

                                <x-nav-link href="{{ route('soldier') }}" :active="request()->routeIs('soldier')"  class="text-black">
                                   {{ __('ข้อมูลพลทหาร') }}
                                </x-nav-link> --}}

                            </div>
                        </x-slot>
                    </x-dropdown>
                    </div>
                    <div class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white text-gray-500 transition duration-150 ease-in-out border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <span class="inline-flex ">
                                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                    {{ __('ข้อมูล ม.35') }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>

                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('เลือกข้อมูล') }}
                                </div>
                                <hr class="border border-2 opacity-80">

                                <x-dropdown-link href="{{ route('law') }}" :active="request()->routeIs('law')"  class="text-black ">
                                    {{ __('ข้อมูล ม.35') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('pay') }}" :active="request()->routeIs('pay')"  class="text-black ">
                                    {{ __('ข้อมูลผู้รับสิทธิ์') }}
                                </x-dropdown-link>

                                {{-- <x-nav-link href="{{ route('law') }}" :active="request()->routeIs('law')"  class="text-white ">
                                    {{ __('ข้อมูล ม.35') }}
                                 </x-nav-link>

                                 <x-nav-link href="{{ route('pay') }}" :active="request()->routeIs('pay')"  class="text-white ">
                                    {{ __('ข้อมูลผู้รับสิทธิ์') }}
                                 </x-nav-link> --}}

                            </div>
                        </x-slot>
                    </x-dropdown>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="relative ml-3">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-8 h-8 rounded-full" src="{{ asset ('storage/'.Auth::user()->profile_photo_path ) }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-white duration-150 ease-in-out border border-transparent rounded-md transittion hover:text-gray-700 focus:outline-none active:bg-gray-50">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden ">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-xl text-yellow-500">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 mx-3 space-y-1">
            <x-nav-link href="{{ route('cco') }}" :active="request()->routeIs('cco')"  class="text-xl text-yellow-500">
                {{ __('ข้อมูลนายทหาร') }}
            </x-nav-link>
        </div>
        <div class="pt-2 pb-3 mx-3 space-y-1">
            <x-nav-link href="{{ route('nco') }}" :active="request()->routeIs('nco')"  class="text-xl text-yellow-500 ">
                {{ __('ข้อมูลนายสิบ') }}
            </x-nav-link>
        </div>
        <div class="pt-2 pb-3 mx-3 space-y-1">
            <x-nav-link href="{{ route('soldier') }}" :active="request()->routeIs('soldier')"  class="text-xl text-yellow-500 ">
                {{ __('ข้อมูลพลทหาร') }}
            </x-nav-link>
        </div>
        <div class="pt-2 pb-3 mx-3 space-y-1">
            <x-nav-link href="{{ route('law') }}" :active="request()->routeIs('law')"  class="text-xl text-yellow-500 ">
                {{ __('ข้อมูล ม.35') }}
            </x-nav-link>
        </div>
        <div class="pt-2 pb-3 mx-3 space-y-1">
            <x-nav-link href="{{ route('pay') }}" :active="request()->routeIs('pay')"  class="text-xl text-yellow-500 ">
                {{ __('ข้อมูลผู้รับสิทธิ์') }}
            </x-nav-link>
        </div>


        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="mr-3 shrink-0">
                        <img class="object-cover w-10 h-10 rounded-full" src="{{ asset ('storage/'.Auth::user()->profile_photo_path ) }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-white">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }} "
                                   @click.prevent="$root.submit();" class="text-white">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
