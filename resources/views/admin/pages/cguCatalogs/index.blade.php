@extends('admin.layouts.app')

@section('title', 'Файлы ЦГУ')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    @include('admin.components.breadcrumb', ['lastTitle' => 'Файлы ЦГУ'])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">ЦГУ <small>Файлы</small></h3>
            <div class="block-options">
                <a href="{{ route('admin.cgucatalogs.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus mr-5"></i>Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-responsive table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="sorting_desc">Заголовок</th>
                    <th>Категория</th>
                    <th>Активность</th>
                    <th class="text-center" style="width: 15%;">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($catalogs as $catalog)
                    <tr>
                        <td class="text-center">{{ $catalog->id }}</td>
                        <td class="font-w600">{{ $catalog->getTitle() }}</td>
                        <td>
                            {{ $catalog->getParentCategoryTitle() }}
                        </td>
                        <td>{!! $catalog->getActiveRender() !!}</td>
                        <td class="text-center d-flex align-items-center justify-content-around">
                            <a data-toggle="tooltip" title="Редактировать" href="{{ route('admin.cgucatalogs.edit', $catalog->id) }}" class="btn btn-sm btn-alt-info"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{ route('admin.cgucatalogs.destroy', $catalog->id) }}">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-alt-danger" data-toggle="tooltip" title="Удалить">
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

    <script>
        jQuery('.js-dataTable-full').dataTable({
            "order": [],
            pageLength: 10,
            lengthMenu: [[10, 20, 30, 50], [10, 20, 30, 50]],
            autoWidth: true,
            language: ru_datatable
        });
    </script>
@endsection
