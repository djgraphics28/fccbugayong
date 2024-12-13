<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Illuminate\Support\Carbon;
use Filament\Widgets\ChartWidget;

class VisitorChartWidget extends ChartWidget
{
    protected static ?string $heading = 'New Visitor by Week';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Visitor::query()
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as count')
            ->whereRaw('DAYOFWEEK(created_at) = 1') // 1 = Sunday
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'New Members',
                    'data' => $data->pluck('count')->toArray(),
                ]
            ],
            'labels' => $data->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('M d');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
