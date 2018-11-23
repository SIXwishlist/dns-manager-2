@extends('layouts.guest')

@section('content')
<div class="main-content container-fluid">
  <div class="splash-container">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-heading"><img src="{{ asset('img/logo-xx.png') }}" alt="logo" height="100" class="logo-img"><!--<span class="splash-description">Please enter your user information.</span>--></div>
      <div class="panel-body">
        <form role="form" method="POST" action="{{ url('/login') }}">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="off" required autofocus>

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
          <div class="form-group row login-tools">
            <div class="col-xs-6 login-remember">
              <div class="be-checkbox">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ghi nhớ đăng nhập</label>
              </div>
            </div>
            <div class="col-xs-6 login-forgot-password"><a href="{{ url('/password/reset') }}">Quên mật khẩu?</a></div>
          </div>
          <div class="form-group login-submit">
            <button data-dismiss="modal" type="submit" class="btn btn-primary btn-xl">Đăng nhập</button>
          </div>
        </form>
      </div>
    </div>
    <div class="splash-footer"><span>Không có tài khoản? <a href="{{ url('/register') }}">Đăng ký</a></span></div>
    <div class="splash-footer"><span><a href="{{ url('/domain_login') }}">Đăng nhập bằng tên miền</a></span></div>
    <div class="panel panel-default panel-border-color panel-border-color-primary"><div class="panel-body">
      • Quản trị domain giúp bạn cấu hình các thông số domain tiện lợi nhanh chóng và miễn phí<br />
      • Các tính năng đầy đủ như một domain quốc tế:<br />
      -  A record (IP Address), CName (Alias), MX (Mail), TXT <br />
      -  URL Redirect: Cho phép chuyển hướng truy cập đến một website nào đó.<br />
      -  URL Frame: Cho phép lồng một website nào đó vào tên miền.<br />
      -  Email Forwarding: Cho phép tạo các địa chỉ email với định dạng tenhopmail@tenmien.vn, các hộp email này sẽ forward email đến địa chỉ email thực sự của bạn (như @yahoo.com, @gmail.com, ...)<br />
      • DNS phải chuyển về: <strong>ns1.zdns.vn</strong> | <strong>ns2.zdns.vn</strong> |
    </div></div>
  </div>
</div>
@endsection
