<?php

namespace App\Livewire;

use App\Models\Role;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class RolesTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Role::query())
            ->columns([
                TextColumn::make('role')
                    ->label('Cargo'),
                TextColumn::make('profile.profile')
                    ->label('Perfil'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Criar Cargo')
                    ->schema([
                        Section::make('role')
                            ->columns()
                            ->contained(false)
                            ->components([
                                TextInput::make('role')
                                    ->label('Cargo'),
                                Select::make('profile')
                                    ->label('Perfil')
                                    ->relationship('profile', 'profile')
                                    ->preload()
                            ])
                    ]),
                Action::make('Gerenciar Perfis')
                    ->url('/profiles')
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        Section::make('role')
                            ->columns()
                            ->contained(false)
                            ->components([
                                TextInput::make('role')
                                    ->label('Cargo'),
                                Select::make('profile')
                                    ->label('Perfil')
                                    ->relationship('profile', 'profile')
                                    ->preload()
                            ])
                    ]),
                DeleteAction::make()
            ]);
    }

    public function render(): View
    {
        return view('livewire.roles-table');
    }
}
