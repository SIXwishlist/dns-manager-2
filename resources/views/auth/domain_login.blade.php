@extends('layouts.guest')

@section('content')
<div class="main-content container-fluid">
  <div class="splash-container">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-heading"><img src="{{ asset('img/logo-xx.png') }}" alt="logo" width="102" height="27" class="logo-img"><span class="splash-description">Please enter your user information.</span></div>
      <div class="panel-body">
        <form role="form" method="POST" action="{{ url('/domain_login') }}">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <input id="name" type="name" class="form-control" name="name" value="{{ old('name') }}" placeholder="Tên miền" autocomplete="off" required autofocus>

            @if ($errors->has('name'))
              <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
            @if ($errors->has('password'))
              <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group row login-tools">
            <div class="col-xs-6 login-remember">
              <div class="be-checkbox">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ghi nhớ đăng nhập</label>
              </div>
            </div>
          </div>
          <div class="form-group login-submit">
            <button data-dismiss="modal" type="submit" class="btn btn-primary btn-xl">Đăng nhập</button>
          </div>
        </form>
      </div>
    </div>
    <div class="splash-footer"><span><a href="{{ url('/login') }}">Đăng nhập bằng tài khoản</a></span></div>
  </div>
</div>
@endsection
