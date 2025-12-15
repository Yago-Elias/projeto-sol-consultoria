<?php

namespace App\Filament\Widgets;

use App\Filament\Tables\Columns\ProgressBar;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProgressTable extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
//            ->query(fn (): Builder => Model::query())
            ->records(fn () : array => [
                1 => ['Projeto' => 'Projeto 1', 'Progresso' => 95, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
                2 => ['Projeto' => 'Projeto 2', 'Progresso' => 80, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
                3 => ['Projeto' => 'Projeto 3', 'Progresso' => 70, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
                4 => ['Projeto' => 'Projeto 4', 'Progresso' => 50, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
                5 => ['Projeto' => 'Projeto 5', 'Progresso' => 30, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
                6 => ['Projeto' => 'Projeto 6', 'Progresso' => 15, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
                7 => ['Projeto' => 'Projeto 7', 'Progresso' => 35, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
                8 => ['Projeto' => 'Projeto 8', 'Progresso' => 20, 'Tempo restante' => '1 semana', 'Custos' => 'R$ 00,00', 'Receita' => 'R$ 00,00', 'Lucro' => 'R$ 00,00'],
            ])
            ->heading('Andamento dos Projetos')
            ->columns([
                TextColumn::make('Projeto'),
                ProgressBar::make('Progresso')
                    ->width('25%'),
                TextColumn::make('Tempo restante'),
                TextColumn::make('Custos')
                    ->color('danger'),
                TextColumn::make('Receita')
                    ->color('success'),
                TextColumn::make('Lucro'),
            ]);
    }
}
