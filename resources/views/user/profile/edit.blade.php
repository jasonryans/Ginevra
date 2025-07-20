@extends('user.base')

@php
    $hideNewsletter = true;
@endphp

@section('content')
    <div class="container py-5">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('user.profile.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Profil
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 font-playfair fw-bold mb-3">Edit Profil</h1>
            <p class="lead text-muted">Perbarui informasi akun dan preferensi Anda dengan mudah.</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Edit Sections -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Update Profile Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-user me-2"></i>
                            Informasi Profil
                        </h4>
                        <small class="opacity-75">Update nama, email, dan informasi biodata Anda</small>
                    </div>
                    <div class="card-body p-4">
                        @include('user.profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-lock me-2"></i>
                            Keamanan Akun
                        </h4>
                        <small>Ubah password untuk menjaga keamanan akun Anda</small>
                    </div>
                    <div class="card-body p-4">
                        @include('user.profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-black) 0%, var(--accent-pink) 100%);
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .card-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .card-header h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .card-header small {
            font-size: 0.9rem;
            display: block;
            margin-top: 0.25rem;
        }

        .btn-outline-secondary {
            border: 2px solid var(--text-gray);
            color: var(--text-gray);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: var(--primary-black);
            border-color: var(--primary-black);
            color: var(--warm-white);
        }

        .btn-outline-danger {
            border: 2px solid #dc3545;
            color: #dc3545;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .alert-success {
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .lead {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .display-5 {
                font-size: 2.5rem;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .card-header {
                padding: 1.25rem !important;
            }
        }
    </style>
@endsection
