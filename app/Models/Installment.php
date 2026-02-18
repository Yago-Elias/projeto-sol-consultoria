<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
    protected $fillable = [
        'number',
        'value',
        'due_date',
        'payment_date',
        'status',
        'financial_entry_id',
    ];

    protected $casts = [
        'due_date' => 'date',
        'payment_date' => 'date',
    ];

    public function financialEntry(): BelongsTo
    {
        return $this->belongsTo(FinancialEntry::class);
    }
}
