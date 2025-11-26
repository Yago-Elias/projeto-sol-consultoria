<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
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


    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
