<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> --}}
    <link href="{{asset('assets/layout-admin/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{asset('assets/layout-admin/css/bootstrap5.min.css')}}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paginas.index') }}">Páginas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="{{asset('assets/layout-admin/js/bootstrap-5.js')}}"></script>
    <!--CKEDITOR CDN -->
    <script src="{{asset('assets/layout-admin/js/ckeditor.js')}}"></script>
    <!--Jquery 3.6.0 -->
    <script src="{{asset('assets/layout-admin/js/jquery3-6-0.js')}}"></script>
    @yield('js')
</body>
</html>
