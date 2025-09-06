<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),

            'This Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ])
                )
                ->badge(Employee::query()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count()),

            'last year' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->whereBetween('created_at', [
                        now()->subYear()->startOfYear(),
                        now()->subYear()->endOfYear(),
                    ])
                )
                ->badge(Employee::query()->whereBetween('created_at', [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()])->count()),
        ];
    }
}
