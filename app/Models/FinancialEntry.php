<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialEntry extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialEntryFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
        'total_amount',
        'total_installments',
        'due_date',
        'payment_date',
        'project_id',
        'type',
        'nature',
        'provider',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'payment_date' => 'date',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function financialType(): BelongsTo
    {
        return $this->belongsTo(FinancialType::class, 'type');
    }

    public function financialNature(): BelongsTo
    {
        return $this->belongsTo(FinancialNature::class, 'nature');
    }

    public function providerModel(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider');
    }
}
