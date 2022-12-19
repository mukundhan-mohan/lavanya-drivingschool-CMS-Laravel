<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="baseurl" content="{{ url('/') }}">
  <title>@yield('title')</title>

  @include('layouts.partials.css')
  
  @yield('css')

  <script>
      window.baseUrl ="{{ url('/') }}";
  </script>

<body class="@yield('bodyclass')">
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      @auth
        @include('layouts.partials.topnav')
      @endauth

      @auth
        @include('layouts.partials.leftnav')
      @endauth
      
      @yield('content')

      @include('layouts.partials.footer')

    </div>
  </div>

  @include('layouts.partials.scripts')

  @yield('js')

</body>
</html>