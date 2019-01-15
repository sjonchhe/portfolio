<!DOCTYPE html>
<html lang="en">
@include('backend.include.header')

<body class="dark-edition" style="background:url({{ URL::asset('backend/img/sidebar-11.jpg')}}) !important;   background-attachment: fixed !important;">
  <div class="wrapper">
    @include('backend.include.sidebar')
    <div class="main-panel">
      @include('backend.include.navbar')
      <div class="content">
        <div class="container-fluid">
          @yield('main-content')
        </div>
      </div>
    </div>
  </div>
  @include('backend.include.footer')
  @yield('scripts')
</body>

</html>
