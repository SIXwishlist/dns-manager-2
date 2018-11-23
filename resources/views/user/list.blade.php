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
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      <div class="panel panel-default panel-table">
        <div class="panel-heading">Danh sách người dùng
          <div class="tools">
            <a href="{{ route('user::add') }}" class="btn btn-success">Thêm user</a>
          </div>
        </div>
        <div class="panel-body">
          <nav class="xs-pl-20 xs-pr-20">
            <form>
              <input type="text" name="q" placeholder="Tìm người dùng" value="{{ Request::input('q') }}" class="form-control" />
            </form>
          </nav>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th style="width:1%;">ID</th>
                  <th style="width:17%;">Tên</th>
                  <th style="width:17%;">Email</th>
                  <th style="width:17%;">Ngày đăng ký</th>
                  <th style="width:17%;">Ngày Cập nhật</th>
                  <th style="width:15%;">Số tên miền</th>
                  <th style="width:15%;">Số bản ghi DNS</th>
                  <th style="width:10%;"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td>#{{ $user->id }}</td>
                    <td><a href="{{ route('user::edit', [$user->id]) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td class="milestone">
                      <div class="completed">{{ $user->domain_count }} / {{ $user->max_domains }}</div>
                      <div class="progress">
                        <div style="width: 1%" class="progress-bar progress-bar-primary"></div>
                      </div>
                    </td>
                    <td class="milestone">
                      <div class="completed">{{ $user->record_count }} / {{ $user->max_records }}</div>
                      <div class="progress">
                        <div style="width: 1%" class="progress-bar progress-bar-primary"></div>
                      </div>
                    </td>
                    <td class="text-right">
                      <div class="btn-group btn-hspace">
                        <a href="{{ route('user::edit', [$user->id]) }}" class="btn btn-default">
                          <span class="mdi mdi-edit"></span> Sửa
                        </a>
                        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="mdi mdi-chevron-down"></span></button>
                        <ul role="menu" class="dropdown-menu pull-right">
                          <li><delete-user user="{{ $user->id }}"></delete-user></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <nav class="xs-pl-20 xs-pr-20">
            {!! $users->appends(Request::all())->links() !!}
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
