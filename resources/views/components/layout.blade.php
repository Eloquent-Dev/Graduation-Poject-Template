<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>City Voice - @yield('title', 'Smart Complaint Management')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">
    <nav class="w-full z-50 sticky top-0 left-0 bg-linear-to-r from-brand-dark to-brand-blue shadow-lg border-b border-blue-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="ham-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                <div class="flex items-center gap-2">

                    <div class="bg-white/10 backdrop-blur p-1 rounded border border-white/20">
                        <i class="fa-solid fa-city text-white text-2xl"></i>
                    </div>

                    <div>
                        <h1 class="text-white font-bold text-xl leading-none">City Voice</h1>
                        <p class="text-blue-200 text-[10px] tracking-wider uppercase">Smart Complaint Management System</p>
                    </div>
                </div>

                @if(auth()->user())
                    <div class="flex items-center space-x-8 text-white font-medium text-sm">
                    <a href="#" class="hover:text-brand-orange transition">Dashboard</a>
                    <a href="#" class="hover:text-brand-orange transition">My Complaints</a>
                    </div>

                    <div>
                        <a href="#" class="bg-brand-orange hover:bg-orange-600 text-white px-6 py-2 rounded shadow-lg transition font-semibold text-sm">Logout</a>
                    </div>
                @else
                <div>
                    <a href="#" class="md:inline-block bg-brand-orange hover:bg-orange-600 text-white px-6 py-2 rounded shadow-lg transition font-semibold text-sm">
                        Login
                    </a>
                </div>
                @endif
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <main class="grow max-w-7xl mx-auto px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-gray-800 border-t border-gray-700 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-300">City Voice - Empowering Smart Cities</p>
            <p class="text-xs text-gray-300 mt-2">&copy; {{ date('Y') }} - All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
