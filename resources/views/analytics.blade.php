<x-layout.app title="Estatísticas">
    <x-container>
        <div class="w-full max-w-2xl mx-auto space-y-8">
            <h1 class="text-2xl font-bold tracking-tight">Estatísticas</h1>

            <div class="stats stats-vertical sm:stats-horizontal w-full bg-base-100 shadow">
                <div class="stat">
                    <div class="stat-title">Cliques</div>
                    <div class="stat-value text-primary">{{ $stats['clicks'] }}</div>
                </div>
                <div class="stat">
                    <div class="stat-title">Visitas</div>
                    <div class="stat-value">{{ $stats['views'] }}</div>
                </div>
                <div class="stat">
                    <div class="stat-title">Visitantes únicos</div>
                    <div class="stat-value">{{ $stats['visitors'] }}</div>
                </div>
            </div>

            <section class="space-y-3">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-base-content/60">Cliques nos últimos 7 dias</h2>

                @php $maximo = max($stats['per_day']->max('total'), 1); @endphp

                <div class="space-y-2">
                    @foreach ($stats['per_day'] as $dia)
                        <div class="flex items-center gap-3">
                            <span class="w-12 shrink-0 text-sm text-base-content/60">{{ $dia['label'] }}</span>
                            <div class="flex-1 h-3 rounded-full bg-base-300">
                                <div class="h-3 rounded-full bg-primary" style="width: {{ $dia['total'] / $maximo * 100 }}%"></div>
                            </div>
                            <span class="w-8 text-right text-sm">{{ $dia['total'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-base-content/60">Links mais clicados</h2>

                @forelse ($stats['top_links'] as $link)
                    <div class="flex items-center justify-between gap-3 rounded-box bg-base-100 p-3 shadow-sm">
                        <span class="truncate">{{ $link->name }}</span>
                        <span class="badge badge-primary shrink-0">{{ $link->clicks_count }}</span>
                    </div>
                @empty
                    <p class="text-base-content/50">Nenhum clique ainda.</p>
                @endforelse
            </section>

            @if ($stats['top_referers']->isNotEmpty())
                <section class="space-y-3">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-base-content/60">Principais origens</h2>

                    @foreach ($stats['top_referers'] as $origem)
                        <div class="flex items-center justify-between gap-3 rounded-box bg-base-100 p-3 shadow-sm">
                            <span class="truncate">{{ $origem->referer }}</span>
                            <span class="badge shrink-0">{{ $origem->total }}</span>
                        </div>
                    @endforeach
                </section>
            @endif
        </div>
    </x-container>
</x-layout.app>
