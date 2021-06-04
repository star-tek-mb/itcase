@extends('admin.layouts.app')

@section('title', 'Слайдер')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    @include('admin.components.breadcrumb', ['lastTitle' => 'Слайдер'])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Слайдер <small>как решать задачи на itcase.com</small></h3>
            <div class="block-options">
                <a href="{{ route('admin.howtos.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus mr-5"></i>Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-responsive table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                <tr>
                    <th></th>
                    <th class="sorting_desc">Заголовок</th>
                    <th class="sorting_desc">Ссылка</th>
                    <th class="text-center" style="width: 15%;">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($howtos as $howto)
                    <tr>
                        <td class="text-center"><img src="{{ $howto->getImage() }}" alt="" class="img-avatar"></td>
                        <td class="font-w600">{{ $howto->title }}</td>
                        <td class="font-w600">{{ $howto->url }}</td>
                        <td class="text-center">
                            <div class="d-flex align-items-center h-100">
                                <a data-toggle="tooltip" title="Редактировать" class="btn btn-sm btn-alt-info" href="{{ route('admin.howtos.edit', $howto->id) }}"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('admin.howtos.destroy', $howto->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-alt-danger" onclick="return confirm('Вы уверены?')" data-toggle="tooltip" title="Удалить">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
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
