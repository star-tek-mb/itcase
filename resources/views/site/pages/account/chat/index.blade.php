@extends('site.layouts.account')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('title', 'Чат')

@section('account.title.h1', 'Чат')



@section('account.content')
    <div class="box-admin account-chat employer-messages">
        <div class="header-box-admin d-block d-xl-flex flex-wrap">
            <div class="conversationer">
                <div class="back-view">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="user-main d-flex align-items-center">
                    <div class="avatar">
                        <img src="{{ $user->getImage() }}" alt="">
                    </div>
                    <div class="text ml-3"><h4>{{ $user->getCommonTitle() }}</h4></div>
                </div>
            </div>
            <div class="header-box-right order-md-first">
                <h3>Ваши диалоги</h3>
            </div>
        </div>
        <div class="body-box-admin p-0">
            <div class="chat" @if ($user->chats()->count() == 0)style="height: 500px"@endif>
                <div class="contact-chat">
                    @if ($user->chats()->count() > 0)
                        <ul class="msg-contacts">
                            @foreach($user->chats as $chat)
                                @php
                                  $anotherUser = $chat->getAnotherUser()
                                @endphp
                                <li><a href="{{ route('site.account.chats') }}?chat_id={{ $chat->id }}" class="msg-contact-item">
                                        <div class="avatar-user">
                                            <img src="@if ($user->hasRole('contractor') && $anotherUser->hasRole('customer')) /assets/img/avatars/avatar15.jpg @else {{ $anotherUser->getImage() }} @endif"
                                                 alt="@if ($user->hasRole('contractor') && $anotherUser->hasRole('customer')) Заказчик @else {{ $anotherUser->getCommonTitle() }} @endif">
                                        </div>
                                        <div class="text">
                                            <div class="msg-contact-name">@if ($user->hasRole('contractor') && $anotherUser->hasRole('customer')) Заказчик @else {{ $anotherUser->getCommonTitle() }} @endif</div>
                                            <div class="desc-short">{{ $chat->getLastMessageText() }}</div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <p>У вас нет открытых диалогов</p>
                        </div>
                    @endif
                </div>
                <div class="content-chat">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <p>Выберите чат</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.msg-contacts li a').on('click', function () {
            window.location = $(this).attr('href');
        })
    </script>
@endsection
