@extends('user.base')

@php
    $hideNewsletter = true;
@endphp

@section('content')
<div class="container py-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Home
        </a>
    </div>

    <!-- Success Message -->
    {{-- @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif --}}

    <!-- Profile Header -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="position-relative">
                        <!-- Edit Profile Button -->
                        <a href="{{ route('user.profile.edit') }}" 
                           class="position-absolute top-0 end-0 btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            Edit Profile
                        </a>

                        <!-- Profile Information -->
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="profile-picture-container">
                                    <img src="{{ auth()->user()->profile_picture ?  asset('storage/' . auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->username) . '&size=120&background=ff6b9d&color=ffffff&bold=true' }}"
                                         class="rounded-circle mb-3 profile-picture"
                                         alt="Profile Picture"
                                         onerror="this.src='images/default-avatar.svg={{ urlencode(auth()->user()->username) }}&size=120&background=ff6b9d&color=ffffff&bold=true'">
                                    <div>
                                        <a href="{{ route('user.profile.picture.edit') }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-camera me-1"></i>
                                            Change Photo
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h2 class="mb-1">{{ auth()->user()->username }}</h2>
                                <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-star-half-alt fa-2x text-accent-pink"></i>
                    </div>
                    <h5 class="card-title">Products Reviewed</h5>
                    <h3 class="text-accent-pink mb-0">{{ $countProductsReviewed }}</h3>
                    <p class="text-muted small mb-0">total products</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-chart-line fa-2x text-accent-gold"></i>
                    </div>
                    <h5 class="card-title">Average Rating</h5>
                    <h3 class="text-accent-gold mb-0">{{ $averageRating }}</h3>
                    <p class="text-muted small mb-0">out of 10</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Your Reviews
                    </h4>
                </div>
                <div class="card-body">
                    @if ($reviews->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">You haven't reviewed any products yet.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($reviews as $review)
                                <div class="col-12 mb-3">
                                    <a href="{{ route('user.products.show', $review->product) }}" 
                                       class="text-decoration-none">
                                        <div class="card border review-card">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <h6 class="card-title mb-1">{{ $review->product->name }}</h6>
                                                        <p class="card-text text-muted mb-0">{{ $review->review }}</p>
                                                    </div>
                                                    <div class="col-md-4 text-md-end">
                                                        <div class="rating-badge">
                                                            @if ($review->rating >= 8)
                                                                <span class="badge bg-success fs-6">
                                                                    {{ $review->rating }}/10
                                                                </span>
                                                            @elseif ($review->rating >= 5)
                                                                <span class="badge bg-warning fs-6">
                                                                    {{ $review->rating }}/10
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger fs-6">
                                                                    {{ $review->rating }}/10
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-picture {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 3px solid var(--light-gray);
    transition: all 0.3s ease;
}

.profile-picture:hover {
    border-color: var(--accent-pink);
}

.review-card {
    transition: all 0.3s ease;
    border: 1px solid var(--border-light) !important;
}

.review-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    border-color: var(--accent-pink) !important;
}

.rating-badge .badge {
    font-size: 0.9rem !important;
    padding: 0.5rem 0.8rem;
}

.card {
    border: 1px solid var(--border-light);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.text-accent-pink {
    color: var(--accent-pink) !important;
}

.text-accent-gold {
    color: var(--accent-gold) !important;
}

@media (max-width: 768px) {
    .profile-picture {
        width: 100px;
        height: 100px;
    }
    
    .rating-badge {
        margin-top: 1rem;
    }
}
</style>
@endsection