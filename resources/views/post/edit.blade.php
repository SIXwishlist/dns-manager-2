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
      <div class="panel panel-default panel-border-color panel-border-color-primary">
        <div class="panel-heading panel-heading-divider">Cập nhật thông tin</div>
        <div class="panel-body">
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif

          <form role="form" method="POST">
            {{ csrf_field() }}

            <div class="form-group xs-pt-10{{ $errors->has('title') ? ' has-error' : '' }}">
              <label for="title">Tiêu đề</label>
              <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}" required autofocus>

              @if ($errors->has('title'))
                <span class="help-block">
                  <strong>{{ $errors->first('title') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group xs-pt-10{{ $errors->has('order') ? ' has-error' : '' }}">
              <label for="order">Thứ tự</label>
              <input id="order" type="number" class="form-control" name="order" value="{{ old('order', $post->order) }}" required autofocus>

              @if ($errors->has('order'))
                <span class="help-block">
                  <strong>{{ $errors->first('order') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group xs-pt-10{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="content">Nội dung</label>
              <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
              <script>

              tinymce.init({
                selector: 'textarea',
                height: 500,
                theme: 'modern',
                plugins: [
                  'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                  'searchreplace wordcount visualblocks visualchars code fullscreen',
                  'insertdatetime media responsivefilemanager nonbreaking save table contextmenu directionality',
                  'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
                ],
                toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
                image_advtab: true,
                templates: [
                  { title: 'Test template 1', content: 'Test 1' },
                  { title: 'Test template 2', content: 'Test 2' }
                ],
                content_css: [
                  '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                  '//www.tinymce.com/css/codepen.min.css'
                ],

                external_filemanager_path:"/filemanager/",
                filemanager_title:"Responsive Filemanager" ,
                external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
               });

              </script>
              <textarea name="content" id="content">{{ $post->content }}</textarea>

              @if ($errors->has('content'))
                <span class="help-block">
                  <strong>{{ $errors->first('content') }}</strong>
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
