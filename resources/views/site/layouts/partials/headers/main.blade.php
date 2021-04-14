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
                    <ul class="ml-4 main-menu">
                        <li class="header-menu-item"><a href="{{ route('site.tenders.index') }}">{{ __('Конкурсы') }} <i
                                    class="fas fa-caret-down"></i></a>
                            <ul class="sub-menu">
                                @foreach($parentCategories as $parent)
                                    <li class="menu-item dropdown-submenu">
                                        <a href="{{ route('site.tenders.category', $parent->ru_slug) }}"
                                            class="d-flex justify-content-between align-items-center">{{ $parent->title }}
                                            <i class="fas fa-caret-right ml-2 mr-3"></i></a>
                                        <ul class="sub-menu">
                                            @foreach($parent->categories as $category)
                                                <li>
                                                    <a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header-right">
                <ul>
                    <li><a href="#"><i class="fas fa-plus-circle"></i> {{ __('Добавить заказ') }}</a></li>
                    <li><a href="29_sign_in.html"><i class="fas fa-sign-out-alt"></i> {{ __('Вход')) }}</a><span> / </span><a
                            href="30_register.html">{{ __('Регистрация') }}</a></li>
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
	            <div><a rel="nofollow" class="uk-button uk-button-success-outline" href="#">{{ __('Добавить компанию')) }}</a></div>
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
					<a class="hvr-back" href="#about" uk-scroll="offset: 80"><span class="uk-margin-small-right" uk-icon="icon: arrow-left" ></span>{{ __(('Прокрутить вниз') }}</a>
				</div>
			</div>
			<div class="uk-width-expand@m uk-section uk-flex uk-flex-column">
				<div class="uk-margin-auto-top uk-margin-auto-bottom">
					<h1 class="uk-heading-easy uk-margin-remove-top uk-letter-spacing-xl" uk-scrollspy="cls: uk-animation-slide-bottom-medium; repeat: true">{{ __('Фриланс площадка в Узбекистане') }}</h1>
                        <span class="uk-heading-easy uk-margin-remove-top uk-letter-spacing-xl" uk-scrollspy="cls: uk-animation-slide-bottom-medium; repeat: true">{{ __('Найдите') }}<mark> {{ __('компанию или фрилансера,') }}</mark> {{ __('готовых увеличить прибыль') }} <mark>{{ __('вашего бизнеса.') }}</mark></span>
                    @include('site.components.search')
				</div>
				<div class="uk-margin-auto-top"
					uk-scrollspy="cls: uk-animation-slide-bottom-medium; delay: 400; repeat: true">
					<div class="uk-child-width-1-2@s uk-grid-large uk-margin-medium-top" uk-grid>

						<div>
							<span class="uk-margin-remove uk-text-bold uk-text-large">{{ __('Все в одном сайте') }}</span>
							<p class="uk-margin-xsmall-top uk-text-small uk-text-muted uk-text-bold">{{ __('Компании и фрилансеры в сфере интернет и наружной рекламы, разработки сайтов и мобильных приложений, юридической помощи и бухгалтерии и многом другом') }}</p>
						</div>
						<div>
							<span class="uk-margin-remove uk-text-bold uk-text-large">
                                {{ __('Большой выбор') }}</h4>
							<p class="uk-margin-xsmall-top uk-text-small uk-text-muted uk-text-bold">{{ __(Выберите более чем из 500 компаний и фрилансеров. Отфильтруй по цене и найди самое выгодное предложение') }}</p>
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
