@extends('site.layouts.front')

@section('title') {{ $page->title }} @endsection

@section('breadcrumbs')
- {{ $page->title }}
@endsection

@section('content')
<div class="title-top title-top--small">
	<h2>{{ $page->title }}</h2>
</div>

<div class="px-4 py-4" style="margin-bottom: 30px;">
{!! $page->content !!}
</div>
@endsection
