<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function financialEntry(): HasOne
    {
        return $this->hasOne(FinancialEntry::class);
    }

    public function validatePreviousInstallmentPaid(): bool
    {
        if ($this->number == 1)
            return true;
        
        return self::where('financial_entry_id', $this->financial_entry_id)
            ->where('number', $this->number - 1)
            ->whereNotNull('payment_date')
            ->exists();
    }

    public function markAsPaid(): void
    {
        if ($this->validatePreviousInstallmentPaid()) {
            $this->update(['payment_date' => now()]);

            Notification::make()
                ->title('Pagamento confirmado!')
                ->body("Parcela Nº {$this->number} marcada como paga")
                ->success()
                ->send();
            return;
        }

        $number_previous = $this->number - 1;
        Notification::make()
            ->title('Pagamento cancelado!')
            ->body("Parcela Nº {$number_previous} pendente")
            ->danger()
            ->send();
    }
}
