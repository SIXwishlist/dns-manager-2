@extends('layouts.app')

@section('content')
<div class="page-head">
  <h2 class="page-head-title">Người dùng</h2>
  <!--<ol class="breadcrumb page-head-nav">
    <li><a href="#">Home</a></li>
    <li><a href="#">Pages</a></li>
    <li class="active">Blank Page Header</li>
  </ol>-->
</div>
<div class="main-content container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default panel-border-color panel-border-color-primary">
        <div class="panel-heading panel-heading-divider">Cập nhật thông tin</div>
        <div class="panel-body">
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif

          <form role="form" method="POST" name="myform" action="{{ route('user::store') }}">
            {{ csrf_field() }}

            <div class="form-group xs-pt-10{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name">Tên</label>
              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group xs-pt-10{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email">Email</label>
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>

            <script type="text/javascript">
              function randomPassword(length) {
                var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
                var pass = "";
                for (var x = 0; x < length; x++) {
                  var i = Math.floor(Math.random() * chars.length);
                  pass += chars.charAt(i);
                }
                return pass;
              }

              function generate() {
                myform.password.value = randomPassword(8);
              }
            </script>

            <div class="form-group xs-pt-10{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password">Mật khẩu (<input type="button" class="button" value="Generate" onClick="generate();" tabindex="2">)</label>
              <input id="password" type="text" class="form-control" name="password">

              @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group xs-pt-10{{ $errors->has('is_admin') ? ' has-error' : '' }}">
              <label for="is_admin"><input id="is_admin" type="checkbox" value="1" name="is_admin"> Đây là admin</label>

              @if ($errors->has('is_admin'))
                <span class="help-block">
                  <strong>{{ $errors->first('is_admin') }}</strong>
                </span>
              @endif
            </div>

            <div class="xs-pt-15">
              <button type="submit" class="btn btn-space btn-primary">Cập nhật</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
