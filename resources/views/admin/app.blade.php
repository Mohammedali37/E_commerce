<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>

    @include('admin.partials.navber')
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div col-md-12>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  @yield("breadcrumbs")
                </ol>
              </nav>
            </div>
    @yield('content')
  </main>
   

    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    <script src="vendor/select2/dist/js/select2.min.js"></script>

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
    @yield('scripts')
</body>
</html>
