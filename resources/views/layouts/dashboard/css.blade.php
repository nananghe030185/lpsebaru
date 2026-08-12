    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/scrollbar.css') }}">
    <!-- Plugins css Ends-->
    @yield('css')
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    @vite(['resources/assets/scss/style.scss'])

    <link id="color" rel="stylesheet" href="{{ minify('/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ minify('/css/responsive.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ minify('/css/vendors/toastr.min.css')}}">

