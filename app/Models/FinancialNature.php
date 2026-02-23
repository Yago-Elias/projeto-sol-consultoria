<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialNature extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialNatureFactory> */
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'nature',
    ];

    public function financialEntries(): HasMany
    {
        return $this->hasMany(FinancialEntry::class, 'nature');
    }
}
