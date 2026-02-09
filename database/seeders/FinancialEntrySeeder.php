<?php

namespace Database\Seeders;

use App\Models\FinancialEntry;
use App\Models\FinancialNature;
use App\Models\FinancialType;
use App\Models\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type' => 'Expense'],
            ['type' => 'Payment'],
        ];

        foreach ($types as $type) {
            FinancialType::create($type);
        }

        $natures = [
            ['nature' => 'Operating'],
            ['nature' => 'Capital'],
            ['nature' => 'Administrative'],
            ['nature' => 'Research & Development'],
        ];

        foreach ($natures as $nature) {
            FinancialNature::create($nature);
        }

        $providers = [
            ['provider' => 'Acme Corporation'],
            ['provider' => 'TechSupplies Inc'],
            ['provider' => 'Global Services Ltd'],
            ['provider' => 'Quality Materials Co'],
            ['provider' => 'Professional Consultants'],
        ];

        foreach ($providers as $provider) {
            Provider::create($provider);
        }

        FinancialEntry::factory()
            ->count(20)
            ->create();
    }
}
