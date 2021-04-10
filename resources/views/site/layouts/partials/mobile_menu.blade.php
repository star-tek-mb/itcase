<!-- Mobile menu -->

<div class="menu-mobile-wrap">
    <div class="menu-mobile-content">
        <div class="menu-mobile-profile">
            <div class="line">
                <button class="button btn-menu-close" type="button"></button>
            </div>
            <ul class="user-profile">
                <li><a href="#"><i class="fas fa-plus-circle"></i> {{ __('Post a Job') }}</a></li>
                <li><a href="29_sign_in.html"><i class="fas fa-sign-out-alt"></i> {{ __('Sign In') }}</a></li>
                <li><a href="30_register.html"><i class="fas fa-registered"></i> {{ __('Register') }}</a></li>
            </ul>
        </div>
        <div class="menu-mobile">
            <ul class="main-menu-mobile">
                <li class="active"><a href="{{ route('site.catalog.index') }}">{{ __('Главная') }}</a></li>
                <li><a data-toggle="collapse" href="#sub-1" aria-expanded="false" aria-controls="sub-1">{{ __('Find
                        Jobs') }}</a>
                    <div class="collapse" id="sub-1">
                        <ul class="sub-menu-mobile">
                            <li><a href="02_browse_job_list.html">{{ __('Job list') }}</a></li>
                            <li><a href="03_browse_job_list_map.html">{{ __('Job List Map') }}</a></li>
                            <li><a href="04_job_details.html">{{ __('Job Single') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li><a data-toggle="collapse" href="#sub-2" aria-expanded="false"
                       aria-controls="sub-2">{{ __('Employers') }}</a>
                    <div class="collapse" id="sub-2">
                        <ul class="sub-menu-mobile">
                            <li><a href="05_browse_employer_list.html">{{ __('Employer List') }}</a></li>
                            <li><a href="06_employer_list.html">{{ __('Employer Grid') }}</a></li>
                            <li><a href="07_employer_details.html">{{ __('Employer Single') }}</a></li>
                            <li><a href="08_employer_dashboard.html">{{ __('Employer Dashboard') }}</a></li>
                            <li><a href="09_employer_edit_profile.html">{{ __('Employer Edit Profile') }}</a></li>
                            <li><a href="10_employer_manage_jobs.html">{{ __('Employer Manage Jobs') }}</a></li>
                            <li><a href="11_employer_manage_candidates.html">{{ __('Employer Manage Candidates') }}</a></li>
                            <li><a href="12_employer_post_a_job.html">{{ __('Employer Post A Job') }}</a></li>
                            <li><a href="13_employer_bookmarks.html">{{ __('Employer Bookmarks') }}</a></li>
                            <li><a href="14_employer_message.html">{{ __('Employer Message') }}</a></li>
                            <li><a href="15_employer_transactions.html">{{ __('Employer Transactions') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li><a data-toggle="collapse" href="#sub-3" aria-expanded="false"
                       aria-controls="sub-3">{{ __('Candidates') }}</a>
                    <div class="collapse" id="sub-3">
                        <ul class="sub-menu-mobile">
                            <li><a href="16_browse_candidate_list.html">{{ __('Candidate List') }}</a></li>
                            <li><a href="17_candidate_details.html">{{ __('Candidate Single') }}</a></li>
                            <li><a href="18_candidate_dashboard.html">{{ __('Candidate Dashboard') }}</a></li>
                            <li><a href="19_candidate_edit_profile.html">{{ __('Candidate Edit Profile') }}</a></li>
                            <li><a href="20_candidate_edit_resume.html">{{ __('Candidate Edit Resume') }}</a></li>
                            <li><a href="21_candidate_applied_jobs.html">{{ __('Candidate Applied Jobs') }}</a></li>
                            <li><a href="22_candidate_bookmarks.html">{{ __('Candidate Bookmarks') }}</a></li>
                            <li><a href="23_candidate_message.html">{{ __('Candidate Message') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li><a data-toggle="collapse" href="#sub-4" aria-expanded="false" aria-controls="sub-4">{{ __('Pages') }}</a>
                    <div class="collapse" id="sub-4">
                        <ul class="sub-menu-mobile">
                            <li><a href="24_blog_style1.html">{{ __('Blog Grid') }}</a></li>
                            <li><a href="25_blog_style2.html">{{ __('Blog Grid SideRight') }}</a></li>
                            <li><a href="26_blog_style3.html">{{ __('Blog List SideRight') }}</a></li>
                            <li><a href="27_blog_details.html">{{ __('Blog Single') }}</a></li>
                            <li><a href="28_pricing.html">{{ __('Pricing') }}</a></li>
                            <li><a href="29_sign_in.html">{{ __('Sign In') }}</a></li>
                            <li><a href="30_register.html">{{ __('Register') }}</a></li>
                            <li><a href="31_faq.html">{{ __('FAQ') }}</a></li>
                            <li><a href="32_checkout.html">{{ __('Checkout') }}</a></li>
                            <li><a href="33_error.html">{{ __('Error') }}</a></li>
                            <li><a href="34_contact.html">{{ __('Contact') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="34_contact.html">{{ __('Contact') }}</a></li>
            </ul>
        </div>
    </div>
</div>

{{--<div id="offcanvas" uk-offcanvas="flip: true; overlay: true" class="uk-offcanvas vid-offcanvas" >--}}
{{--    <div class="uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide">--}}
{{--        <div class="uk-margin-bottom content-header-item ">--}}
{{--            <a class="link-effect font-w700" href="{{ route('site.catalog.index') }}">--}}
{{--                <span class="icon">--}}
{{--                    <iconify-icon data-icon="simple-line-icons:fire"></iconify-icon>--}}
{{--                </span>--}}
{{--                <span class="font-size-xl text-dual-primary-dark">{{ __('Tez</span><span class="font-size-xl text-primary">Info</span>--}}
{{--            </a>--}}
{{--            <nav class="uk-navbar-container vid-bar" uk-navbar>--}}
{{--                <div class="uk-navbar-left">--}}

{{--<!----}}
{{--                    <ul class="uk-navbar-nav">--}}
{{--                        <li class="uk-active"><a href="#">Регистрация</a></li>--}}
{{--                        <li ><a href="">Войти</a></li>--}}
{{--                    </ul>--}}
{{---->--}}

{{--                </div>--}}
{{--            </nav>--}}

{{--        </div>--}}
{{--        <ul class="uk-margin-small-bottom uk-nav-primary uk-nav-parent-icon uk-list uk-list-divider" uk-nav="multiple: true">--}}
{{--            <!--class="uk-active"-->--}}
{{--            <li ><a href="{{ route('site.catalog.index') }}">{{ __('Главная') }}</a></li>--}}
{{--            @foreach ($needs as $need)--}}
{{--                @if (!empty($need->url))--}}
{{--                    <li><a href="{{ $need->url }}">{{ $need->ru_title }}</a></li>--}}
{{--                @else--}}
{{--                <li class="uk-parent need-item">--}}
{{--                    <a>{{ $need->ru_title }}</a>--}}
{{--                    <ul class="uk-nav-sub uk-nav-parent-icon uk-list uk-list-divider" uk-nav="multiple: true;">--}}
{{--                        @foreach ($need->menuItems as $menu)--}}
{{--                            <li class="uk-parent menu-item-li" >--}}
{{--                                <div class="uk-flex uk-flex-between">--}}
{{--                                    <a class="menu-item-link" href="{{ route('site.catalog.main', $menu->ru_slug) }}">{{ $menu->ru_title }}</a>--}}
{{--                                    <div class="menu-item-link-arrow">--}}
{{--                                        <div class="menu-item-link-arrow-image"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <ul class="uk-nav-sub uk-list">--}}
{{--                                    @foreach ($menu->categories as $category)--}}
{{--                                        <li><a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->getTitle() }}</a></li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--        <a class="uk-button uk-button-primary uk-button-large uk-margin-top" href="#">{{ __('Добавить компанию') }}</a>--}}



{{--<!----}}

{{--        <hr class="uk-margin-medium">--}}
{{--        <h3 class="uk-h4 uk-margin-remove-top uk-margin-small-bottom">Полезная информация</h3>--}}

{{--        <ul class="uk-nav uk-nav-default uk-margin-small-bottom">--}}
{{--            <li><a href="#">Помощь FAQ</a></li>--}}
{{--            <li><a href="#">О нас</a></li>--}}
{{--            <li><a href="#">Блог</a></li>--}}
{{--        </ul>--}}
{{---->--}}
{{--    </div>--}}
{{--</div>--}}


{{--<!-- Mobile menu end -->--}}
