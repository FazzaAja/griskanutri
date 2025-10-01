<!DOCTYPE html>
<html>
<head>
    @include('layouts.partials._head')
</head>
<body>
    @include('layouts.partials._header')
    <div class="columns" id="app-content">

        @include('layouts.partials._sidebar')

        {{-- Konten utama halaman akan dimuat di sini --}}
        <div class="column is-10" id="page-content">
            @yield('content')
        </div>

    </div>

    @include('layouts.partials._scripts')

    {{-- Tempat untuk script tambahan per halaman --}}
    @stack('scripts')
</body>
</html>
