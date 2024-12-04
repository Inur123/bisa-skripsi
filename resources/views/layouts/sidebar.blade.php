<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="./index.html" class="text-nowrap logo-img">
          <img src="../assets/images/logos/logo-light.svg" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
            <span class="hide-menu">Home</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link {{ request()->is(auth()->user()->role === 'mahasiswa' ? 'mahasiswa/dashboard' : 'admin/dashboard') ? 'active' : '' }}"
               href="{{ url(auth()->user()->role === 'mahasiswa' ? 'mahasiswa/dashboard' : 'admin/dashboard') }}"
               aria-expanded="false">
                <span>
                    <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Dashboard</span>
            </a>
          </li>

          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
            <span class="hide-menu">Data</span>
          </li>

          @if(auth()->user()->role === 'admin') {{-- Check if the user role is admin --}}
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ url('admin/users') }}" aria-expanded="false">
                    <span>
                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                    </span>
                    <span class="hide-menu">User</span>
                </a>
            </li>
          @endif

          <!-- Add Pengumuman menu for both admin and mahasiswa -->
          @if(auth()->user()->role === 'admin')
          <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.create_announcement') ? 'active' : '' }}" href="{{ route('admin.create_announcement') }}" aria-expanded="false">
                <span>
                    <!-- Ganti dengan ikon yang valid -->
                    <iconify-icon icon="solar:megaphone-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                  <span class="hide-menu">Pengumuman</span>
              </a>
          </li>
      @endif


        </ul>
        <div class="unlimited-access hide-menu bg-primary-subtle position-relative mb-7 mt-7 rounded-3">
          <div class="d-flex">
            <div class="unlimited-access-title me-3">
              <h6 class="fw-semibold fs-4 mb-6 text-dark w-75">Upgrade to pro</h6>
              <a href="#" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Pro</a>
            </div>
            <div class="unlimited-access-img">
              <img src="../assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>
