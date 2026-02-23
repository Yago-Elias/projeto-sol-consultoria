<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialType extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialTypeFactory> */
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'type',
    ];

    public function financialEntries(): HasMany
    {
        $type = FinancialType::find(1);
        $type->delete();

        return $this->hasMany(FinancialEntry::class, 'type');
    }
}
