<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $profile['name'] }} | Biodata</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
        <div class="mx-auto flex min-h-screen max-w-3xl items-center px-6 py-10">
            <main class="w-full rounded-3xl border border-white/10 bg-slate-900/70 p-8 shadow-2xl shadow-indigo-950/30 md:p-10">
                <p class="inline-flex rounded-full border border-indigo-300/30 bg-indigo-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-indigo-200">
                    Profile Saya
                </p>

                <h1 class="mt-4 text-3xl font-bold leading-tight md:text-4xl">{{ $profile['name'] }}</h1>
                <p class="mt-2 text-slate-300">{{ $profile['bio'] }}</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-white/10 bg-slate-800/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Nama Panggilan</p>
                        <p class="mt-1 font-semibold text-white">{{ $profile['nickname'] }}</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-slate-800/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Kuliah Di</p>
                        <p class="mt-1 font-semibold text-white">{{ $profile['university'] }}</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-slate-800/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Jurusan</p>
                        <p class="mt-1 font-semibold text-white">{{ $profile['major'] }}</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-slate-800/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Semester</p>
                        <p class="mt-1 font-semibold text-white">{{ $profile['semester'] }}</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-slate-800/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Lokasi</p>
                        <p class="mt-1 font-semibold text-white">{{ $profile['location'] }}</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-slate-800/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Email</p>
                        <a class="mt-1 block font-semibold text-indigo-300 hover:text-indigo-200" href="mailto:{{ $profile['email'] }}">{{ $profile['email'] }}</a>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-slate-800/50 p-4 sm:col-span-2">
                        <p class="text-xs uppercase tracking-wide text-slate-400">No. HP</p>
                        <a class="mt-1 block font-semibold text-indigo-300 hover:text-indigo-200" href="tel:{{ preg_replace('/\s+/', '', $profile['phone']) }}">{{ $profile['phone'] }}</a>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
