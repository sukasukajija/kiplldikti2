<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/reverse.css') }}">

    <!--favicon tab -->
    <title>SIM KIPK LLDIKTI Wilayah 2</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &mdash; Digitalisasi KIP Merdeka - LLDIKTI 2</title>

    <!-- Google Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Vite (Laravel) -->
    @vite(['resources/js/app.js'])
    <style>
    .page-item.active .page-link {
        background-color: #6777ef;
        border-color: #6777ef;
        color: #fff;
      }
    </style>
</head>

<body>
    @php
    $isWelcome = request()->routeIs('welcome');
    @endphp
    <div id="app">
        <div class="main-wrapper">
            <div class="layout-row">

                @auth
                <!-- Sidebar -->
                @include('components.sidebar')
                @endauth

            <div class="main-wrapper">
            @if (!$isWelcome)
            <!-- Header -->
            @include('components.header')
            @endif
            <!-- Content -->
            @yield('content')
            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>
</div>
</div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery and Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Libraries -->
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    @stack('scripts')

    <!-- Template JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

</body>
</html>
