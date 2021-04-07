<header class="header-site" id="header">
    <div class="container-fluid">
        <div class="header-wrap">
            <div class="header-left">
                <div class="header-main-toggle">
                    <button class="btn-toggle" type="button" data-toggle="offcanvas"><i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="header-logo"><a class="qdesk-logo" href="#" title="QDesk"><img class="qdesk-logo-white"
                                                                                           src="{{ asset('front/images/VID.png') }}"
                                                                                           alt="VID"><img
                            class="qdesk-logo-black" src="{{ asset('front/images/logo-black.png') }}" alt="VID"></a></div>
                <div class="navigation" id="navigation">
                    <ul class="main-menu">
                        <li class="active"><a href="/">Главная</a></li>
                        @foreach($needs as $need)
                            <li><a href="#">{{ $need->ru_title }} <i class="fas fa-caret-down"></i></a>
                                <ul class="sub-menu">
                                    @foreach($need->menuItems as $item)
                                        <li><a href="{{ route('site.catalog.main', $item->ru_slug) }}">{{ $item->ru_title }} <i class="fas fa-caret-right"></i></a>
                                            <ul class="sub-menu">
                                                @foreach($item->categories as $category)
                                                    <li>
                                                        <a href="{{ route('site.catalog.main', $category->ru_slug) }}">{{ $category->getTitle() }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="header-right">
                <ul>
                    <li><a href="#"><i class="fas fa-plus-circle"></i> Добавить заказ</a></li>
                    <li><a href="29_sign_in.html"><i class="fas fa-sign-out-alt"></i> Вход</a><span> / </span><a
                            href="30_register.html">Регистрация</a></li>
                </ul>
	        </div>
	        <div class="uk-navbar-right">
	          <div>
	            <a class="uk-navbar-toggle" uk-icon="icon: search" href="#"></a>
	            <div class="code-drop uk-drop" uk-drop="mode: click; pos:bottom-left; offset: 0">
                    @include('site.layouts.partials.mobile_search')
	            </div>
	          </div>
	          <div style="    visibility: hidden;"class="uk-navbar-item uk-visible@m">
	            <div><a rel="nofollow" class="uk-button uk-button-success-outline" href="#">Добавить компанию</a></div>
	          </div>
	          <a class="uk-navbar-toggle uk-hidden@m" href="#offcanvas" uk-toggle><span uk-icon="icon: menu" ></span></a>
	        </div>
	      </div>
	    </div>
	  </nav>
	</div>
	<div class="uk-container uk-container-large uk-light" uk-height-viewport="offset-top: true">
		<div uk-grid uk-height-viewport="offset-top: true">
			<div class="uk-header-left uk-section uk-visible@m uk-flex uk-flex-bottom">
				<div class="uk-text-xsmall uk-text-bold">
					<a class="hvr-back" href="#about" uk-scroll="offset: 80"><span class="uk-margin-small-right" uk-icon="icon: arrow-left" ></span>Прокрутить вниз</a>
				</div>
			</div>
			<div class="uk-width-expand@m uk-section uk-flex uk-flex-column">
				<div class="uk-margin-auto-top uk-margin-auto-bottom">
					<h1 class="uk-heading-easy uk-margin-remove-top uk-letter-spacing-xl" uk-scrollspy="cls: uk-animation-slide-bottom-medium; repeat: true">Фриланс площадка в Узбекистане</h1>
                        <span class="uk-heading-easy uk-margin-remove-top uk-letter-spacing-xl" uk-scrollspy="cls: uk-animation-slide-bottom-medium; repeat: true">Найдите<mark> компанию или фрилансера,</mark> готовых увеличить прибыль <mark>вашего бизнеса.</mark></span>
                    @include('site.components.search')
				</div>
				<div class="uk-margin-auto-top"
					uk-scrollspy="cls: uk-animation-slide-bottom-medium; delay: 400; repeat: true">
					<div class="uk-child-width-1-2@s uk-grid-large uk-margin-medium-top" uk-grid>

						<div>
							<span class="uk-margin-remove uk-text-bold uk-text-large">Все в одном сайте</span>
							<p class="uk-margin-xsmall-top uk-text-small uk-text-muted uk-text-bold">Компании и фрилансеры в сфере интернет и наружной рекламы, разработки сайтов и мобильных приложений, юридической помощи и бухгалтерии и многом другом</p>
						</div>
						<div>
							<span class="uk-margin-remove uk-text-bold uk-text-large">
                                Большой выбор</h4>
							<p class="uk-margin-xsmall-top uk-text-small uk-text-muted uk-text-bold">Выберите более чем из 500 компаний и фрилансеров. Отфильтруй по цене и найди самое выгодное предложение</p>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-header-right uk-section uk-visible@m uk-flex uk-flex-right uk-flex-bottom">
				<div>
					<ul class="uk-subnav uk-text-xsmall uk-text-bold">
						<li visibility: hidden><a rel="nofollow" class="uk-link-border" href="#" target="_blank">facebook</a></li>
						<li><a rel="nofollow" class="uk-link-border" href="https://t.me/gde_podeshevle" target="_blank">telegram</a></li>
						<li ><a rel="nofollow" class="uk-link-border" href="https://www.instagram.com/vid.market?r=nametag" target="_blank">instagram</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>
