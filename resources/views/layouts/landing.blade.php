<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'GriskaNutri')</title>

    {{-- TAMBAHKAN KODE FAVICON DI SINI --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Link CSS Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    {{-- CSS Eksternal --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    {{-- Jika ada CSS khusus per halaman --}}
    @stack('styles')
</head>
<body>
    {{-- ================= HEADER / NAVIGASI ================= --}}
   <header class="header animated fade-in-down">
            <nav class="nav container">
                <a
                    href="/"
                    class="nav-logo"
                    style="
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    "
                >
                    <img
                        width="75px"
                        src="{{ asset('images/logo/logo-ppko-imm-fkm.png') }}"
                        alt="Logo PPKO IMM FKM"
                    />
                    <span class="nav-logo-text">GriskaNutri</span>
                </a>

                <div class="nav-menu" id="nav-menu">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#desa" class="nav-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="#proker"
                                class="nav-link dropdown-toggle"
                                style="padding: 10px"
                                >GRISKA &#9662;</a
                            >
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('kurikulum.index') }}">Kurikulum & Materi</a></li>
                                <li><a href="{{ route('resep.index') }}">Resep Sehat</a></li>
                                <li><a href="#">Statistik Stunting</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#contact" class="nav-link">Contact</a>
                        </li>
                        @auth
                            {{-- Tampil jika pengguna sudah login --}}
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-toggle" style="padding: 10px">{{ Auth::user()->name }} &#9662;</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Profil</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                Log Out
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                </div>

                <div class="hamburger" id="hamburger">&#9776;</div>
            </nav>
        </header>


    {{-- ================= KONTEN UTAMA (YANG BERUBAH) ================= --}}
    <main>
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
   <footer class="footer">
            <div class="container footer-content">
                <p>&copy; 2025 Sekolah Perempuan GRISKA & IMM FKM UAD.</p>
                <div class="footer-socials">
                    <a
                        href="https://www.instagram.com/ppkormawa_immfkm/"
                        title="Instagram"
                        ><i class="fa-brands fa-instagram"></i
                    ></a>
                    <a
                        href="https://www.youtube.com/@immfkmuad8889"
                        title="YouTube"
                        ><i class="fa-brands fa-youtube"></i
                    ></a>
                    <a
                        href="https://www.tiktok.com/@ppko.imm.fkm"
                        title="TikTok"
                        ><i class="fa-brands fa-tiktok"></i
                    ></a>
                </div>
                <a href="https://uad.ac.id/">Universitas Ahmad Dahlan</a>
            </div>
        </footer>

     {{-- ... (kode footer Anda) ... --}}

    {{-- JAVASCRIPT Eksternal --}}
    <script src="{{ asset('js/landing.js') }}"></script>
    @stack('scripts')

    <a href="#" id="scrollToTopBtn" class="scroll-to-top">
        <i class="fa-solid fa-arrow-up"></i>
    </a>
</body>
</html>
