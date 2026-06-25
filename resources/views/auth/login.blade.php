<x-layout.app title="Entrar">
    <x-container>
        <x-card title="Entrar">
            <x-form :route="route('login')" post id="login-form">
                <x-input name="email" placeholder="E-mail" value="{{ old('email') }}" />
                <x-input name="password" type="password" placeholder="Senha" />
            </x-form>

            <div class="text-sm">
                <x-a :href="route('password.request')">Esqueci minha senha</x-a>
            </div>

            <x-slot:actions>
                <x-a :href="route('register')">Criar conta</x-a>
                <x-button form="login-form">Entrar</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>