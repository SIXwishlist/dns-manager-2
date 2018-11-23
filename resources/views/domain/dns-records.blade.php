@extends('layouts.app')

@section('content')
<div class="page-head">
  <h2 class="page-head-title">{{ $domain->name }}</h2>
  <!--<ol class="breadcrumb page-head-nav">
    <li><a href="#">Home</a></li>
    <li><a href="#">Pages</a></li>
    <li class="active">Blank Page Header</li>
  </ol>-->
</div>
<div class="main-content container-fluid">
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default panel-table">
        <div class="panel-heading">
          Danh sách bản ghi
        </div>
        <div class="panel-body">
          <div class="xs-pl-20 xs-pr-20">
            <div class="alert alert-warning"><img src="http://findicons.com/files/icons/730/soft/128/tips.png" height="14" /> Để cập nhật bản ghi, chỉ cần nhập thay đổi của bản ghi vào các ô tương ứng, hệ thống sẽ tự động lưu lại các thay đổi này.</div>
          </div>
          <div class="table-responsive mr">
            <records-table domain="{{ $domain->name_ascii }}" :records="{{ json_encode($records->getCollection()->toArray()) }}"></records-table>
          </div>
          <nav class="xs-pl-20 xs-pr-20">
            {!! $records->links() !!}
          </nav>
        </div>
      </div>
      <div class="panel panel-default panel-table">
        <div class="panel-heading">
          Bản ghi NS mặc định
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th style="width:10%;">Loại</th>
                  <th>Giá trị</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach (config('dns.nameservers') as $ns)
                  <tr>
                    <td>NS</td>
                    <td>{{ $ns }}</td>
                    <td>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">
                        Thay đổi
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <nav class="xs-pl-20 xs-pr-20">
            {!! $records->links() !!}
          </nav>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <form class="modal-content" action="{{ route('domain::update-ns-record', [$domain->name_ascii]) }}" method="POST">
            {{ csrf_field() }}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Thay đổi bản ghi DNS mặc định</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="ns1">Bản ghi NS 1</label>
                <input type="text" name="ns1" id="ns1" class="form-control" value="" />
              </div>
              <div class="form-group">
                <label for="ns2">Bản ghi NS 2</label>
                <input type="text" name="ns2" id="ns2" class="form-control" value="" />
              </div>
              <div class="form-group">
                <label for="note">Lý do</label>
                <textarea name="note" id="note" class="form-control"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ bỏ</button>
              <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          Thêm bản ghi
        </div>
        <div class="panel-body">
          <add-record domain="{{ $domain->name_ascii }}"></add-record>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
