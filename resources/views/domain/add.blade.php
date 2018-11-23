@extends('layouts.app')

@section('content')
<div class="page-head">
  <h2 class="page-head-title">Tên miền</h2>
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
        <div class="panel-heading panel-heading-divider">Thêm tên miền<span class="panel-subtitle">Thêm 1 tên miền mới</span></div>
        <div class="panel-body">
          <form role="form" method="POST" name="myform" action="{{ route('domain::store') }}">
            {{ csrf_field() }}
            <div class="form-group xs-pt-10{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name">Tên miền</label>
              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>

            @if (auth()->user()->is_admin)
            <div class="form-group xs-pt-10{{ $errors->has('user_id') ? ' has-error' : '' }}">
              <label for="name">Người dùng quản lý</label>

              <select class="form-control" name="user_id">
                @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
              </select>
            </div>
            @endif

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

            <div class="xs-pt-15">
              <button type="submit" class="btn btn-space btn-primary">Thêm</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
