<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use BackedEnum;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ProjectDetails extends ViewRecord
{
    protected static string $resource = ProjectResource::class;
    protected static ?string $navigationLabel = 'Detalhes';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::ListBullet;
    protected string $view = 'filament.resources.projects.pages.project-details';
}
