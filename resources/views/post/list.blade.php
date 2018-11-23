@extends('layouts.app')

@section('content')
<div class="page-head">
  <h2 class="page-head-title">Bài viết</h2>
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
        <div class="panel-heading">Danh sách bài viết
          <div class="tools">
            <a href="{{ route('post::add') }}" class="btn btn-success">Thêm post</a>
          </div>
        </div>
        <div class="panel-body">
          <nav class="xs-pl-20 xs-pr-20">
            <form>
              <input type="text" name="q" placeholder="Tìm bài viết" value="{{ Request::input('q') }}" class="form-control" />
            </form>
          </nav>
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Tiêu đề</th>
                <th>Thứ tự</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th style="width:10%;"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($posts as $post)
                <tr>
                  <td>{{ $post->title }}</td>
                  <td>#{{ $post->order }}</td>
                  <td>{{ $post->created_at }}</td>
                  <td>{{ $post->updated_at }}</td>
                  <td class="text-right">
                    <div class="btn-group btn-hspace">
                      <a href="{{ route('post::edit', [$post->id]) }}" class="btn btn-default">
                        <span class="mdi mdi-edit"></span> Sửa
                      </a>
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li><delete-post post="{{ $post->id }}"></delete-post></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <nav class="xs-pl-20 xs-pr-20">
            {!! $posts->appends(Request::all())->links() !!}
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
