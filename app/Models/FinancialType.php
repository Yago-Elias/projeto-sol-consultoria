<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialType extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialTypeFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
    ];

    public function financialEntries(): HasMany
    {
        return $this->hasMany(FinancialEntry::class, 'type');
    }
}
