<x-filament-panels::page.simple>
    <style>
        body {
            background-image: url('{{ asset('images/login-background.svg') }}');
            background-size: cover;
            background-position: top;
            background-color: white;
        }

        .fi-simple-main {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(10px);
            color: black;
        }
    </style>

    {{ $this->content }}
</x-filament-panels::page.simple>
