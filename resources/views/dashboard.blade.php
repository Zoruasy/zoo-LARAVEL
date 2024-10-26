<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ config('app.name') }}</title>
</head>
<body>
<div class="min-h-screen bg-gray-100">
    <header>
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        <!-- Mobile menu button-->
                    </div>
                    <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="hidden sm:block sm:ml-6">
                            <div class="flex space-x-4">
                                <a href="{{ url('/') }}" class="text-gray-900 hover:text-gray-700">Home</a>
                                <a href="{{ url('/catalog') }}" class="text-gray-900 hover:text-gray-700">Animal Catalog</a>
                            </div>
                        </div>
                    </div>

                    <!-- Authentication Links -->
                    <div class="hidden sm:block sm:ml-6">
                        @auth
                            <span class="text-gray-900">Hello, {{ Auth::user()->name }}</span>
                            <a href="{{ route('logout') }}" class="text-gray-900 hover:text-gray-700">Logout</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-700">Login</a>
                            <a href="{{ route('register') }}" class="text-gray-900 hover:text-gray-700">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }} <!-- Render the main content -->
    </main>
</div>
</body>
</html>
