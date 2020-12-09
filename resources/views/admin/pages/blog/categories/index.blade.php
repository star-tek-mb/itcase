@extends('admin.layouts.app')

@section('title', 'Категории Блога')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('title', 'Категории Блога')

@section('content')
    @include('admin.components.breadcrumb', ['lastTitle' => 'Категории Блога'])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"><small>Категории</small> Блога</h3>
            <div class="block-options">
                <a href="{{ route('admin.blogcategories.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus mr-5"></i>Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                    <tr>
                        <th class="sorting_desc">Заголовок</th>
                        <th class="text-center" style="width: 15%;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="font-w600">{{ $category->getTitle() }}</td>
                        <td class="text-center d-flex align-items-center justify-content-around">
                            <a data-toggle="tooltip" title="Редактировать" href="{{ route('admin.blogcategories.edit', $category->id) }}" class="btn btn-sm btn-alt-primary"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{ route('admin.blogcategories.destroy', $category->id) }}">
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
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>


@endsection
