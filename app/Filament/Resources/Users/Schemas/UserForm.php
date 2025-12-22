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
                        TextInput::make('name')
                            ->label('Name')
                            ->columnSpan([
                                'md' => 3,
                                'lg' => 5,
                                'xl' => 8
                            ])
                            ->required(),
                        FileUpload::make('image')
                            ->label('Foto')
                            ->columnSpan([
                                'md' => 3,
                                'lg' => 3,
                                'xl' => 4
                            ])
                            ->image(),
                        TextInput::make('email')
                            ->label('Email')
                            ->columnSpan([
                                'md' => 3,
                                'lg' => 5,
                                'xl' => 8
                            ])
                            ->email()
                            ->required(),
                        TextInput::make('telephone')
                            ->label('Telefone')
                            ->columnSpan([
                                'md' => 3,
                                'lg' => 5,
                                'xl' => 8
                            ])
                            ->tel()
                            ->required(),
                        TextInput::make('expertise')
                            ->label('Áreas de Expertise')
                            ->columnSpanFull(),
                        TextInput::make('salary')
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
