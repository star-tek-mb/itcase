<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout"
                    data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->
        </div>
        <!-- Right Section -->
        <div class="content-header-section">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="si si-bell"></i>@if (auth()->user()->unreadNotifications->count() > 0) <span
                        class="badge badge-primary badge-pill"
                        id="notifications-count">{{ auth()->user()->unreadNotifications->count() }}</span>@endif
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-heder-notifications">
                    <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Оповещения</h5>
                    <ul class="list-unstyled my-20">
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <li>
                                @if ($notification->type == 'App\Notifications\RequestAction' && isset($notification->data['customerId']))
                                    <div class="text-body-color-dark media mb-15" data-notification-id="{{ $notification->id }}">
                                        <div class="ml-5 mr-15">
                                            <i class="fa fa-fw fa-info text-info"></i>
                                        </div>
                                        <div class="media-body pr-10">
                                            <p class="mb-0">
                                                Заказчик <a
                                                    href="{{ route('admin.users.edit', $notification->data['customerId']) }}"
                                                    class="font-weight-bold link-effect">{{ $notification['customerName'] }}</a>
                                                выбрал исполнителя
                                                <a href="{{ route('admin.users.edit', $notification->data['contractorId']) }}"
                                                   class="font-weight-bold link-effect">{{ $notification->data['contractorName'] }}</a> в
                                                качестве победителя в конкурсе <a
                                                    href="{{ route('admin.tenders.show', $notification->data['tenderId']) }}"
                                                    class="font-weight-bold link-effect">{{ $notification->data['tenderName'] }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if ($notification->type == 'App\Notifications\TenderCreated')
                                    <div class="text-body-color-dark media mb-15" data-notification-id="{{ $notification->id }}">
                                        <div class="ml-5 mr-15">
                                            <i class="fa fa-fw fa-info text-info"></i>
                                        </div>
                                        <div class="media-body pr-10">
                                            <p class="mb-0">
                                                Заказчик <a
                                                    href="{{ route('admin.users.edit', $notification->data['tender']['owner_id']) }}"
                                                    class="font-weight-bold link-effect">{{ $notification->data['customerName'] }}</a>
                                                создал новый конкурс <a
                                                    href="{{ route('admin.tenders.show', $notification->data['tender']['id']) }}"
                                                    class="font-weight-bold link-effect">{{ $notification->data['tender']['title'] }}</a>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- User Dropdown -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}<i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-150"
                     aria-labelledby="page-header-user-dropdown">
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button class="dropdown-item">
                            <i class="si si-logout mr-5"></i> Выйти
                        </button>
                    </form>
                </div>
            </div>
            <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header">
        <div class="content-header content-header-fullrow">
            <form action="#" method="post">
                <div class="input-group">
                        <span class="input-group-btn">
                            <!-- Close Search Section -->
                            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                            <button type="button" class="btn btn-secondary px-15" data-toggle="layout"
                                    data-action="header_search_off">
                                <i class="fa fa-times"></i>
                            </button>
                            <!-- END Close Search Section -->
                        </span>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.."
                           id="page-header-search-input" name="page-header-search-input">
                    <span class="input-group-btn">
                            <button type="submit" class="btn btn-secondary px-15">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                </div>
            </form>
        </div>
    </div>
    <!-- END Header Search -->

    <!-- Header Loader -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
<!-- END Header -->
