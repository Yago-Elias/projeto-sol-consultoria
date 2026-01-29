<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialNature extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialNatureFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nature',
    ];

    public function financialEntries(): HasMany
    {
        return $this->hasMany(FinancialEntry::class, 'nature');
    }
}
