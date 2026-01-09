<div class="fundo">
    <div class="container">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo Sol Consultorias">
        <p>Olá, {{ $userName }}!</p>
        <p>Bem vindo ao sistema de gerenciamento de projetos <strong>Sol Consultorias</strong>!</p>
        <p>Para o seu primeiro acesso, clique no botão abaixo para criar sua senha:</p>
        <a href="{{ $resetPasswordLink }}">
            <button class="botao">Criar Senha</button>
        </a>
        <p style="color: var(--neutro-2);">&copy; Sol Consultorias</p>
    </div>
    <style>
        :root {
            --cor-base: #A77022;
            --claro-1: #C58A33;
            --claro-2: #E0A856;
            --claro-3: #F2D4A3;
            --escuro-1: #85561A;
            --escuro-2: #5E3C12;
            --escuro-3: #3B250A;
            --neutro-1: #F8F5F2;
            --neutro-2: #AFA9A2;
            --neutro-3: #2B2B2B;
        }

        .fundo {
            background-color: var(--claro-3);
            background-size: cover;
        }

        .container {
            display: flex;
            flex-direction: column;
            gap: 1em;
            max-width: 50%;
            background-color: white;
            margin: auto;
            padding: 1em 4em;
            color: var(--neutro-3);
            border-left: var(--cor-base) solid 2px;
            border-right: var(--cor-base) solid 2px;
        }

        img {
            display: block;
            width: 6em;
            margin: 0 auto;
        }

        a {
            display: flex;
            text-decoration: none;
        }

        button {
            padding: 0.5em 1em;
            margin: 0 auto;
            border-radius: 0.5em;
            border: var(--escuro-3) solid 1px;
            background-color: var(--claro-3);
            color: var(--escuro-3);
            font-weight: 600;
        }
    </style>
</div>
