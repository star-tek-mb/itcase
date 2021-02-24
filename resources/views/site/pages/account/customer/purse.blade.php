@extends('site.layouts.account')

@section('title', 'Мои конкурсы')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('account.title.h1', 'Мои конкурсы')

@section('account.content')
    <form action="" method="post" enctype="multipart/form-data">

        <label class="mt-3">Выберите платежную систему: </label>
        <ul class="nav nav-tabs mt-3" id="needsTabs" role="tablist">
            <li class="nav-item">
                <a href="#tab-content-1" class="nav-link active" aria-selected="true" data-toggle="tab" role="tab"
                   aria-controls="tab-content-1" id="tab-1">
                    <img src="/front/images/click.png" alt="">
                </a>
            </li>
            <li class="nav-item">
                <a href="#tab-content-4" class="nav-link" aria-selected="false" data-toggle="tab" role="tab"
                   aria-controls="tab-content-4" id="tab-4">
                    <img src="/front/images/payme.png" alt="">
                </a>
            </li>
            <li class="nav-item">
                <a href="#tab-content-6" class="nav-link " aria-selected="false" data-toggle="tab" role="tab"
                   aria-controls="tab-content-6" id="tab-6">
                    <img src="/front/images/visa.png" alt="">
                </a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="needsTabsContent">
            <div class="tab-pane fade active show" id="tab-content-1" role="tabpanel" aria-labelledby="tab-1">
                <div class="row">
                    <div class="col-sm-12 pt-4">
                        <h5>Пополнение счета с помощью платежной системы "Click"</h5>

                        <section class="box-admin edit-profile mt-5">
                            <div class="header-box-admin">
                                <h3>Пополнить кошелек</h3>
                            </div>
                            <div class="body-box-admin">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Номер карты</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phoneNumber">Фамилия</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Код подтверждения</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-light-green">
                                    <i class="fas fa-share"></i>
                                    Пополнить счет
                                </button>

                            </div>
                        </section>
                    </div>


                </div>
            </div>
            <div class="tab-pane fade" id="tab-content-4" role="tabpanel" aria-labelledby="tab-4">
                <div class="row">
                    <div class="col-sm-12 pt-4">
                        <h5>Пополнение счета с помощью платежной системы "PayMe"</h5>

                        <section class="box-admin edit-profile mt-5">
                            <div class="header-box-admin">
                                <h3>Пополнить кошелек</h3>
                            </div>
                            <div class="body-box-admin">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Номер карты</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phoneNumber">Фамилия</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Код подтверждения</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-light-green">
                                    <i class="fas fa-share"></i>
                                    Пополнить счет
                                </button>

                            </div>
                        </section>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade " id="tab-content-6" role="tabpanel" aria-labelledby="tab-6">
                <div class="row">
                    <div class="col-sm-12 pt-4">
                        <h5>Пополнение счета с помощью карт "VISA"</h5>

                        <section class="box-admin edit-profile mt-5">
                            <div class="header-box-admin">
                                <h3>Пополнить кошелек</h3>
                            </div>
                            <div class="body-box-admin">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Номер карты</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phoneNumber">Фамилия</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Код подтверждения</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-light-green">
                                    <i class="fas fa-share"></i>
                                    Пополнить счет
                                </button>

                            </div>
                        </section>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade " id="tab-content-7" role="tabpanel" aria-labelledby="tab-7">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <h5>Написание</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-47" class="custom-control-input"
                                           value="47">
                                    <label for="category-47" class="custom-control-label">Копирайтинг</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-48" class="custom-control-input"
                                           value="48">
                                    <label for="category-48" class="custom-control-label">Рерайтинг</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-54" class="custom-control-input"
                                           value="54">
                                    <label for="category-54" class="custom-control-label">Для соц сети</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-55" class="custom-control-input"
                                           value="55">
                                    <label for="category-55" class="custom-control-label">Сценарии</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-56" class="custom-control-input"
                                           value="56">
                                    <label for="category-56" class="custom-control-label">Стихи, рассказы, сказки</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <h5>Перевод</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-116" class="custom-control-input"
                                           value="116">
                                    <label for="category-116" class="custom-control-label">Письменный</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-117" class="custom-control-input"
                                           value="117">
                                    <label for="category-117" class="custom-control-label">Устный</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-118" class="custom-control-input"
                                           value="118">
                                    <label for="category-118" class="custom-control-label">Локализация</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-119" class="custom-control-input"
                                           value="119">
                                    <label for="category-119" class="custom-control-label">Нотариальное заверение
                                        переводов</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <h5>Спец переводы</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-120" class="custom-control-input"
                                           value="120">
                                    <label for="category-120" class="custom-control-label">Технический</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-121" class="custom-control-input"
                                           value="121">
                                    <label for="category-121" class="custom-control-label">Юридический</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-122" class="custom-control-input"
                                           value="122">
                                    <label for="category-122" class="custom-control-label">Медицинский</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-123" class="custom-control-input"
                                           value="123">
                                    <label for="category-123" class="custom-control-label">Экономический и финансовый</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-124" class="custom-control-input"
                                           value="124">
                                    <label for="category-124" class="custom-control-label">Художественный</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-125" class="custom-control-input"
                                           value="125">
                                    <label for="category-125" class="custom-control-label">Синхронный</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <h5>Доработка</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-50" class="custom-control-input"
                                           value="50">
                                    <label for="category-50" class="custom-control-label">Редактура</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-51" class="custom-control-input"
                                           value="51">
                                    <label for="category-51" class="custom-control-label">Контент анализ</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-52" class="custom-control-input"
                                           value="52">
                                    <label for="category-52" class="custom-control-label">Транскрибация - аудио в текст</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-126" class="custom-control-input"
                                           value="126">
                                    <label for="category-126" class="custom-control-label">Коректура</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade " id="tab-content-5" role="tabpanel" aria-labelledby="tab-5">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <h5>Предпринимателю</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-109" class="custom-control-input"
                                           value="109">
                                    <label for="category-109" class="custom-control-label">Бухгалтерия и налоги</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-110" class="custom-control-input"
                                           value="110">
                                    <label for="category-110" class="custom-control-label">Юридическая помощь</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-111" class="custom-control-input"
                                           value="111">
                                    <label for="category-111" class="custom-control-label">Обучение и консалтинг</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-113" class="custom-control-input"
                                           value="113">
                                    <label for="category-113" class="custom-control-label">Менеджмент проектов</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" id="category-114" class="custom-control-input"
                                           value="114">
                                    <label for="category-114" class="custom-control-label">Нейминг</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection