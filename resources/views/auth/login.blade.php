<x-layout.app>
    <x-container>
        <x-card title="Login">
            <x-form :route="route('login')" post id="login-form">
                <x-input name="email" placeholder="E-mail" value="{{ old('email') }}" />
                <x-input name="password" type="password" placeholder="Senha" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('register')">Criar conta</x-a>
                <x-button form="login-form">Entrar</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>