<?php

namespace App\Filament\Resources\Profiles;

use App\Filament\Resources\Profiles\Pages\ManageProfiles;
use App\Models\Profile;
use App\Models\User;
use App\Permissions;
use BackedEnum;
use BladeUI\Icons\Components\Icon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hamcrest\Core\Set;
use Illuminate\Contracts\Support\Htmlable;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog8Tooth;

    protected static ?string $recordTitleAttribute = 'profile';

    protected static ?string $navigationLabel = 'Configurações';

    protected static ?int $navigationSort = 10;

    protected static ?string $label = 'perfil';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('profile')
                    ->label('Nome de perfil')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('global_access')
                    ->label('Acesso Global')
                    ->belowLabel('Acesso liberado a todo o sistema')
                    ->live()
                    ->required(),
                Toggle::make('system_config')
                    ->label('Configurações')
                    ->belowLabel('Acesso à tela de configurações')
                    ->disabled(fn (Get $get) => $get('global_access') ?? false)
                    ->required(),
                Section::make('Administrar Projetos')
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->components([
                        CheckboxList::make('manage_projects')
                            ->options([
                                'c' => 'Criar',
                                'e' => 'Editar',
                                'd' => 'Remover',
                                'f' => 'Finaceiro',
                                'm' => 'Gerenciar',
                                'l' => 'Ver todos',
                            ])
                            ->descriptions([
                                'c' => 'Pode criar novos projetos',
                                'e' => 'Pode editar seus projetos',
                                'd' => 'Pode excluir seus projetos',
                                'f' => 'Tem acesso ao campo financeiro dos projetos',
                                'm' => 'Pode ser escolhido como gerente de projeto',
                                'l' => 'Tem acesso a todos os projetos do sistema',
                            ])
                            ->columns()
                            ->hiddenLabel()
                            ->disabled(fn (Get $get) => $get('global_access') ?? false)
                    ]),
                Section::make('Administrar Tarefas')
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->components([
                        CheckboxList::make('task_access')
                            ->options([
                                'c' => 'Criar',
                                'e' => 'Editar',
                                'd' => 'Remover',
                                'a' => 'Aprovar',
                            ])
                            ->descriptions([
                                'c' => 'Pode cadastrar novas tarefas',
                                'e' => 'Pode editar tarefas',
                                'd' => 'Pode excluir tarefas',
                                'a' => 'Pode aprovar tarefas de outros consultores',
                            ])
                            ->columns()
                            ->hiddenLabel()
                            ->disabled(fn (Get $get) => $get('global_access') ?? false)
                    ]),
                Section::make('Administrar Consultores')
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->components([
                        CheckboxList::make('manage_users')
                            ->options([
                                'c' => 'Criar',
                                'e' => 'Editar',
                                'd' => 'Remover',
                                'l' => 'Ver todos',
                            ])
                            ->descriptions([
                                'c' => 'Pode cadastrar novos usuários',
                                'e' => 'Pode editar informações de usuários',
                                'd' => 'Pode excluir usuários',
                                'l' => 'Tem acesso a página de todos os usuários',
                            ])
                            ->columns()
                            ->hiddenLabel()
                            ->disabled(fn (Get $get) => $get('global_access') ?? false)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('profile')
            ->columns([
                TextColumn::make('profile')
                    ->label('Perfil')
                    ->searchable(),
                IconColumn::make('global_access')
                    ->alignCenter()
                    ->label('Acesso Global')
                    ->boolean(),
                IconColumn::make('system_config')
                    ->label('Configurações')
                    ->alignCenter()
                    ->boolean(),
                ColumnGroup::make('Permissões', [
                    IconColumn::make('manage_projects')
                        ->label('Projetos')
                        ->state(fn ($record) => static::numToArray($record['manage_projects']))
                        ->size(IconSize::Medium)
                        ->icon(function (string $state): Heroicon {
                            return match ($state) {
                                'c' => Heroicon::OutlinedPlusCircle,
                                'e' => Heroicon::OutlinedPencil,
                                'd' => Heroicon::OutlinedTrash,
                                'l' => Heroicon::OutlinedListBullet,
                                'f' => Heroicon::OutlinedCurrencyDollar,
                                'a' => Heroicon::OutlinedCheckCircle,
                                'm' => Heroicon::OutlinedArrowUp,
                                default => Heroicon::OutlinedMinus
                            };
                        }),
                    IconColumn::make('manage_users')
                        ->label('Usuários')
                        ->state(fn ($record) => static::numToArray($record['manage_users']))
                        ->size(IconSize::Medium)
                        ->icon(function (string $state): Heroicon {
                            return match ($state) {
                                'c' => Heroicon::OutlinedPlusCircle,
                                'e' => Heroicon::OutlinedPencil,
                                'd' => Heroicon::OutlinedTrash,
                                'l' => Heroicon::OutlinedListBullet,
                                'f' => Heroicon::OutlinedCurrencyDollar,
                                'a' => Heroicon::OutlinedCheckCircle,
                                'm' => Heroicon::OutlinedArrowUp,
                                default => Heroicon::OutlinedMinus
                            };
                        }),
                    IconColumn::make('task_access')
                        ->label('Tarefas')
                        ->state(fn ($record) => static::numToArray($record['task_access']))
                        ->size(IconSize::Medium)
                        ->icon(function (string $state): Heroicon {
                            return match ($state) {
                                'c' => Heroicon::OutlinedPlusCircle,
                                'e' => Heroicon::OutlinedPencil,
                                'd' => Heroicon::OutlinedTrash,
                                'l' => Heroicon::OutlinedListBullet,
                                'f' => Heroicon::OutlinedCurrencyDollar,
                                'a' => Heroicon::OutlinedCheckCircle,
                                'm' => Heroicon::OutlinedArrowUp,
                                default => Heroicon::OutlinedMinus
                            };
                        }),
                ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateRecordDataUsing(function ($data) {
                        $data['manage_projects'] = static::numToArray($data['manage_projects']);
                        $data['task_access'] = static::numToArray($data['task_access']);
                        $data['manage_users'] = static::numToArray($data['manage_users']);

                        return $data;
                    })
                    ->mutateDataUsing(function (array $data) {
                        if ($data['global_access']) {
                            $data['manage_projects'] = ['c', 'e', 'd', 'f', 'm', 'l'];
                            $data['task_access'] = ['c', 'e', 'd', 'a'];
                            $data['manage_users'] = ['c', 'e', 'd', 'l'];
                        }

                        $data['manage_projects'] = static::arrayToNum($data['manage_projects']);
                        $data['task_access'] = static::arrayToNum($data['task_access']);
                        $data['manage_users'] = static::arrayToNum($data['manage_users']);

                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProfiles::route('/'),
        ];
    }

    public static function numToArray(int $num): array
    {
        $array = [];

        if ($num & Permissions::CREATE) {
            $array[] = 'c';
        }
        if ($num & Permissions::EDIT) {
            $array[] = 'e';
        }
        if ($num & Permissions::REMOVE) {
            $array[] = 'd';
        }
        if ($num & Permissions::LIST) {
            $array[] = 'l';
        }
        if ($num & Permissions::APPROVE_TASKS) {
            $array[] = 'a';
        }
        if ($num & Permissions::MANAGE_PROJECTS) {
            $array[] = 'm';
        }
        if ($num & Permissions::FINANCIAL_ACCESS) {
            $array[] = 'f';
        }

        return $array;
    }

    public static function arrayToNum(array $array): int
    {
        return in_array('c', $array) * Permissions::CREATE          |
               in_array('e', $array) * Permissions::EDIT            |
               in_array('d', $array) * Permissions::REMOVE          |
               in_array('l', $array) * Permissions::LIST            |
               in_array('a', $array) * Permissions::APPROVE_TASKS   |
               in_array('m', $array) * Permissions::MANAGE_PROJECTS |
               in_array('f', $array) * Permissions::FINANCIAL_ACCESS;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('settings', User::class);
    }
}
