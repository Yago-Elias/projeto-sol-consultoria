<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    /** @use HasFactory<\Database\Factories\ProviderFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'provider',
    ];

    public function financialEntries(): HasMany
    {
        return $this->hasMany(FinancialEntry::class, 'provider');
    }
}
