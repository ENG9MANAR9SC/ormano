<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Ormano') — Legal ERP</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="ormano-main min-h-screen text-slate-800 antialiased">
        <header class="border-b border-slate-200/80 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
                <a href="{{ route('cases.index') }}" class="text-lg font-semibold tracking-tight text-blue-700">Ormano</a>
                <nav class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-600" aria-label="Main">
                    <a href="{{ route('cases.index') }}" class="rounded-lg px-2 py-1 hover:bg-slate-100 hover:text-blue-600">Cases</a>
                    <a href="{{ route('clients.index') }}" class="rounded-lg px-2 py-1 hover:bg-slate-100 hover:text-blue-600">Clients</a>
                    <a href="{{ route('courts.index') }}" class="rounded-lg px-2 py-1 hover:bg-slate-100 hover:text-blue-600">Courts</a>
                    <a href="{{ route('tasks.index') }}" class="rounded-lg px-2 py-1 hover:bg-slate-100 hover:text-blue-600">Tasks</a>
                    <a href="{{ route('tasks.calendar') }}" class="rounded-lg px-2 py-1 hover:bg-slate-100 hover:text-blue-600">Task Calendar</a>
                    <a href="{{ route('documents.index') }}" class="rounded-lg px-2 py-1 hover:bg-slate-100 hover:text-blue-600">Documents</a>
                </nav>
            </div>
        </header>
        <main class="mx-auto max-w-6xl px-4 py-8">
            @if (session('success'))
                <div
                    class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900"
                    role="status"
                >
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900"
                    role="alert"
                >
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
        @stack('scripts')
    </body>
</html>
