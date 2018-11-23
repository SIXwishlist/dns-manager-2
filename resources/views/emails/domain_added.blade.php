Tên miền <strong>{{ $domain->name }}</strong> đã được thêm vào tài khoản của bạn.

Truy cập vào <a href="{{ route('domain::dns', [$domain->name_ascii]) }}">{{ route('domain::dns', [$domain->name_ascii]) }}</a>
@if ($password)
và sử dụng mật khẩu là: <strong>{{ $password }}</strong>
@endif
để quản lý bản ghi của tên miền này.
