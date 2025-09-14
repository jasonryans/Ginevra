@extends('layouts.base')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 space-y-6">
            <!-- Back Button -->
            <div class="flex justify-start">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-3 py-2 text-sm text-gray-600 hover:text-gray-800 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Home
                </a>
            </div>

            <!-- Logo Section -->
            <div class="text-center">
                <img src="{{ asset('storage/logo/No Background LOGO.png') }}" alt="Logo" class="mx-auto h-20 w-auto mb-4" style="height: 100px" width="auto">
                <h2 class="text-2xl font-bold text-gray-900">Log in</h2>
                <p class="text-sm text-gray-500 mt-2">Log in into your account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                <!-- Email Address -->
                <div>
                    <x-text-input id="email" 
                        class="block w-full px-4 py-3 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        placeholder="Email address"
                        required 
                        autofocus 
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <div class="relative">
                        <x-text-input id="password" 
                            class="block w-full px-4 py-3 pr-12 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required 
                            autocomplete="current-password" />
                        <button type="button" 
                            onclick="togglePassword('password', 'toggleIcon1')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="toggleIcon1" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" 
                        type="checkbox" 
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded" 
                        name="remember">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Login Button -->
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500" 
                        style="background: linear-gradient(135deg, #ec4899, #f472b6);">
                        {{ __('Log in') }}
                    </button>
                </div>

                <!-- Links Section -->
                <div class="flex items-center justify-between pt-4 text-sm">
                    <a class="text-pink-600 hover:text-pink-500 font-medium" href="{{ route('register') }}">
                        {{ __('Don\'t have an account?') }}
                    </a>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="text-gray-500 hover:text-gray-700 text-sm" href="{{ route('password.request') }}">
                            {{ __('Forgot password') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                toggleIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
@endsection