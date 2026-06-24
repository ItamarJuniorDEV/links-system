@props(['code', 'title', 'message'])

<x-layout.app :title="$title">
    <x-container>
        <div class="text-center space-y-4 py-10 max-w-md mx-auto">
            <p class="text-7xl font-extrabold text-primary">{{ $code }}</p>
            <h1 class="text-2xl font-semibold">{{ $title }}</h1>
            <p class="text-base-content/60">{{ $message }}</p>
            <div class="pt-2">
                <x-button color="primary" :href="url('/')">Voltar ao início</x-button>
            </div>
        </div>
    </x-container>
</x-layout.app>
