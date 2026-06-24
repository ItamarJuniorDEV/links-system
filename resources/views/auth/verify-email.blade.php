<x-layout.app title="Verifique seu e-mail">
    <x-container>
        <x-card title="Confirme seu e-mail">
            <p class="text-base-content/70">
                Enviamos um link de verificação para o seu e-mail. Clique nele para ativar a conta.
                Se não recebeu, dá pra reenviar abaixo.
            </p>

            <x-slot:actions>
                <x-a :href="route('logout')">Sair</x-a>

                <x-form :route="route('verification.send')" post>
                    <x-button>Reenviar link</x-button>
                </x-form>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>
