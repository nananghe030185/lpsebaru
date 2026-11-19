<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.layouts.header')
    @include('frontend.layouts.css')
</head>

<body>
    
  <div class="grow shrink-0">
    @include('frontend.layouts.navbar')
    @yield('jumbotron')
    <!-- /header -->
    
    @yield('main')
    <!-- /section -->
  </div>
  <!-- /.content-wrapper -->
  @include('frontend.layouts.footer')
  <!-- progress wrapper -->

  @include('frontend.layouts.script')
</body>

</html>