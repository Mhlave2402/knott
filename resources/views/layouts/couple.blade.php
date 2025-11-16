<!-- FILE: resources/views/layouts/couple.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Knott') }} - @yield('title', 'Modern Wedding Planning')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/knott-icon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional head content -->
    @stack('head')
</head>
<body class="h-full font-sans antialiased">
    <div class="min-h-full">
        @auth
            <!-- Dashboard Layout -->
            <div class="flex h-screen bg-gray-50">
                <!-- Sidebar -->
                @include('components.sidebar')
                
                <!-- Main content -->
                <div class="flex-1 flex flex-col overflow-hidden">
                    <!-- Top navigation -->
                    @include('components.topbar')
                    
                    <!-- Page content -->
                    <main class="flex-1 overflow-y-auto">
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                                <!-- Page header -->
                                @hasSection('header')
                                    <div class="mb-6">
                                        <h1 class="text-2xl font-bold text-gray-900">@yield('header')</h1>
                                        @hasSection('description')
                                            <p class="mt-1 text-sm text-gray-600">@yield('description')</p>
                                        @endif
                                    </div>
                                @endif
                                
                                <!-- Flash messages -->
                                @if (session('success'))
                                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                
                                @if (session('error'))
                                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                
                                <!-- Page content -->
                                @yield('content')
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        @else
            <!-- Public Layout -->
            <div class="min-h-screen">
                <!-- Public navigation -->
                <nav class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center py-4">
                            <div class="flex items-center">
                                <img class="h-8 w-auto" src="{{ asset('images/knott-logo.png') }}" alt="Knott">
                            </div>
                            <div class="flex items-center space-x-4">
                                @guest
                                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600 font-medium">Sign In</a>
                                    <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">Get Started</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Public content -->
                <main>
                    @yield('content')
                </main>
            </div>
        @endauth
    </div>
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
