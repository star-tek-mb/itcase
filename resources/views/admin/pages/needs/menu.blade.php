@extends('admin.layouts.app')

@section('title', "Меню $need->ru_title")

@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.needs.index'),
                'title' => 'Потребности'
            ]
        ],
        'lastTitle' => "Меню $need->ru_title"
    ])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Меню {{ $need->ru_title }}</h3>
            <div class="block-options">
                <a href="{{ route('admin.menu.create', ['needId' => $need->id]) }}" class="btn btn-alt-success"><i class="fa fa-plus mr-5"></i> Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <ul class="list-group list-group-flush mb-20">
                @foreach($need->menuItems as $menuItem)
                    <li class="list-group-item d-flex justify-content-between align-items-center">{{ $menuItem->ru_title }}
                        <span class="d-flex">
                            <a href="{{ route('admin.menu.edit', $menuItem->id) }}" data-toggle="tooltip" title="Редактировать"
                               class="btn btn-sm btn-alt-info mr-10"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.menu.destroy', $menuItem->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button data-toggle="tooltip" onclick="return confirm('Вы уверены?')" title="Удалить" class="btn btn-sm btn-alt-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
