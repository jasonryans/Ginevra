@extends('user.base')

@section('content')
    <div class="min-h-screen bg-gray-50 pt-24 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('user.profile.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Profil</span>
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Profil</h1>
                <p class="mt-2 text-gray-600">Perbarui informasi akun dan preferensi Anda.</p>
            </div>

            <!-- Profile Edit Sections -->
            <div class="space-y-6">
                <!-- Update Profile Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        @include('user.profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        @include('user.profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        @include('user.profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Alpine.js for modal functionality -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
