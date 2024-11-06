<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-birthday-cake brand-icon"></i>
            <span class="brand-text">Cake Orders</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Nav Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" 
                       href="{{ route('orders.index') }}">
                        <i class="fas fa-list"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('orders.create') ? 'active' : '' }}" 
                       href="{{ route('orders.create') }}">
                        <i class="fas fa-plus"></i>
                        <span>New Order</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cakes.*') ? 'active' : '' }}" 
                       href="{{ route('cakes.index') }}">
                        <i class="fas fa-birthday-cake"></i>
                        <span>Cakes</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>