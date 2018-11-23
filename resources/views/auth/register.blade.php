@extends('layouts.guest')

@section('content')
<div class="main-content container-fluid">
  <div class="splash-container">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-heading"><img src="{{ asset('img/logo-xx.png') }}" alt="logo" width="102" height="27" class="logo-img"><span class="splash-description">Đăng ký tài khoản.</span></div>
      <div class="panel-body">
        <form role="form" method="POST" action="{{ url('/register') }}">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <input id="name" type="name" class="form-control" name="name" value="{{ old('name') }}" placeholder="Tên của bạn" required autofocus>

            @if ($errors->has('name'))
              <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

            @if ($errors->has('email'))
              <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
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

          <div class="form-group">
            <input id="password-confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
          </div>

          <div class="form-group login-submit">
            <button data-dismiss="modal" type="submit" class="btn btn-primary btn-xl">Đăng ký</button>
          </div>
        </form>
      </div>
    </div>
    <div class="splash-footer"><span>Đã có tài khoản? <a href="{{ url('/login') }}">Đăng nhập</a></span></div>
  </div>
</div>
@endsection
