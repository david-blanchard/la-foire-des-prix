@php
    $hasErrors = count($errors); 
@endphp
<html lang="en" class="h-100">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta charset="UTF-8">
    <title>
        @yield('title')
    </title>

    <link rel="preload" as="font" type="font/woff2" href="/fonts/turbinado-light.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="/fonts/montserrat-regular.woff2" crossorigin>
    
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/footer.css" />
    <link rel="stylesheet" href="/css/admin.css" />

    @yield('stylesheets')
    <script src="/assets/js/vendor/jquery.slim.min.js"></script>
    <script src="/assets/dist/js/bootstrap.bundle.js"></script>
    @yield('header_javascripts')

    @if($hasErrors)
    <style>
        .invalid-feedback {
            display: block !important;
        }
    </style> 
    @endif

</head>

<body class="d-flex flex-column h-100">
    @include('header.admin')
    @yield('children')
    @include('footer.admin')
    @yield('body_javascripts')
    
</body>

</html>
