<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'DNS Manager') }}</title>

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/material-design-iconic-font.min.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.min.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css"/>

  <!-- Scripts -->
  <script>
    window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
    ]); ?>
  </script>
</head>
<body class="be-splash-screen">
  <div class="be-wrapper be-login" id="app">
    <div class="be-content">
      @yield('content')
    </div>
  </div>

  <!-- Scripts -->
  <script src="/js/app.js"></script>
  <script src="/js/perfect-scrollbar.jquery.min.js"></script>
  <script src="/js/fbi.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      //initialize the javascript
      App.init();
    });

  </script>
</body>
</html>
