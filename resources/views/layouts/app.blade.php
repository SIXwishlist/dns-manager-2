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


  <style>
    .mr .form-control {
      min-width: 200px;
    }
  </style>
</head>
<body>
  <div class="be-wrapper" id="app">
    <nav class="navbar navbar-default navbar-fixed-top be-top-header">
      <div class="container-fluid">
        <div class="navbar-header"><a href="/" class="navbar-brand"></a></div>
        <div class="be-right-navbar">
          <ul class="nav navbar-nav navbar-right be-user-nav">
            @if (Auth::check())
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="/img/avatar.png" alt="Avatar"><span class="user-name">{{ Auth::user()->name }}</span></a>
                <ul role="menu" class="dropdown-menu">
                  <li>
                    <div class="user-info">
                      <div class="user-name">{{ Auth::user()->name }}</div>
                    </div>
                  </li>
                  @if (Auth::user() instanceof \App\Model\Domain)
                    <li><a href="{{ route('domain::list') }}">Sử dụng tài khoản</a></li>
                    <li>
                        <a href="{{ url('/domain_logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          <span class="icon mdi mdi-power"></span>
                          Logout
                        </a>

                        <form id="logout-form" action="{{ url('/domain_logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                        </form>
                    </li>
                  @else
                    <li><a href="{{ route('settings::index') }}"><span class="icon mdi mdi-settings"></span> Settings</a></li>
                    <li><a href="{{ url('/domain_login') }}">Đăng nhập bằng tên miền</a></li>
                    <li>
                        <a href="{{ url('/logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          <span class="icon mdi mdi-power"></span>
                          Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                        </form>
                    </li>
                  @endif
                </ul>
              </li>
            @endif
          </ul>
        </div>
      </div>
    </nav>

    @if (Auth::user() instanceof \App\User)
      <div class="be-left-sidebar">
        <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Menu</a>
          <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
              <div class="left-sidebar-content">
                <ul class="sidebar-elements">
                  <li class="divider">Menu</li>
                  <li><a href="{{ route('domain::list') }}"><i class="icon mdi mdi-globe"></i><span>Tên miền</span></a>
                  @can('list', App\User::class)
                    <li><a href="{{ route('user::list') }}"><i class="icon mdi mdi-account"></i><span>Người dùng</span></a>
                    <li><a href="{{ route('post::list') }}"><i class="icon mdi mdi-edit"></i><span>Bài viết</span></a>
                  @endcan
                  <li><a href="{{ route('help') }}"><i class="icon mdi mdi-help"></i><span>Trợ giúp</span></a>
                </ul>
              </div>
            </div>
          </div>

          @if (Auth::check())
          <div class="progress-widget">
            <div class="progress-data">
              <span class="progress-value">
                {{ Auth::user()->domain_count }}/{{ Auth::user()->max_domains }}
              </span>
              <span class="name">Số tên miền hiện có</span>
            </div>
            <div class="progress">
              <div style="width: 1%;" class="progress-bar progress-bar-primary"></div>
            </div>
          </div>
          <div class="progress-widget">
            <div class="progress-data">
              <span class="progress-value">
                {{ Auth::user()->record_count }}/{{ Auth::user()->max_records }}
              </span>
              <span class="name">Số bản ghi hiện có</span>
            </div>
            <div class="progress">
              <div style="width: 1%;" class="progress-bar progress-bar-primary"></div>
            </div>
          </div>
          @endif
        </div>
      </div>
    @endif
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
