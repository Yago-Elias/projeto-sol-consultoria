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
            ['type' => 'Pix'],
            ['type' => 'Débito'],
            ['type' => 'Crédito'],
            ['type' => 'Boleto'],
        ];

        foreach ($types as $type) {
            FinancialType::create($type);
        }

        $natures = [
            ['nature' => 'Receita'],
            ['nature' => 'Custo'],
        ];

        foreach ($natures as $nature) {
            FinancialNature::create($nature);
        }

        $providers = [
            'TechSolução Sistemas Ltda',
            'Distribuidora Nacional de Equipamentos',
            'Consultoria Avante Gestão',
            'Agência Criativa Pixel BR',
            'Infracloud Hospedagem e Dados',
            'RH Experts Treinamentos',
            'Suprimentos Rápido Brasil',
        ];

        foreach ($providers as $providerName) {
            Provider::create(['provider' => $providerName]);
        }

        $natures   = FinancialNature::all()->keyBy('nature');
        $providers = Provider::all()->keyBy('provider');

        $entries = [
            [
                'description' => 'Receita de licença anual de software de gestão',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['TechSolução Sistemas Ltda']->id
            ],
            [
                'description' => 'Contratação de serviço de hospedagem em nuvem (trimestral)',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Infracloud Hospedagem e Dados']->id
            ],
            [
                'description' => 'Recebimento de parcela do contrato - Portal do Cliente',
                'nature' => $natures['Receita']->id,
                'provider' => $providers['Consultoria Avante Gestão']->id
            ],
            [
                'description' => 'Aquisição de equipamentos de informática para equipe',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Distribuidora Nacional de Equipamentos']->id
            ],
            [
                'description' => 'Treinamento corporativo em metodologias ágeis',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['RH Experts Treinamentos']->id
            ],
            [
                'description' => 'Recebimento integral referente ao projeto contratado',
                'nature' => $natures['Receita']->id,
                'provider' => $providers['Consultoria Avante Gestão']->id
            ],
            [
                'description' => 'Compra de material de escritório e insumos',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Suprimentos Rápido Brasil']->id
            ],
            [
                'description' => 'Serviço de design UI/UX para protótipo do sistema',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Agência Criativa Pixel BR']->id
            ],
            [
                'description' => 'Receita de consultoria especializada em segurança',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Consultoria Avante Gestão']->id
            ],
            [
                'description' => 'Renovação de certificado SSL e domínio',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['TechSolução Sistemas Ltda']->id
            ],
            [
                'description' => 'Contratação de serviço de suporte técnico mensal',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Infracloud Hospedagem e Dados']->id
            ],
            [
                'description' => 'Adiantamento contratual conforme proposta aprovada',
                'nature' => $natures['Receita']->id,
                'provider' => $providers['Consultoria Avante Gestão']->id
            ],
            [
                'description' => 'Reembolso de despesas de viagem da equipe',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Suprimentos Rápido Brasil']->id
            ],
            [
                'description' => 'Assinatura de ferramenta de gestão de projetos',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['TechSolução Sistemas Ltda']->id
            ],
            [
                'description' => 'Serviço de desenvolvimento terceirizado - módulo financeiro',
                'nature'=> $natures['Custo']->id,
                'provider' => $providers['Agência Criativa Pixel BR']->id
            ],
            [
                'description' => 'Receita de taxa de integração com API externa',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['TechSolução Sistemas Ltda']->id
            ],
            [
                'description' => 'Aquisição de licença de biblioteca de componentes',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Distribuidora Nacional de Equipamentos']->id
            ],
            [
                'description' => 'Contratação de serviço de backup automatizado em nuvem',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Infracloud Hospedagem e Dados']->id
            ],
            [
                'description' => 'Receita referente à nota fiscal de serviços prestados',
                'nature' => $natures['Receita']->id,
                'provider' => $providers['Consultoria Avante Gestão']->id
            ],
            [
                'description' => 'Parcela de financiamento de infraestrutura de servidores',
                'nature' => $natures['Custo']->id,
                'provider' => $providers['Infracloud Hospedagem e Dados']->id
            ],
        ];

        foreach($entries as $entryData) {
            FinancialEntry::factory()
                ->create($entryData)
                ->each(function(FinancialEntry $entry) {
                    $entry->create_installments();
                });
        }
    }
}
