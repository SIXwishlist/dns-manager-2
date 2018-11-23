@extends('layouts.guest')

@section('content')
<div class="main-content container-fluid">
  <div class="splash-container">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-heading"><img src="{{ asset('img/logo-xx.png') }}" alt="logo" width="102" height="27" class="logo-img"><span class="splash-description">Lấy lại mật khẩu.</span></div>
      <div class="panel-body">
        @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
        @endif

        <form role="form" method="POST" action="{{ url('/password/email') }}">
          {{ csrf_field() }}

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Địa chỉ email của bạn" autocomplete="off" required autofocus>

            @if ($errors->has('email'))
              <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group login-submit">
            <button data-dismiss="modal" type="submit" class="btn btn-primary btn-xl">Lấy lại mật khẩu</button>
          </div>
        </form>
      </div>
    </div>
    <div class="splash-footer"><span><a href="{{ url('/') }}">Trang chủ</a></span></div>
  </div>
</div>
@endsection
