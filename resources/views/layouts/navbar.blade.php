<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <h4 class="text-center sidebar-heading">Admin Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="bi bi-person"></i> Users
                </a>
            </li>
            <!-- Add more links as needed -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                    <i class="bi bi-gear"></i> Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                    <i class="bi bi-file-earmark-text"></i> Reports
                </a>
            </li> --}}
        </ul>
    </div>
</nav>
