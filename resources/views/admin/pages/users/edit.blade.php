@extends('admin.layouts.app')

@section('title', 'Пользователь - '.$user->name)

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.users.index'),
                'title' => 'Пользователи'
            ]
        ],
        'lastTitle' => $user->name
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"><i class="fa fa-user-circle mr-5 text-muted"></i> {{ $user->getCommonTitle() }}</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group @error('name') is-invalid @enderror">
                            <div class="form-material floating">
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
                                <label for="name">Имя пользователя</label>
                            </div>
                            @error('name') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group @error('email') is-invalid @enderror">
                            <div class="form-material floating">
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                                <label for="email">Email</label>
                            </div>
                            @error('email') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="form-material floating">
                                <select name="roleId" id="roleId" class="form-control">
                                    <option value="0">Нет</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if($user->hasOneRole()) @if($user->getRole()->id == $role->id) selected @endif @endif>{{ $role->description }}</option>
                                    @endforeach
                                </select>
                                <label for="roleId">Роль</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 ">
                        <div class="form-group @error('phone_number') is-invalid @enderror">
                            <div class="form-material floating">
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number }}">
                                <label for="phone_number">Номер телефона</label>
                            </div>
                            @error('phone_number') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-material floating">
                                <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $user->company_name }}">
                                <label for="company_name">Название компании</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-material floating">
                                <textarea name="about_myself" id="about_myself" class="form-control">{!! $user->about_myself !!}</textarea>
                                <label for="about_myself">О себе</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="d-flex align-items-center flex-column">
                            <label for="image" class="d-block">Аватар</label>
                            @if ($user->image)
                                <div class="user-image">
                                    <img src="{{ $user->getImage() }}" alt="{{ $user->name }}" class="img-avatar img-avatar48">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" class="d-block">
                        </div>
                    </div>
                </div>
                <div class="block-content mb-10">
                    <div class="block-content text-right pb-10">
                        <button class="btn btn-alt-success" type="submit">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"><i class="fa fa-asterisk mr-5 text-muted"></i> Изменить пароль</h3>
        </div>
        <div class="block-content">
            @if(session('change_password_success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3 class="alert-heading font-size-h4 font-w400">Успешно!</h3>
                    <p class="mb-0">{{ session('change_password_success') }}</p>
                </div>
            @endif
            <form action="{{ route('admin.users.change.password', $user->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group @error('newPassword') is-invalid @enderror">
                            <div class="form-material floating">
                                <label for="newPassword">Новый пароль</label>
                                <input type="password" name="newPassword" id="newPassword" class="form-control">
                            </div>
                            @error('newPassword') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-material floating @error('confirmPassword') is-invalid @enderror">
                                <label for="confirmPassword">Подтвердите пароль</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                            </div>
                            @error('confirmPassword') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="block-content mb-10">
                    <div class="block-content text-right pb-10">
                        <button class="btn btn-alt-success" type="submit">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if ($user->hasRole('contractor'))
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="si si-briefcase mr-5 text-muted"></i> Профессиональные данные</h3>
            </div>
            <div class="block-content">
                <ul class="list-group list-group-flush mb-20">
                    @foreach($user->categories as $category)
                        <li class="list-group-item">{{ $category->getTitle() }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if ($user->hasRole('contractor'))
        <h2 class="content-heading"><i class="si si-picture text-muted mr-5"></i> Портфолио</h2>
        <div class="row item-push img-fluid-100 mb-20">
            @foreach($user->portfolio as $item)
                <div class="col-sm-6 col-md-4">
                    <div class="options-container">
                        <img src="{{ asset('images/portfolio/portfolio_contractor/'.$item->filename) }}" alt="" class="img-fluid options-item">
                        <div class="options-overlay bg-black-op-75">
                            <div class="options-overlay-content">
                                <h3 class="h4 text-white mb-15">{{ $item->project_name }}</h3>
                                @if ($item->link)
                                    <a href="{{ $item->link }}"
                                       class="btn btn-sm btn-rounded btn-alt-primary min-width-75">Перейти к проекту</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"><i class="si si-docs mr-5 text-muted"></i> Конкурсы @if ($user->hasRole('contractor')), в которых исполнитель принимает участие @endif</h3>
        </div>
        <div class="block-content">
            <ul class="list-group list-group-flush mb-20">
                @if ($user->hasRole('contractor'))
                    @foreach($user->requests as $request)
                        <a class="list-group-item list-group-item-action" href="{{ route('admin.tenders.show', $request->tender_id) }}">
                            <p class="font-weight-bold font-size-lg">{{ $request->tender->title }}</p>
                            <p class="text-muted m-0"><i class="si si-calendar mr-5"></i>Опубликован: {{ \Carbon\Carbon::create($request->tender->published_at)->format('d.m.Y') }}  <i class="si si-calendar ml-10 mr-5"></i>Истекает {{ \Carbon\Carbon::create($request->tender->deadline)->format('d.m.Y') }}</p>
                            <p class="text-muted m-0"><i class="fa fa-money mr-5"></i> Бюджет: {{ $request->tender->budget }} сум</p>
                        </a>
                    @endforeach
                @elseif($user->hasRole('customer'))
                    @foreach($user->ownedTenders as $tender)
                        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('admin.tenders.show', $tender->id) }}">
                            <div>
                                <p class="font-weight-bold font-size-lg">{{ $tender->title }}</p>
                                <p class="text-muted m-0"><i class="si si-calendar mr-5"></i>Опубликован: {{ \Carbon\Carbon::create($tender->published_at)->format('d.m.Y') }}  <i class="si si-calendar ml-10 mr-5"></i>Истекает {{ \Carbon\Carbon::create($tender->deadline)->format('d.m.Y') }}</p>
                                <p class="text-muted m-0"><i class="fa fa-money mr-5"></i> Бюджет: {{ $tender->budget }} сум</p>
                                @if ($tender->contractor)   <p class="text-muted m-0">Исполнитель: {{ $user->getCommonTitle() }}</p>    @endif
                            </div>
                            <span class="badge badge-primary badge-pill">{{ $tender->requests()->count() }} заявок</span>
                        </a>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    @if ($user->hasRole('contractor'))
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="si si-docs text-muted mr-5"></i>Выигранные конкурсы, {{ $user->contractedTenders()->count() }}</h3>
            </div>
            <div class="block-content">
                @foreach($user->contractedTenders as $tender)
                    <a class="list-group-item list-group-item-action" href="{{ route('admin.tenders.show', $tender->id) }}">
                        <p class="font-weight-bold font-size-lg">{{ $tender->title }}</p>
                        <p class="text-muted m-0"><i class="si si-calendar mr-5"></i>Опубликован: {{ \Carbon\Carbon::create($tender->published_at)->format('d.m.Y') }}  <i class="si si-calendar ml-10 mr-5"></i>Истекает {{ \Carbon\Carbon::create($tender->deadline)->format('d.m.Y') }}</p>
                        <p class="text-muted m-0"><i class="fa fa-money mr-5"></i> Бюджет: {{ $tender->budget }} сум</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    <h2 class="content-heading"><i class="si si-bubbles text-muted mr-5"></i> Чаты</h2>
    <div class="js-chat-container" data-chat-height="auto">
        <div class="block mb-0">
            <ul class="js-chat-head nav nav-tabs nav-tabs-alt bg-body-light js-tabs-enabled" data-toggle="tabs" role="tablist">
                @foreach($user->chats as $chat)
                    @php
                    $anotherUser = $chat->getAnotherUser($user);
                    @endphp
                    <li class="nav-item">
                        <a href="#chat-window{{ $chat->id }}" class="nav-link"><img
                                src="{{ $anotherUser->getImage() }}" alt=""
                                class="img-avatar img-avatar16"><span class="ml-5">{{ $anotherUser->getCommonTitle() }}</span></a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content overflow-hidden">
                @foreach($user->chats as $chat)
                    @php
                        $anotherUser = $chat->getAnotherUser($user);
                    @endphp
                    <div class="tab-pane" id="chat-window{{ $chat->id }}" role="tabpanel">
                        <div class="js-chat-talk block-content block-content-full text-wrap-break-word overflow-y-auto" data-chat-id="{{ $chat->id }}" style="height: 442.012px;">
                            @foreach($chat->messages as $message)
                                @if ($message->user_id == $user->id)
                                    <div class="d-flex flex-row-reverse mb-20">
                                        <div>
                                            <img src="{{ $user->getImage() }}" alt="" class="img-avatar img-avatar32">
                                        </div>
                                        <div class="mx-10 text-right">
                                            <div>
                                                <p class="bg-primary-lighter text-primary-darker rounded px-15 py-10 mb-5 d-inline-block">{{ $message->text }}</p>
                                            </div>
                                            <div class="text-right text-muted font-size-xs font-italic">{{ $message->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex mb-20">
                                        <div>
                                            <img src="{{ $anotherUser->getImage() }}" alt="" class="img-avatar img-avatar32">
                                        </div>
                                        <div class="mx-10">
                                            <div>
                                                <p class="bg-body-dark text-dark rounded px-15 py-10 mb-5">
                                                    {{ $message->text }}
                                                </p>
                                            </div>
                                            <div class="text-muted font-size-xs font-italic">
                                                {{ $message->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


{{--    <a href="{{ route('admin.users.statistics', $user->id) }}" class="block block-link-shadow">--}}
{{--        <div class="block-content block-content-full my-50">--}}
{{--            <div class="font-size-h3 font-w600 text-center">Посмотреть статистику действий</div>--}}
{{--        </div>--}}
{{--    </a>--}}
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        jQuery(function() {
            Codebase.helper('select2');
            $('.js-chat-container li.nav-item a.nav-link').on('click', function() {
                $('.js-chat-container li.nav-item').removeClass('active');
                $(this).addClass('active');
                $('.tab-content .tab-pane.show.active').removeClass('show').removeClass('active');
                let tabPane = $($(this).attr('href'));
                tabPane.addClass('show active');
                let chatTalk = tabPane.find('.js-chat-talk');
                chatTalk.scrollTop(chatTalk.prop('scrollHeight'));
            })
        });
    </script>
@endsection
