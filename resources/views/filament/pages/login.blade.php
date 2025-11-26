<x-filament-panels::page.simple>
    <style>
        body {
            background-image: url('{{ asset('images/login-background.svg') }}');
            background-size: cover;
            background-position: top;
            background-color: white;
        }

        .fi-simple-main {
            background: rgba(255, 255, 255);
            backdrop-filter: blur(10px);
            border: #CE9F41 solid 1px;
        }

        .logo {
            width: 200px;
            margin: auto auto 48px auto;
        }

        .fi-simple-header {
            display: none;
        }

    </style>

    <div class='container'>
        <img src='{{ asset('images/logo.svg') }}' alt='Sol Consultorias' class='logo'>

        <div class='form'>
            {{ $this->content }}
        </div>
    </div>
</x-filament-panels::page.simple>
