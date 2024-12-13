<?php

namespace App\Filament\Widgets;

use App\Models\Family;
use App\Models\Member;
use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TotalCountsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Active Members', Member::where('is_active', true)->count())
                ->description('Total active members')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Inactive Members', Member::where('is_active', false)->count())
                ->description('Total inactive members')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('danger'),
            Stat::make('Active Families', Family::count())
                ->description('Total active families')
                ->descriptionIcon('heroicon-m-home')
                ->color('primary'),
            Stat::make('Visitors', Visitor::count())
                ->description('Total visitors')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
