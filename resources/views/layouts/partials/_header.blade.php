<nav class="navbar columns is-fixed-top" role="navigation" aria-label="main navigation" id="app-header">
    {{-- Bagian Brand/Logo --}}
    <div class="navbar-brand column is-2 is-paddingless">
        <a class="navbar-item" href="{{ route('dashboard') }}">
            GriskaNutri ADMIN
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="touchMenu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    {{-- Menu untuk Tampilan Mobile (touch) --}}
    <div id="touchMenu">
        <a class="navbar-item {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">
            <span class="icon"><i class="fa fa-home"></i></span> Dashboard
        </a>
        <a class="navbar-item {{ request()->routeIs('kurikulums.*') ? 'is-active' : '' }}" href="{{ route('kurikulums.index') }}">
            <span class="icon"><i class="fa fa-book"></i></span> Kurikulum
        </a>
        <a class="navbar-item {{ request()->routeIs('materis.*') ? 'is-active' : '' }}" href="{{ route('materis.index') }}">
            <span class="icon"><i class="fa fa-file-alt"></i></span> Materi
        </a>
        <a class="navbar-item {{ request()->routeIs('reseps.*') ? 'is-active' : '' }}" href="{{ route('reseps.index') }}">
            <span class="icon"><i class="fa fa-file-alt"></i></span> Resep
        </a>
        {{-- Tombol Logout Aman untuk Mobile --}}
        <form method="POST" action="{{ route('logout') }}" class="navbar-item">
            @csrf
            <a class="has-text-grey-dark is-fullwidth" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                <span class="icon"><i class="fa fa-sign-out-alt"></i></span> Logout
            </a>
        </form>
    </div>

    {{-- Menu untuk Tampilan Desktop --}}
    <div id="navMenu" class="navbar-menu column is-hidden-touch">
        <div class="navbar-end">
            @auth
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <figure class="image avatar is-32x32">
                        {{-- Menggunakan accessor avatar_url dari model User --}}
                        <img class="is-rounded" src="{{ auth()->user()->avatar_url }}">
                    </figure>
                    {{-- Menampilkan nama pengguna yang login --}}
                    &nbsp; Hi, {{ auth()->user()->name }}
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="#">
                        My Profile
                    </a>
                    <hr class="navbar-divider">
                    {{-- Tombol Logout Aman untuk Desktop --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="navbar-item app-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                            Logout
                        </a>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
    <div id="navMenu" class="navbar-menu column is-hidden-touch">
        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <figure class="image avatar is-32x32">
                        {{-- Ganti dengan helper asset() --}}
                        <img class="is-rounded" src="{{ asset('images/user1.jpeg') }}">
                    </figure>
                    &nbsp; Hi, Admin
                </a>
                <div class="navbar-dropdown">
                    {{-- <a class="navbar-item">
                        My Profile
                    </a>
                    <a class="navbar-item">
                        Settings
                    </a> --}}
                    <hr class="navbar-divider">
                    <a class="navbar-item app-logout">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
