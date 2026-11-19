<!-- google fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Manrope:wght@400;500;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/unicons/unicons.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/frontend/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/colors/grape.css')}}">
<link rel="preload" href="{{ asset('assets/css/fonts/space.css')}}" as="style" onload="this.rel='stylesheet'">
<style>
.active>.page-link, .page-link.active,
.plyr__control--overlaid:focus, .plyr__control--overlaid:hover{
    color: #605dba !important;
}
.accordion-wrapper .card-header button.collapsed {
color: #343f52 !important;
}
.accordion-wrapper .card-header button:hover,
.accordion-wrapper .card-header button{
    color: #605dba !important;
}
</style>
@yield('css')