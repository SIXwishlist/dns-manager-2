@extends('layouts.app')

@section('content')
<div class="page-head">
  <h2 class="page-head-title">Trợ giúp</h2>
  <!--<ol class="breadcrumb page-head-nav">
    <li><a href="#">Home</a></li>
    <li><a href="#">Pages</a></li>
    <li class="active">Blank Page Header</li>
  </ol>-->
</div>
<div class="main-content container-fluid">
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach ($posts as $post)
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="heading-{{$post->order}}">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$post->order}}" aria-expanded="true" aria-controls="collapse-{{$post->order}}">
            {{ $post->title }}
          </a>
        </h4>
      </div>
      <div id="collapse-{{$post->order}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-{{$post->order}}">
        <div class="panel-body">
          {!! $post->content !!}
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
