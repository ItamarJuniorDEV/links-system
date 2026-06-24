<header class="navbar bg-base-100 border-b border-base-300 px-4 sm:px-8">
    <div class="navbar-start">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-lg font-semibold tracking-tight">
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-primary-content shrink-0">
                <x-icons.link class="w-5 h-5" />
            </span>
            <span><span class="text-primary">Links</span>System</span>
        </a>
    </div>

    <div class="navbar-end">
        {{-- Desktop --}}
        <nav class="hidden sm:flex items-center gap-1">
            @auth
                <x-button color="ghost" size="sm" :href="route('dashboard')">Início</x-button>
                <x-button color="ghost" size="sm" :href="route('links.create')">Novo link</x-button>
                <x-button color="ghost" size="sm" :href="route('profile')">Perfil</x-button>
                <x-button color="ghost" size="sm" :href="route('logout')">Sair</x-button>
            @else
                <x-button color="ghost" size="sm" :href="route('login')">Entrar</x-button>
                <x-button color="primary" size="sm" :href="route('register')">Criar conta</x-button>
            @endauth
        </nav>

        {{-- Mobile --}}
        <div class="dropdown dropdown-end sm:hidden">
            <div tabindex="0" role="button" class="btn btn-ghost btn-square" aria-label="Abrir menu">
                <x-icons.menu class="w-6 h-6" />
            </div>
            <ul tabindex="0"
                class="menu dropdown-content mt-2 z-10 w-52 gap-1 rounded-box border border-base-300 bg-base-100 p-2 shadow-lg">
                @auth
                    <li><a href="{{ route('dashboard') }}">Início</a></li>
                    <li><a href="{{ route('links.create') }}">Novo link</a></li>
                    <li><a href="{{ route('profile') }}">Perfil</a></li>
                    <li><a href="{{ route('logout') }}">Sair</a></li>
                @else
                    <li><a href="{{ route('login') }}">Entrar</a></li>
                    <li><a href="{{ route('register') }}" class="text-primary font-medium">Criar conta</a></li>
                @endauth
            </ul>
        </div>
    </div>
</header>
