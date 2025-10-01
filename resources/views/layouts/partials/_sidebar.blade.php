{{-- resources/views/layouts/partials/_sidebar.blade.php --}}
<div class="column is-2 is-fullheight is-hidden-touch" id="sidebar">
    <aside class="menu">
        <p class="menu-label is-hidden-touch">
            Navigasi Utama
        </p>
        <ul class="menu-list">
            <li>
                <a class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="icon"><i class="fa fa-home"></i></span>
                    Dashboard
                </a>
            </li>
        </ul>

        <p class="menu-label is-hidden-touch">
            Master Data
        </p>
        <ul class="menu-list">
            <li>
                <a class="{{ request()->routeIs('kurikulums.*') ? 'is-active' : '' }}" href="{{ route('kurikulums.index') }}">
                    <span class="icon"><i class="fa fa-book"></i></span>
                    Kurikulum
                </a>
            </li>
            <li>
                {{-- TAUTAN BARU UNTUK MATERI --}}
                <a class="{{ request()->routeIs('materis.*') ? 'is-active' : '' }}" href="{{ route('materis.index') }}">
                    <span class="icon"><i class="fa fa-file-alt"></i></span>
                    Materi
                </a>
            </li>
            <li>
                {{-- TAUTAN BARU UNTUK RESEP --}}
                <a class="{{ request()->routeIs('reseps.*') ? 'is-active' : '' }}" href="{{ route('reseps.index') }}">
                    <span class="icon"><i class="fa fa-utensils"></i></span>
                    Resep
                </a>
            </li>
        </ul>
    </aside>
</div>
