<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand font-playfair" href="{{ url('/') }}">
            <strong>Ginevra</strong>
        </a>
        
        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Sale</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: inline-flex; align-items: center;">
                        SHOP
                        <span class="svg-wrapper ms-1">
                            <svg class="icon icon-caret" viewBox="0 0 10 6" style="width: 10px; height: 6px; transition: transform 0.3s ease;">
                                <path fill="currentColor" fill-rule="evenodd" d="M9.354.646a.5.5 0 0 0-.708 0L5 4.293 1.354.646a.5.5 0 0 0-.708.708l4 4a.5.5 0 0 0 .708 0l4-4a.5.5 0 0 0 0-.708" clip-rule="evenodd"/>
                            </svg>
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="shopDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('user.shop.category', 'tops') }}">Top</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.shop.category', 'bottoms') }}">Bottom</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.shop.category', 'outerwear') }}">Outerwear</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.shop.category', 'dresses') }}">Dress</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('collections*') ? 'active' : '' }}" href="{{ url('/collections') }}">Collections</a>
                </li>
            </ul>
            
            <!-- Right side items -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/search') }}">
                        <i class="fas fa-search"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/wishlist') }}">
                        <i class="fas fa-heart"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ url('/cart') }}">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <span class="cart-count">0</span>
                        </span>
                    </a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>
                            {{ Auth::user()->name }}
                            <span class="svg-wrapper ms-1">
                                <svg class="icon icon-caret" viewBox="0 0 10 6" style="width: 10px; height: 6px; transition: transform 0.3s ease;">
                                    <path fill="currentColor" fill-rule="evenodd" d="M9.354.646a.5.5 0 0 0-.708 0L5 4.293 1.354.646a.5.5 0 0 0-.708.708l4 4a.5.5 0 0 0 .708 0l4-4a.5.5 0 0 0 0-.708" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ url('/profile') }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/orders') }}">
                                    <i class="fas fa-box me-2"></i>My Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/settings') }}">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
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
        
        shopDropdown.addEventListener('show.bs.dropdown', function () {
            shopCaretIcon.style.transform = 'rotate(180deg)';
        });
        
        shopDropdown.addEventListener('hide.bs.dropdown', function () {
            shopCaretIcon.style.transform = 'rotate(0deg)';
        });
        
        // Profile Arrow
        const profileDropdown = document.getElementById('navbarDropdown');
        const profileCaretIcon = profileDropdown.querySelector('.icon-caret');
        
        profileDropdown.addEventListener('show.bs.dropdown', function () {
            profileCaretIcon.style.transform = 'rotate(180deg)';
        });
        
        profileDropdown.addEventListener('hide.bs.dropdown', function () {
            profileCaretIcon.style.transform = 'rotate(0deg)';
        });
    });
</script>