<footer class="footer-site" id="footer">
    <div class="container">
        <div class="footer-top">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-lg-4 mb-2 mb-lg-0"><img src="/front/images/VID.png" alt="VID"></div>
                <div class="col-lg-8">
                    <ul class="nav-footer">
                        <li class="pl-4"><a href="#">{{ __('Политика конфиценциальности') }}</a></li>
                        <li><a href="{{ asset('terms_of_use.pdf') }}">{{ __('Пользовательское соглашение') }}</a></li>
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
                        <p>{{ __('Подпишись на') }} <span class="name"><span>IT</span>CASE</span> {{ __('и получай на уведомления о новостях и акциях.') }}</p>
                        <div class="form">
                            <input class="form-control" type="text" placeholder="Введите email адресс">
                            <button><i class="fa fa-envelope"></i></button>
                        </div>
                    </div>
                    <ul class="social-footer">
                        <li><a href="https://t.me/gde_podeshevle"><i class="fab fa-telegram" style="font-size:30px"></i></a></li>
                        <li><a href="https://www.instagram.com/vid.market/"><i class="fab fa-instagram" style="font-size:30px"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-md-flex text-center justify-content-between">
            <div class="copyright">© {{ now()->year }} <span class="text-green">IT</span><span class="text-white">ICASE.</span>
                {{ __('Спроектировано') }} <span class="text-white">VID STUDIO</span>. {{ __('Все права защищены.') }}
            </div>
        </div>
    </div>
</footer>
