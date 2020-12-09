@extends('admin.layouts.app')

@section('title', 'Записи блога')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    @include('admin.components.breadcrumb', ['lastTitle' => 'Записи блога'])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Записи <small>блога</small></h3>
            <div class="block-options">
                <a href="{{ route('admin.blogposts.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus mr-5"></i>Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-responsive table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                <tr>
                    <th class="sorting_desc">Заголовок</th>
                    <th>Краткое описание</th>
                    <th>Категория</th>
                    <th class="text-center" style="width: 15%;">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td class="font-w600">{{ $post->getTitle() }}</td>
                        <td class="font-w600">{{ $post->getShortContent() }}</td>
                        <td class="font-w600">@if ($post->category) {{ $post->category->getTitle() }} @else --нет-- @endif</td>
                       {{-- <td>
                            {{ $post->getParentCategoryTitle() }}
                        </td>--}}
                    {{--    <td>{!! $post->getActiveRender() !!}</td>--}}
                        <td class="text-center d-flex align-items-center justify-content-around">
                            <a data-toggle="tooltip" title="Редактировать" class="btn btn-sm btn-alt-info" href="{{ route('admin.blogposts.edit', $post->id) }}"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{ route('admin.blogposts.destroy', $post->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-alt-danger" onclick="return confirm('Вы уверены?')" data-toggle="tooltip" title="Удалить">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

@endsection
