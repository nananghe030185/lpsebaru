<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LPSE Indonesia hadir untuk menjembatani para pencari proyek dengan proyek yang tepat">
    <meta name="keywords" content="lpse indonesia, data lpse">
    <meta name="author" content="Nanang Hermawan">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="LPSE Indonesia" />
    <link rel="manifest" href="{{ asset('assets/images/site.webmanifest') }}" />
    <title>@yield('title')  | LPSE Indonesia</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    @include('layouts.authentication.css')
  </head>
  <body>
    @yield('main_content')
    @include('layouts.authentication.scripts')
</body>

</html>
