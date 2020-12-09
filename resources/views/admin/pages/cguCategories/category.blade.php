@extends('admin.layouts.app')

@section('title', 'Дочерние категории ЦГУ Категории')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('title')ЦГУ {{ $category->ru_title }} @endsection
@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.cgucategories.index'),
                'title' => 'Цгу Категории'
            ],
            [
                'url' => ($category->hasParentCategory()) ? ($category->parentCategory->hasParentCategory()) ? route('admin.cgucategories.show', $category->parentCategory->id) : route('admin.cgucategories.index') : '',
                'title' => ($category->hasParentCategory()) ? $category->parentCategory->ru_title : ''
            ],
            [
                'url' => ($category->hasParentCategory()) ? route('admin.cgucategories.show', $category->id) : route('admin.cgucategories.index'),
                'title' => $category->ru_title
            ],
        ],
        'lastTitle' => 'Дочерние категории'
    ])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{ $category->getTitle() }} <small>Вложенные</small></h3>
            <div class="block-options">
                <a href="{{ route('admin.cgucategories.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus mr-5"></i>Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-responsive table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="sorting_desc">Заголовок</th>
                    <th>Категории</th>
                    <th>Сайты</th>
                    <th>Файлы</th>
                    <th class="text-center" style="width: 15%;">Действия</th>
                </tr>
                </thead>
                <tbody>
                @if($category->categories != null)
                    @foreach($category->categories as $category_list)
                        <tr>
                            <td class="text-center">{{ $category_list->id }}</td>
                            <td class="font-w600">{{ $category_list->getTitle() }}</td>
                            <td>
                                @if($category_list->hasCategories())
                                    <a href="{{ route('admin.cgucategories.show', $category_list->id) }}" class="btn btn-sm btn-alt-primary">Посмотреть</a>
                                @else
                                    Нет
                                @endif
                            </td>
                            <td>
                                @if($category_list->hasSites())
                                    <a href="{{ route('admin.cgucategories.sites', $category_list->id) }}" class="btn btn-sm btn-alt-primary">Посмотреть</a>
                                @else
                                    Нет
                                @endif
                            </td>
                            <td>
                                @if($category_list->hasFiles())
                                    <a href="{{ route('admin.cgucategories.files', $category_list->id) }}" class="btn btn-sm btn-alt-primary">Посмотреть</a>
                                @else
                                    Нет
                                @endif
                            </td>
                            <td class="text-center d-flex align-items-center justify-content-around">
                                <a data-toggle="tooltip" title="Редактировать" class="btn btn-sm btn-alt-info" href="{{ route('admin.cgucategories.edit', $category_list->id) }}"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('admin.cgucategories.destroy', $category_list->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-alt-danger" onclick="return confirm('Вы уверены?')" data-toggle="tooltip" title="Удалить">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <select name="position" class="position" data-id="{{ $category_list->id }}">
                                    @for($i = 0; $i <= count($category->categories); $i++)
                                        <option value="{{ $i }}" @if($category_list->position == $i) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $('.js-dataTable-full').dataTable({
            "order": [],
            pageLength: 10,
            lengthMenu: [[10, 20, 30, 50], [10, 20, 30, 50]],
            autoWidth: true,
            language: ru_datatable
        });
        $('.position').change(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData;
            formData.append('id', $(this).data('id'));
            formData.append('position', $(this).val());
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.cgucategories.change.position') }}',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.position').attr('disabled', '');
                },
                success: function(data){
                    console.log(data);
                    $('.position').removeAttr('disabled', '');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        })
    </script>
@endsection
