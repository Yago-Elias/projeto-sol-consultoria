<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'financial_entry_id');
    }

    public function create_installments(): void
    {
        $start_date = max($this['project']['start_date'], now());
        $value = round($this['total_amount'] / $this['total_installments'], 2);

        for ($i = 1; $i <= $this['total_installments']; $i++) {
            $due_date = $start_date->copy()->addMonthsWithoutOverflow($i);

            if ($due_date->isWeekend()) {
                if ($due_date->copy()->nextWeekDay()->month === $due_date->month) {
                    $due_date->nextWeekday();
                } else {
                    $due_date->previousWeekDay();
                }
            }

            if ($i == $this['total_installments']) {
                $value = $this['total_amount'] - $value * ($i - 1);
                $this['due_date'] = $due_date;
                $this->save();
            }

            $installment = Installment::create([
                'number' => $i,
                'value' => $value,
                'due_date' => $due_date,
                'financial_entry_id' => $this['id'],
            ]);

            $installment->save();
        }
    }
}
