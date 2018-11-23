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
  @if ($domains->count())
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default panel-table">
        <div class="panel-heading">Danh sách tên miền
          <div class="tools">
            <a href="{{ route('domain::add') }}" class="btn btn-success">Thêm tên miền</a>
          </div>
        </div>
        <div class="panel-body">
          <nav class="xs-pl-20 xs-pr-20">
            <form>
              <input type="text" name="q" placeholder="Tìm tên miền" value="{{ Request::input('q') }}" class="form-control" />
            </form>
          </nav>
          <div class="table-responsive">
            <table class="table table-striped table-hover ">
              <thead>
                <tr>
                  <th style="width:20%;">Tên miền</th>
                  <th style="width:17%;">Cho phép đăng nhập</th>
                  @if (auth()->user()->is_admin)
                  <th style="width:17%;">Chủ sở hữu</th>
                  @endif
                  <th style="width:15%;">Số bản ghi DNS</th>
                  <th style="width:10%;">Ngày tạo</th>
                  <th style="width:10%;">Ngày cập nhật</th>
                  <th style="width:10%;"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($domains as $domain)
                  <tr>
                    <td><a href="{{ route('domain::dns', [$domain->name_ascii]) }}">{{ $domain->name }}</a></td>
                    <td>
                      @if ($domain->is_login_allowed)
                        <span class="mdi mdi-check-circle text-success"></span>
                        <span class="btn-group">
                          <add-domain-password :change="true" domain="{{ $domain->name_ascii }}" id="{{ $domain->id }}"></add-domain-password>
                          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-xs"><span class="mdi mdi-chevron-down"></span></button>
                          <ul role="menu" class="dropdown-menu pull-right">
                            <li><remove-domain-password domain="{{ $domain->name_ascii }}"></remove-domain-password></li>
                          </ul>
                        </span>
                        <add-domain-password-modal :change="true" domain="{{ $domain->name_ascii }}" id="{{ $domain->id }}"></add-domain-password-modal>
                      @else
                        <span class="mdi mdi-circle text-muted"></span>
                        <add-domain-password :change="false" domain="{{ $domain->name_ascii }}" id="{{ $domain->id }}"></add-domain-password>
                        <add-domain-password-modal :change="false" domain="{{ $domain->name_ascii }}" id="{{ $domain->id }}"></add-domain-password-modal>
                      @endif
                    </td>
                    @if (auth()->user()->is_admin)
                    <th style="width:17%;">{{ $domain->owner->name }}</th>
                    @endif
                    <td class="milestone">
                      <div class="completed">{{ $domain->record_count }} / ∞</div>
                      <div class="progress">
                        <div style="width: 1%" class="progress-bar progress-bar-primary"></div>
                      </div>
                    </td>
                    <td>{{ $domain->created_at }}</td>
                    <td>{{ $domain->updated_at }}</td>
                    <td class="text-right">
                      <div class="btn-group btn-hspace">
                        <a href="{{ route('domain::dns', [$domain->name_ascii]) }}" class="btn btn-default">
                          <span class="mdi mdi-format-list-bulleted"></span> Quản lý các bản ghi DNS
                        </a>
                        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="mdi mdi-chevron-down"></span></button>
                        <ul role="menu" class="dropdown-menu pull-right">
                          <li><delete-domain domain="{{ $domain->name_ascii }}"></delete-domain></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <nav class="xs-pl-20 xs-pr-20">
            {!! $domains->appends(Request::all())->links() !!}
          </nav>
        </div>
      </div>
    </div>
  </div>
  @else
  <h3 class="text-center">Hiện tại bạn chưa quản lý tên miền nào.</h3>
  <div class="text-center"><a href="{{ route('domain::add') }}" class="btn btn-success btn-xl">Thêm tên miền</a></div>
  @endif
</div>
@endsection
