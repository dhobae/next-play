<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="auth-page">
    <div id="app">
        <main class="auth-shell">
            @yield('content')
        </main>
    </div>

    <style>
        :root {
            --auth-ink: #17212b;
            --auth-muted: #687582;
            --auth-accent: #176b87;
            --auth-accent-dark: #0f526a;
            --auth-border: #dbe4e8;
        }

        .auth-page {
            min-height: 100vh;
            color: var(--auth-ink);
            background: #eef5f5;
            background-image: linear-gradient(135deg, rgba(23, 107, 135, .08), transparent 45%), linear-gradient(315deg, rgba(242, 170, 76, .12), transparent 42%);
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            width: min(100%, 460px);
            background: #fff;
            border: 1px solid rgba(219, 228, 232, .9);
            border-radius: 14px;
            box-shadow: 0 20px 55px rgba(23, 33, 43, .11);
        }

        .auth-card-body {
            padding: 2.5rem;
        }

        .auth-mark {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            color: #fff;
            background: var(--auth-accent);
            border-radius: 11px;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .auth-title {
            margin: 1.4rem 0 .5rem;
            font-weight: 700;
            letter-spacing: -.02em;
        }

        .auth-subtitle {
            color: var(--auth-muted);
            margin-bottom: 2rem;
        }

        .auth-label {
            color: var(--auth-ink);
            font-size: .9rem;
            font-weight: 600;
            margin-bottom: .45rem;
        }

        .auth-input {
            border-color: var(--auth-border);
            padding: .72rem .85rem;
        }

        .auth-input:focus {
            border-color: var(--auth-accent);
            box-shadow: 0 0 0 .2rem rgba(23, 107, 135, .12);
        }

        .auth-button {
            width: 100%;
            border: 0;
            padding: .78rem 1rem;
            background: var(--auth-accent);
        }

        .auth-button:hover,
        .auth-button:focus {
            background: var(--auth-accent-dark);
        }

        .auth-note {
            color: var(--auth-muted);
            font-size: .86rem;
        }

        @media (max-width: 480px) {
            .auth-card-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
</body>

</html>
