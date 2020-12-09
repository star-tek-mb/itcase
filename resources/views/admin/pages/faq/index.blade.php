@extends('admin.layouts.app')

@section('title', 'FAQ')

@section('content')
    @include('admin.components.breadcrumb', [
        'lastTitle' => 'FAQ'
    ])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">FAQ</h3>
            <div class="block-options">
                <a href="{{ route('admin.faq.create') }}" class="btn btn-alt-primary"><i class="fa fa-plus"></i> Добавить</a>
            </div>
        </div>
        <div class="block-content">
            <ul class="list-group list-group-flush mb-20">
                @foreach($faqs as $faq)
                    <li class="list-group-item d-flex justify-content-between align-items-center">{{ $faq->getTitle() }}
                        <span class="d-flex">
                            <a href="{{ route('admin.faq.edit', $faq->id) }}" data-toggle="tooltip" title="Редактировать"
                               class="btn btn-sm btn-alt-info mr-10"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="post">
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
