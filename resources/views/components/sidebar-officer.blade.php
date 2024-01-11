    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li
                class="sidebar-item {{ request()->is('officer/dashboard') ? 'active' : '' }}">
                <a href="{{ route('officer.dashboard') }}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-title">Manajemen Buku</li>

            <li
                class="sidebar-item {{ request()->is('officer/book-categories*') ? 'active' : '' }}">
                <a href="{{ route('officer.book-categories.index') }}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Kategori</span>
                </a>
            </li>

            <li class="sidebar-title">Akun</li>

            <li
                class="sidebar-item">
                <a href="{{ route('profile.edit') }}" class='sidebar-link'>

                    <span>Setelan Akun</span>
                </a>
            </li>

        </ul>
    </div>
