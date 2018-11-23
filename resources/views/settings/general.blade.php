@extends('layouts.app')

@section('content')
<div class="page-head">
  <h2 class="page-head-title">Cài đặt</h2>
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

          <form role="form" method="POST" action="{{ route('settings::postGeneral') }}">
            {{ csrf_field() }}

            <div class="form-group xs-pt-10{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name">Tên</label>
              <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required autofocus>

              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group xs-pt-10{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email">Tên</label>
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required autofocus>

              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group xs-pt-10{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password">Mật khẩu mới (Chỉ nhập khi muốn thay đổi mật khẩu)</label>
              <input id="password" type="password" class="form-control" name="password">

              @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="password-confirm">Xác nhận mật khẩu</label>
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
            </div>

            <div class="form-group xs-pt-10{{ $errors->has('old_password') ? ' has-error' : '' }}">
              <label for="old-password" class="text-danger">Nhập mật khẩu hiện tại để xác nhận thay đổi</label>
              <input id="old-password" type="password" class="form-control" name="old_password">

              @if ($errors->has('old_password'))
                <span class="help-block">
                  <strong>{{ $errors->first('old_password') }}</strong>
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
