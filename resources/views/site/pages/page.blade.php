@extends('site.layouts.front')

@section('title') {{ $page->title }} @endsection

@section('breadcrumbs')
- {{ $page->title }}
@endsection

@section('content')
{{--	<style>--}}
{{--		a{--}}
{{--			color: orange;--}}
{{--		}--}}
{{--	</style>--}}
<div class="title-top title-top--small">
	<h2>{{ $page->title }}</h2>
</div>

<div style="padding: 20px;">
{!! $page->content !!}
</div>
@endsection
