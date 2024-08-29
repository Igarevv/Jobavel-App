<!doctype html>
<html x-data="{ darkMode: localStorage.getItem('dark') === 'true'}"
      x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
      x-bind:class="{ 'dark': darkMode }" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>{{ $title ?? 'Jobavel Admin' }}</title>
    @vite(['resources/assets/css/admin.css', 'resources/assets/js/admin.js'])
    @stack('vite')
</head>

<body class="flex flex-col min-vh-100">
<div class="flex min-vh-100 bg-white dark:bg-gray-900">
    <x-admin.sidebar/>
    <main class="mt-4 px-4 flex-grow">
        <div class="block sm:absolute top-5 right-8 order-1">
            <x-admin.dark-mode-toggle size="4"/>
        </div>
        {{ $slot }}
        <x-admin.footer/>
    </main>
</div>
</body>

</html>