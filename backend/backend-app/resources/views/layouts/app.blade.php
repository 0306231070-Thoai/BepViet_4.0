<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bếp Việt 4.0')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
</head>
<body class="guest"> <div id="wrapper">
        @include('partials.user.sidebar')

        <div id="page-content-wrapper">
            @include('partials.user.navbar')

            <div class="container-fluid px-0 flex-grow-1">
                @yield('content')
            </div>

            @include('partials.user.footer')
        </div>
    </div>

    @include('partials.user.modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
</body>
</html>