<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns([
                        'sm' => 4,
                        'md' => 6,
                        'lg' => 8,
                        'xl' => 12
                    ])
                    ->columnSpanFull()
                    ->schema([
                        Section::make()
                            ->contained(false)
                            ->columnSpan([
                                'md' => 3,
                                'lg' => 5,
                                'xl' => 8
                            ])
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nome')
                                    ->columnSpanFull()
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->columnSpanFull()
                                    ->email()
                                    ->required(),
                                TextInput::make('telephone')
                                    ->label('Telefone')
                                    ->columnSpanFull()
                                    ->tel()
                                    ->required(),
                            ]),
                        FileUpload::make('image')
                            ->label('Foto')
                            ->columnSpan([
                                'md' => 3,
                                'lg' => 3,
                                'xl' => 4
                            ])
                            ->image()
                            ->alignCenter(),
                        TextInput::make('expertise')
                            ->label('Áreas de Expertise')
                            ->columnSpanFull(),
                        TextInput::make('salary')
                            ->label('Salário')
                            ->columnSpan([
                                'md' => 2,
                                'lg' => 4,
                                'xl' => 4
                            ])
                            ->required()
                            ->numeric(),
                        Select::make('role_id')
                            ->label('Cargo')
                            ->columnSpan([
                                'md' => 2,
                                'lg' => 4,
                                'xl' => 4
                            ])
                            ->relationship('role', 'id'),
                        Select::make('profile_id')
                            ->label('Perfil')
                            ->columnSpan([
                                'md' => 2,
                                'lg' => 4,
                                'xl' => 4
                            ])
                            ->relationship('profile', 'id'),
                    ])
            ]);
    }
}
