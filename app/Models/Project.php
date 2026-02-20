<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Storage;

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

    protected function overdue(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->end_date)->diffInDays(Carbon::now())
        );
    }

    protected function pendingTasks(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tasks()
                ->getQuery()
                ->where('status', 'PENDENTE')
                ->count()
        );
    }

    protected function overdueTasks(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tasks()
                ->getQuery()
                ->where('status', 'ATRASADA')
                ->count()
        );
    }

    protected function progress(): Attribute
    {
        return Attribute::make(
            get: function () {
                $total_tasks = $this->tasks()->count();

                if ($total_tasks == 0) {
                    return 0;
                }

                $completed_tasks = $this->tasks()->where('status', 'APROVADA')->count();
                return (round($completed_tasks / $total_tasks, 2)) * 100;
            }
        );
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

    public function financialEntries(): HasMany
    {
        return $this->hasMany(FinancialEntry::class, 'project_id');
    }

    public function getFilamentImageUrl(): ?string
    {
        if ($this->image == null || filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return Storage::disk('public')->url($this->image);
    }
}
