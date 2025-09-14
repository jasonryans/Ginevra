<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" style="min-height: 120px">
    <div class="container">
        <!-- Brand -->
        {{-- <a class="navbar-brand font-playfair" href="{{ route('home') }}">
            <strong>Ginevra</strong>
        </a> --}}
             <!-- Brand with Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <span class="font-playfair"><strong>Ginevra</strong></span>
            <img src="{{ asset('storage/logo/No Background LOGO.png') }}" alt="Ginevra Logo" class="me-2" style="height: 100px; width: auto;">
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Sale</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="#" id="shopDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="display: inline-flex; align-items: center;">
                        SHOP
                        <span class="svg-wrapper ms-1">
                            <svg class="icon icon-caret" viewBox="0 0 10 6"
                                style="width: 10px; height: 6px; transition: transform 0.3s ease;">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M9.354.646a.5.5 0 0 0-.708 0L5 4.293 1.354.646a.5.5 0 0 0-.708.708l4 4a.5.5 0 0 0 .708 0l4-4a.5.5 0 0 0 0-.708"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="shopDropdown">
                        @if (isset($categories))
                            @foreach ($categories as $category)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('user.shop.category', strtolower($category->name)) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        @else
                            <li>
                                <span class="dropdown-item-text">No categories available</span>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->is('featured*') ? 'active' : '' }}" href="#"
                        id="collectionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="display: inline-flex; align-items: center;">
                        Featured
                        <span class="svg-wrapper ms-1">
                            <svg class="icon icon-caret" viewBox="0 0 10 6"
                                style="width: 10px; height: 6px; transition: transform 0.3s ease;">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M9.354.646a.5.5 0 0 0-.708 0L5 4.293 1.354.646a.5.5 0 0 0-.708.708l4 4a.5.5 0 0 0 .708 0l4-4a.5.5 0 0 0 0-.708"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="collectionsDropdown">
                        @if (isset($features) && $features->count() > 0)
                            @foreach ($features as $feature)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('user.collection.featured', strtolower(str_replace(' ', '-', $feature->name))) }}">{{ $feature->name}}</a>
                                </li>
                            @endforeach
                        @else
                            <li>
                                <span class="dropdown-item-text">No features available</span>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>

            <!-- Right side items -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    @auth
                        <a class="nav-link position-relative" href="{{ route('user.carts.index') }}">
                            <i class="fas fa-shopping-bag"></i>
                            @php
                                $cartCount = Auth::user()->carts()->count(); 
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <span class="cart-count">{{ $cartCount }}</span>
                                </span>
                            @else
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                    <span class="cart-count">0</span>
                                </span>
                            @endif
                        </a>
                    @else
                        <a class="nav-link position-relative" href="{{ route('login') }}">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                <span class="cart-count">0</span>
                            </span>
                        </a>
                    @endauth
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>
                            {{ Auth::user()->name }}
                            <span class="svg-wrapper ms-1">
                                <svg class="icon icon-caret" viewBox="0 0 10 6"
                                    style="width: 10px; height: 6px; transition: transform 0.3s ease;">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M9.354.646a.5.5 0 0 0-.708 0L5 4.293 1.354.646a.5.5 0 0 0-.708.708l4 4a.5.5 0 0 0 .708 0l4-4a.5.5 0 0 0 0-.708"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile.index') }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/orders') }}">
                                    <i class="fas fa-box me-2"></i>My Orders
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shop Arrow
        const shopDropdown = document.getElementById('shopDropdown');
        const shopCaretIcon = shopDropdown.querySelector('.icon-caret');

        shopDropdown.addEventListener('show.bs.dropdown', function() {
            shopCaretIcon.style.transform = 'rotate(180deg)';
        });

        shopDropdown.addEventListener('hide.bs.dropdown', function() {
            shopCaretIcon.style.transform = 'rotate(0deg)';
        });

        // Collections Arrow
        const collectionsDropdown = document.getElementById('collectionsDropdown');
        const collectionsCaretIcon = collectionsDropdown.querySelector('.icon-caret');

        collectionsDropdown.addEventListener('show.bs.dropdown', function() {
            collectionsCaretIcon.style.transform = 'rotate(180deg)';
        });

        collectionsDropdown.addEventListener('hide.bs.dropdown', function() {
            collectionsCaretIcon.style.transform = 'rotate(0deg)';
        });

        // Profile Arrow
        const profileDropdown = document.getElementById('navbarDropdown');
        const profileCaretIcon = profileDropdown.querySelector('.icon-caret');

        profileDropdown.addEventListener('show.bs.dropdown', function() {
            profileCaretIcon.style.transform = 'rotate(180deg)';
        });

        profileDropdown.addEventListener('hide.bs.dropdown', function() {
            profileCaretIcon.style.transform = 'rotate(0deg)';
        });
    });
</script>
