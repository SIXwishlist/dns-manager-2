@extends('layouts.guest')

@section('content')
<div class="main-content container-fluid">
  <div class="splash-container">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-heading"><img src="{{ asset('img/logo-xx.png') }}" alt="logo" width="102" height="27" class="logo-img"><span class="splash-description">Đặt lại mật khẩu.</span></div>
      <div class="panel-body">
        @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
        @endif

        <form role="form" method="POST" action="{{ url('/password/reset') }}">
          {{ csrf_field() }}

          <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="Email" required autofocus>

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
            <button data-dismiss="modal" type="submit" class="btn btn-primary btn-xl">Đặt lại mật khẩu</button>
          </div>
        </form>
      </div>
    </div>
    <div class="splash-footer"><span><a href="{{ url('/') }}">Trang chủ</a></span></div>
  </div>
</div>
@endsection
