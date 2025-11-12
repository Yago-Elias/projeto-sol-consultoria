# 🧩 Sistema de Gestão de Projetos de Consultoria

Aplicação web desenvolvida com **Laravel 12**, **Filament 4.x** e **Docker**, voltada para gestão de projetos de consultoria, com controle de tarefas, permissões hierárquicas e acompanhamento financeiro. Projeto desenvolvido na disciplina Laboratório de Desenvolvimento de Software.

---

## 🚀 Tecnologias principais

- **Laravel 12**
- **Filament 4.x**
- **PHP 8.3**
- **MySQL 8**
- **Redis 7**
- **phpMyAdmin**
- **Nginx**
- **Node.js 20**

---

## 🧱 Estrutura de containers

| Serviço | Descrição | Porta |
|----------|------------|-------|
| `app` | Aplicação Laravel (PHP-FPM) | 9000 |
| `nginx` | Servidor web para a aplicação | 8000 |
| `db` | Banco de dados MySQL | 3306 |
| `phpmyadmin` | Interface web para o banco | 8080 |
| `redis` | Cache e filas | 6379 |

---

## ⚙️ Requisitos

- Docker (>= 24.x)
- Docker Compose (>= 2.x)
- Git

---

## 🧩 Passos para executar o projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/Yago-Elias/projeto-sol-consultoria.git
cd projeto-sol-consultoria
```

### 2. Configurar o ambiente

Crie o arquivo .env com base no modelo:
```bash
cp .env.example .env
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
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
exit
```

### 5. Acessos

| Serviço | URL | Credenciais |
|---|---|---|
| Aplicação Laravel / Filament | http://localhost:8000 | conforme usuários seed
| phpMyAdmin | http://localhost:8080 | Usuário: root / Senha: root |
---

## 👥 Equipe de desenvolvimento
- Gabriel Santos
- Yago Elias
- Rener Pontes
- Vitor Rodrigues