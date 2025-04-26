<html lang="en" class="h-100">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta charset="UTF-8">
    <title>
        @yield('title')
    </title>
    
    <link rel="preload" as="font" type="font/woff2" href="/fonts/turbinado-light.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="/fonts/montserrat-regular.woff2" crossorigin>

    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="/css/footer.css" />

    @yield('stylesheets')
    <script src="/assets/js/vendor/jquery.min.js"></script>
    <script src="/assets/dist/js/bootstrap.bundle.js"></script>
    <script src="/js/server-session.js" ></script>
    @yield('header_javascripts')

</head>

<body class="d-flex flex-column h-100">
    @include('header.app')
    @yield('children')
    @include('footer.app')
    <script src="/js/cart.js" ></script>
    <script src="/js/search.js" ></script>
    @yield('body_javascripts')
</body>

</html>
