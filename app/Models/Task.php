<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'predicted_hours',
        'due_date',
        'conclusion_date',
        'conclusion_message',
        'status',
        'board_id',
        'assigned_to',
    ];

    public function casts(): array {
        return [
            'due_date' => 'datetime',
            'conclusion_date' => 'datetime',
        ];
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function assignedTo(): BelongsTo {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
