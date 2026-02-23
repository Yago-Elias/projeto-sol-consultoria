<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Configuration;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Permissions;
use Database\Factories\ConfigurationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    private static array $projects = [
        [
            'name'          => 'Portal do Cliente - Grupo Meridional',
            'description'   => 'Desenvolvimento de portal web para acesso dos clientes ao histórico de contratos, emissão de boletos e abertura de chamados de suporte.',
            'company_name'  => 'Grupo Meridional Participações',
            'company_email' => 'contato@meridional.com.br',
            'project_price' => 85000.00,
            'estimated_cost'=> 62000.00,
            'start_date'    => '2024-02-01',
            'end_date'      => '2024-08-31',
            'tasks' => [
                ['title' => 'Levantamento de requisitos com o cliente',        'description' => 'Reuniões com stakeholders para documentar funcionalidades, fluxos e regras de negócio.',          'predicted_hours' => 16, 'status' => 'APROVADA'],
                ['title' => 'Criação do protótipo de interface (Figma)',        'description' => 'Desenvolvimento de wireframes e protótipo navegável para validação visual com o cliente.',         'predicted_hours' => 24, 'status' => 'APROVADA'],
                ['title' => 'Configuração do ambiente de desenvolvimento',      'description' => 'Provisionar servidores, configurar variáveis de ambiente, CI/CD e acesso SSH.',                   'predicted_hours' => 8,  'status' => 'APROVADA'],
                ['title' => 'Desenvolvimento do módulo de autenticação',        'description' => 'Implementar login, cadastro, recuperação de senha e controle de sessão seguro.',                   'predicted_hours' => 20, 'status' => 'EM_APROVACAO'],
                ['title' => 'Integração com gateway de pagamento (Pagar.me)',   'description' => 'Conectar sistema ao Pagar.me para emissão e consulta de boletos bancários.',                     'predicted_hours' => 30, 'status' => 'PENDENTE'],
            ],
        ],
        [
            'name'          => 'Sistema de Gestão de Estoque - Distribuidora Alvorada',
            'description'   => 'Implantação de sistema para controle de entrada e saída de produtos, alertas de estoque mínimo e integração com nota fiscal eletrônica.',
            'company_name'  => 'Distribuidora Alvorada Ltda',
            'company_email' => 'ti@alvorada.com.br',
            'project_price' => 120000.00,
            'estimated_cost'=> 95000.00,
            'start_date'    => '2024-03-15',
            'end_date'      => '2024-12-15',
            'tasks' => [
                ['title' => 'Modelagem do banco de dados',                     'description' => 'Definir estrutura de tabelas, índices e relacionamentos para produtos, lotes e movimentações.',  'predicted_hours' => 20, 'status' => 'APROVADA'],
                ['title' => 'Importação de cadastro de produtos legados',      'description' => 'Migrar base de dados do sistema anterior via scripts ETL com validação e de-duplicação.',         'predicted_hours' => 40, 'status' => 'APROVADA'],
                ['title' => 'Desenvolvimento do módulo de entrada de NF-e',    'description' => 'Leitura de XML da nota fiscal e atualização automática do estoque ao registrar entrada.',         'predicted_hours' => 35, 'status' => 'EM_PROGRESSO'],
                ['title' => 'Testes de integração com a SEFAZ',               'description' => 'Validar comunicação com webservices da SEFAZ para emissão e cancelamento de NF-e.',              'predicted_hours' => 16, 'status' => 'PENDENTE'],
                ['title' => 'Treinamento da equipe do cliente',                'description' => 'Capacitar os operadores de estoque e supervisores para uso do novo sistema.',                     'predicted_hours' => 12, 'status' => 'PENDENTE'],
            ],
        ],
        [
            'name'          => 'Migração para Nuvem - Clínica São Lucas',
            'description'   => 'Migração da infraestrutura local para AWS, incluindo banco de dados, arquivos e aplicações, com plano de contingência e rollback.',
            'company_name'  => 'Clínica São Lucas S.A.',
            'company_email' => 'infraestrutura@saolucas.med.br',
            'project_price' => 45000.00,
            'estimated_cost'=> 38000.00,
            'start_date'    => '2024-05-01',
            'end_date'      => '2024-07-30',
            'tasks' => [
                ['title' => 'Mapeamento da infraestrutura atual',              'description' => 'Inventariar todos os servidores, serviços e dependências em uso no ambiente on-premise.',         'predicted_hours' => 12, 'status' => 'APROVADA'],
                ['title' => 'Configuração do ambiente AWS (VPC, EC2, RDS)',    'description' => 'Provisionar VPC, subnets, grupos de segurança, instâncias EC2 e banco RDS PostgreSQL.',          'predicted_hours' => 20, 'status' => 'APROVADA'],
                ['title' => 'Migração do banco de dados',                      'description' => 'Exportar, transformar e importar dados para o RDS com validação de integridade.',                'predicted_hours' => 16, 'status' => 'APROVADA'],
                ['title' => 'Testes de carga e desempenho',                   'description' => 'Simular carga de usuários simultâneos e validar tempos de resposta no novo ambiente.',            'predicted_hours' => 10, 'status' => 'EM_APROVACAO'],
                ['title' => 'Cutover e monitoramento pós-migração',           'description' => 'Executar a virada de ambiente e monitorar logs, alertas e disponibilidade nas primeiras 72h.',  'predicted_hours' => 24, 'status' => 'PENDENTE'],
            ],
        ],
    ];

    protected static Collection $users;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::factory()
            ->create([
                'max_installments' => 4
            ]);

        $consultantRole = Role::where('role', 'Consultor')->first();

        static::$users ??= User::all();
        $managers = static::$users->where('role_id', $consultantRole->id);

        foreach (self::$projects as $index => $projectData) {
            $tasks = $projectData['tasks'];
            unset($projectData['tasks']);

            $manager = $managers->random();
            $collaborators = static::$users->where('id', '!=', $manager->id)->random(4);

            $project = Project::factory()
                ->for($manager, 'manager')
                ->hasAttached($collaborators, [], 'collaborators')
                ->create($projectData);

            $collaboratorIds = $project->collaborators->pluck('id');

            foreach ($tasks as $taskData) {
                Task::create(array_merge($taskData, [
                    'project_id'  => $project->id,
                    'assigned_to' => $collaboratorIds->random(),
                    'due_date'    => now()->addDays(rand(5, 60)),
                ]));
            }
        }
    }
}
