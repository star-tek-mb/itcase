@extends('admin.layouts.app')

@section('title', 'Потребности')

@section('content')
    @include('admin.components.breadcrumb', [
        'lastTitle' => 'Потребности'
    ])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Типы потребностей</h3>
            <div class="block-options">
                <a href="{{ route('admin.needs.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus"></i> Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <ul class="list-group list-group-flush mb-20">
                @foreach($needs as $need)
                    <li class="list-group-item d-flex justify-content-between align-items-center">{{ $need->ru_title }}
                        <span class="d-flex">
                            <a href="{{ route('admin.needs.menu', $need->id) }}" class="btn btn-sm btn-alt-info mr-10" data-toggle="tooltip" title="Элементы меню"><i class="fa fa-list"></i></a>
                            <a href="{{ route('admin.needs.edit', $need->id) }}" data-toggle="tooltip" title="Редактировать"
                               class="btn btn-sm btn-alt-info mr-10"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.needs.destroy', $need->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button data-toggle="tooltip" onclick="return confirm('Вы уверены?')" title="Удалить" class="btn btn-sm btn-alt-danger"><i class="fa fa-trash"></i></button>
                            </form>
                            <select name="position" id="position" class="position" data-id="{{ $need->id }}">
                                @for($i = 0; $i <= count($needs); $i++)
                                    <option value="{{ $i }}" @if($need->position == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.position').change(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData;
            formData.append('id', $(this).data('id'));
            formData.append('position', $(this).val());
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.needs.change.position') }}',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.position').attr('disabled', 'disabled');
                },
                success: function() {
                    $('.position').removeAttr('disabled', '');
                },
                error: function(data) {
                    console.log(data);
                    $('.position').removeAttr('disabled', '');
                }
            })
        });
    </script>
@endsection
