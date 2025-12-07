# 🧩 Sistema de Gestão de Projetos de Consultoria

Aplicação web desenvolvida com **Laravel 12**, **Filament 4.x** e **Docker**, voltada para gestão de projetos de consultoria, com controle de tarefas, permissões hierárquicas e acompanhamento financeiro. Projeto desenvolvido na disciplina Laboratório de Desenvolvimento de Software.

---

## Tabela de Conteúdo

- [Principais Tecnologias](#principais-tecnologias)
- [Estrutura de containers](#estrutura-de-containers)
- [Requisitos](#requisitos)
- [Passos para executar](#passos-para-executar-o-projeto)
  1. [Clonar](#1-clonar-o-repositório)
  2. [Configuração do Ambiente](#2-configurar-o-ambiente)
  3. [Subir containers](#3-subir-os-containers)
  4. [Dependências](#4-instalar-dependências-e-preparar-o-laravel)
  5. [Acessos](#5-acessos)
- [Comandos de desenvolvimento](#comandos-para-o-desenvolvimento)
- [Equipe](#equipe-de-desenvolvimento)

---

## Principais Tecnologias

- **Laravel 12**
- **Filament 4.x**
- **PHP 8.3**
- **MySQL 8**
- **Redis 7**
- **phpMyAdmin**
- **Nginx**
- **Node.js 20**

---

## Estrutura de containers

| Serviço | Descrição | Porta |
|----------|------------|-------|
| `app` | Aplicação Laravel (PHP-FPM) | 9000 |
| `NGINX` | Servidor web para a aplicação | 8000 |
| `db` | Banco de dados MySQL | 3306 |
| `PHPMyAdmin` | Interface web para o banco | 8080 |
| `redis` | Cache e filas | 6379 |

---

## Requisitos

- Docker (>= 24.x)
- Docker Compose (>= 2.x)
- Git

---

## Passos para executar o projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/Yago-Elias/projeto-sol-consultoria.git
cd projeto-sol-consultoria
```

### 2. Configurar o ambiente

Cria o arquivo .env com base no modelo e define o usuário do container o mesmo do host

```bash
cp .env.example .env && \
echo -e "UID=$(id -u)\nGID=$(id -g)" >> .env
```

### 3. Subir os containers

```bash
docker compose up -d
```

### 4. Instalar dependências e preparar o Laravel

Entre no container da aplicação:

```bash
docker exec -it laravel_app bash
```

Dentro do container:

```bash
composer install && \
php artisan key:generate && \
php artisan migrate --seed
```

### 5. Acessos

| Serviço | URL | Credenciais |
|---|---|---|
| Aplicação Laravel / Filament | <http://localhost:8000> | conforme usuários seed |
| phpMyAdmin | <http://localhost:8080> | Usuário: root / Senha: root |

---

## Comandos para o desenvolvimento

### Composer

#### Formatação de código

Para formatar o código para o padrão PSR-12:

```bash
composer format
```

#### Adicionar pacotes
Para adicionar um novo pacote ao projeto:

```bash
composer require [--dev] <pacote>
```

> **Nota:** Pacotes instalados com `--dev` são necessários apenas no ambiente de desenvolvimento e não serão carregados durante a implantação em produção.

### Artisan

#### Criar arquivos

Para criar os arquivos necessários do projeto:

```bash
php artisan make:...
```

<details>

  <summary>Quais arquivos podem ser criados</summary>

> Para ver os tipos de arquivos que podem ser criados:
>
> ```bash
>  php artisan list make
>  ```

</details>

#### Migrations

Para executar as migrações, realizar as mudanças no banco de dados:

```bash
php artisan migrate
```

Para recriar o banco de dados do zero, popular com valores padrões:

```bash
php artisan migrate:fresh --seed
```

#### Testes

Para executar os testes do projeto:

```bash
php artisan test
```

#### Solução de problemas comum

Caso esteja acusando a falta da chave da aplicação, mesmo preenchida

```bash
php artisan config:clear
php artisan cache:clear
```

Se uma view criada não foi reconhecida:

```bash
php artisan view:clear
```

Se uma rota criada ainda não está disponível:

```bash
php artisan route:clear
```

---

## Equipe de desenvolvimento

- Gabriel Santos
- Yago Elias
- Rener Pontes
- Vitor Rodrigues
