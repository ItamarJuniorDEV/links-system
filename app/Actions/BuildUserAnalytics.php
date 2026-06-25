<?php

namespace App\Actions;

use App\Models\Click;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class BuildUserAnalytics
{
    public function handle(User $user): array
    {
        return Cache::remember("user:{$user->id}:analytics", 60, function () use ($user) {
            $linkIds = $user->links()->pluck('id');

            $porDia = Click::whereIn('link_id', $linkIds)
                ->where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->get()
                ->groupBy(fn (Click $click) => $click->created_at->format('Y-m-d'))
                ->map->count();

            return [
                'clicks' => Click::whereIn('link_id', $linkIds)->count(),
                'views' => $user->profileViews()->count(),
                'visitors' => $user->profileViews()->distinct()->count('ip_hash'),
                'per_day' => collect(range(6, 0))->map(function (int $atras) use ($porDia) {
                    $dia = now()->subDays($atras);

                    return [
                        'label' => $dia->format('d/m'),
                        'total' => $porDia->get($dia->format('Y-m-d'), 0),
                    ];
                }),
                'top_links' => $user->links()->withCount('clicks')->orderByDesc('clicks_count')->limit(5)->get(),
                'top_referers' => Click::whereIn('link_id', $linkIds)
                    ->whereNotNull('referer')
                    ->selectRaw('referer, count(*) as total')
                    ->groupBy('referer')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->get(),
            ];
        });
    }
}
