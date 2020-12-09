@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.css') }}">

    <style>
        .js-dataTable-full .btn {
            height: 100%;
        }
    </style>
@endsection

@section('title', 'Услуги')

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Список доступных услуг</h3>
            <div class="block-options"><a href="{{ route('admin.services.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus"></i> Добавить</a></div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-stripped table-bordered table-vcenter js-dataTable-full">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Название</th>
                        <th class="text-center">Категория</th>
                        <th class="text-center" style="width: 15%">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td class="text-center">{{ $service->id }}</td>
                            <td class="font-w600 text-center">{{ $service->ru_title }}</td>
                            <td class="text-center">@if($service->category) {{ $service->category->ru_title }} @else - @endif</td>
                            <td class="text-center font-w600 d-flex align-items-center justify-content-around">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-alt-info"
                                   data-toggle="tooltip"
                                   title="Редактировать"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="post" data-toggle="tooltip" title="Удалить">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-alt-delete" onclick="return confirm('Вы уверены?')"><i class="fa fa-trash"></i></button>
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
