<footer class="footer-site" id="footer">
    <div class="container">
        <div class="footer-top">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-lg-4 mb-2 mb-lg-0"><img src="/front/images/VID.png" alt="VID"></div>
                <div class="col-lg-8">
                    <ul class="nav-footer">
                        <li><a href="{{ route('site.page', 'terms-of-service') }}">Правила сервиса</a></li>
                        <li><a href="{{ route('site.page', 'offerta') }}"> Оферта</a></li>
                        <li><a href="{{ route('site.page', 'privacy-policy') }}">Политика конфиденциальности</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-middle">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <span class="title-footer">{{ __('Аккаунт') }}</span>
                            <ul class="links-footer">
                                @auth
                                    <li><a href="{{ route('site.account.index') }}">{{ __('Мой кабинет') }}</a></li>
                                @endauth
                                @guest
                                    <li><a href="{{ route('login') }}">{{ __('Войти') }}</a></li>
                                    <li><a href="{{ route('register') }}">{{ __('Создать аккаунт') }}</a></li>
                                @endguest
                            </ul>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="title-footer">{{ __('Конкурсы') }}</span>
                            <ul class="links-footer">
                                <li><a href="{{ route('site.tenders.common.create') }}">{{ __('Создание конкурсов') }}</a></li>
                                <li><a href="{{ route('site.tenders.index') }}">{{ __('Каталог заданий') }}</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-4">
                            <h3 class="title-footer">{{ __('Компания') }}</h3>
                            <ul class="links-footer">
                                <li><a href="{{ route('site.blog.index') }}">{{ __('Блог') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newsletter">
                        <span class="title-footer">{{ __('Рассылка') }}</span>
                        <p>{{ __('Подпишись на') }} itcase.com {{ __('и получай на уведомления о новостях и акциях.') }}</p>
                        <div class="form">
                            <input class="form-control" type="text" placeholder="Введите email адресс">
                            <button><i class="fa fa-envelope"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-md-flex text-center justify-content-between">
            <div class="copyright">© {{ now()->year }} itcase.com
                {{ __('Все права защищены.') }}
            </div>
        </div>
    </div>
</footer>
