<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'company_name',
        'company_email',
        'project_price',
        'estimated_cost',
        'start_date',
        'end_date',
        'manager_id',
    ];

    protected function casts(): array
    {
        return [
            'end_date' => 'date',
            'start_date' => 'date',
        ];
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'projects_users',
            'project_id',
            'user_id'
        );
    }

    public function boards(): HasMany
    {
        return $this->hasMany(Board::class, 'project_id');
    }

    public function tasks(): HasManyThrough
    {
        return $this->through('boards')->has('tasks');
    }
}
