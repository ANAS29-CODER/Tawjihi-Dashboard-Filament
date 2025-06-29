<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Subject;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersNumber extends BaseWidget
{
        protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make(__('validation.users'), User::count())
                ->description(__('validation.users_joined'))
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->color('success')
                ->chart([10, 50, 10, 100, 150, 500])
                ->url(route('filament.admin.resources.users.index')) // Add this line
                ,

            Stat::make(__('validation.subjects'), Subject::count())
                ->description(__('validation.subjects_joiend'))
                ->descriptionIcon('heroicon-o-clipboard-document-list', IconPosition::Before)
                ->color('info')
                ->chart([20, 25, 10, 25, 150])
                ->url(route('filament.admin.resources.subjects.index')),

            Stat::make(__('validation.branchs'), Branch::count())
                ->description(__('validation.branchs_joiend'))
                ->descriptionIcon('heroicon-o-academic-cap', IconPosition::Before)
                ->color('warning')
                ->chart([20, 25, 10, 25, 150])
                ->url(route('filament.admin.resources.branches.index')),


        ];
    }
}
