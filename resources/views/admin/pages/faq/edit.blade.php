@extends('admin.layouts.app')

@section('title', 'FAQ '.$faq->getTitle())
@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.faq.index'),
                'title' => 'FAQ'
            ]
        ],
        'lastTitle' => 'FAQ '.$faq->getTitle()
    ])
    <form action="{{ route('admin.faq.update', $faq->id) }}" method="post">
        @method('PUT')
        @csrf
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ $faq->getTitle() }} <small>FAQ</small></h3>
            </div>
            <div class="wizard-block">
                <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#wizard-simple-step1" data-toggle="tab">1. Русский</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#wizard-simple-step2" data-toggle="tab">2. Английский</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#wizard-simple-step3" data-toggle="tab">3. Узбекский</a>
                    </li>
                </ul>
                <!-- END Step Tabs -->

                <!-- Steps Content -->
                <div class="block-content block-content-full tab-content">
                    <!-- Step 1 -->
                    <div class="tab-pane active" id="wizard-simple-step1" role="tabpanel">
                        <div class="form-group @error('ru_title') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="ruTitle" name="ru_title"
                                       value="{{ $faq->ru_title }}">
                                <label for="ruTitle" @error('ru_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('ru_title') <span class="text-danger">*</span> @enderror
                                </label>
                            </div>
                            @error('ru_title')
                            <div id="val-username-error"
                                 class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <!-- END Step 1 -->

                    <!-- Step 2 -->
                    <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                        <div class="form-group @error('en_title') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="en_title" name="enTitle"
                                       value="{{ $faq->en_title }}">
                                <label for="enTitle" @error('en_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('en_title') <span class="text-danger">*</span> @enderror
                                </label>
                            </div>
                            @error('en_title')
                            <div id="val-username-error"
                                 class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <!-- END Step 2 -->

                    <!-- Step 3 -->
                    <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                        <div class="form-group @error('uz_title') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="uzTitle" name="uz_title"
                                       value="{{ $faq->uz_title }}">
                                <label for="uzTitle" @error('uz_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('uz_title') <span class="text-danger">*</span> @enderror
                                </label>
                            </div>
                            @error('uz_title')
                            <div id="val-username-error"
                                 class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <!-- END Step 3 -->
                    <!-- END Steps Content -->
                </div>
            </div>
            <div class="block-content mb-10">
                <div class="block-content text-right pb-10">
                    <button class="btn btn-alt-success" name="save">Сохранить</button>
                    <button class="btn btn-alt-success" name="saveQuit">Сохранить и выйти</button>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Элементы</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-primary" type="button" id="addItemButton"><i class="fa fa-plus"></i> Добавить</button>
                </div>
            </div>
            <div class="block-content" id="faqItems">
                @foreach($faq->items as $key => $item)
                    <div class="block block-themed faq-item" id="faqItem{{ $key }}">
                        <div class="block-header bg-primary bg-primary-light">
                            <h3 class="block-title">Вопрос - ответ</h3>
                            <div class="block-options">
                                <button class="btn-block-option delete-button" type="button" data-toggle="tooltip"
                                        title="Удалить элемент" data-item-id="faqItem{{ $key }}"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="wizard-block">
                                <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#wizard-item{{ $key }}-simple-step1" data-toggle="tab">1. Русский</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#wizard-item{{ $key }}-simple-step2" data-toggle="tab">2. Английский</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#wizard-item{{ $key }}-simple-step3" data-toggle="tab">3. Узбекский</a>
                                    </li>
                                </ul>
                                <!-- END Step Tabs -->

                                <!-- Steps Content -->
                                <div class="block-content block-content-full tab-content">
                                    <!-- Step 1 -->
                                    <div class="tab-pane active" id="wizard-item{{ $key }}-simple-step1" role="tabpanel">
                                        <div class="form-group">
                                            <div class="form-material floating">
                                                <input class="form-control" type="text" id="ru_question{{ $key }}"
                                                       name="items[{{ $key }}][ru_question]" value="{{ $item->ru_question }}">
                                                <label for="ru_question{{ $key }}">
                                                    Вопрос
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ru_content{{ $key }}">Ответ</label>
                                            <textarea name="items[{{ $key }}][ru_content]" id="ru_content{{ $key }}"
                                                      class="form-control">{!! $item->ru_content !!}</textarea>
                                        </div>
                                    </div>
                                    <!-- END Step 1 -->

                                    <!-- Step 2 -->
                                    <div class="tab-pane" id="wizard-item{{ $key }}-simple-step2" role="tabpanel">
                                        <div class="form-group">
                                            <div class="form-material floating">
                                                <input class="form-control" type="text" id="en_question{{ $key }}"
                                                       name="items[{{ $key }}][en_question]" value="{{ $item->en_title }}">
                                                <label for="en_question{{ $key }}">
                                                    Вопрос
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="en_content{{ $key }}">Ответ</label>
                                            <textarea name="items[{{ $key }}][en_content]" id="en_content{{ $key }}"
                                                      class="form-control">{!! $item->en_content !!}</textarea>
                                        </div>
                                    </div>
                                    <!-- END Step 2 -->

                                    <!-- Step 3 -->
                                    <div class="tab-pane" id="wizard-item{{ $key }}-simple-step3" role="tabpanel">
                                        <div class="form-group">
                                            <div class="form-material floating">
                                                <input class="form-control" type="text" id="uz_question{{ $key }}"
                                                       name="items[{{ $key }}][uz_question]" value="{{ $item->uz_title }}">
                                                <label for="uz_question{{ $key }}">
                                                    Вопрос
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="uz_content{{ $key }}">Ответ</label>
                                            <textarea name="items[{{ $key }}][uz_content]" id="uz_content{{ $key }}"
                                                      class="form-control">{!! $item->uz_content !!}</textarea>
                                        </div>
                                    </div>
                                    <!-- END Step 3 -->
                                    <!-- END Steps Content -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    <template id="faqItem">
        <div class="block block-themed faq-item" id="faqItem{0}">
            <div class="block-header bg-primary bg-primary-light">
                <h3 class="block-title">Вопрос - ответ</h3>
                <div class="block-options">
                    <button class="btn-block-option delete-button" type="button" data-toggle="tooltip"
                            title="Удалить элемент" data-item-id="faqItem{0}"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            <div class="block-content">
                <div class="wizard-block">
                    <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#wizard-item{0}-simple-step1" data-toggle="tab">1. Русский</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#wizard-item{0}-simple-step2" data-toggle="tab">2. Английский</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#wizard-item{0}-simple-step3" data-toggle="tab">3. Узбекский</a>
                        </li>
                    </ul>
                    <!-- END Step Tabs -->

                    <!-- Steps Content -->
                    <div class="block-content block-content-full tab-content">
                        <!-- Step 1 -->
                        <div class="tab-pane active" id="wizard-item{0}-simple-step1" role="tabpanel">
                            <div class="form-group">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="ru_question{0}"
                                           name="items[{0}][ru_question]">
                                    <label for="ru_question{0}">
                                        Вопрос
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ru_content{0}">Ответ</label>
                                <textarea name="items[{0}][ru_content]" id="ru_content{0}"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <!-- END Step 1 -->

                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-item{0}-simple-step2" role="tabpanel">
                            <div class="form-group">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="en_question{0}"
                                           name="items[{0}][en_question]">
                                    <label for="en_question{0}">
                                        Вопрос
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="en_content{0}">Ответ</label>
                                <textarea name="items[{0}][en_content]" id="en_content{0}"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 -->
                        <div class="tab-pane" id="wizard-item{0}-simple-step3" role="tabpanel">
                            <div class="form-group">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="uz_question{0}"
                                           name="items[{0}][uz_question]">
                                    <label for="uz_question{0}">
                                        Вопрос
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="uz_content{0}">Ответ</label>
                                <textarea name="items[{0}][uz_content]" id="uz_content{0}"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <!-- END Step 3 -->
                        <!-- END Steps Content -->
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection

@section('js')
    <script>
        if (!String.prototype.format) {
            String.prototype.format = function () {
                var args = arguments;
                return this.replace(/{(\d+)}/g, function (match, number) {
                    return typeof args[number] != 'undefined'
                        ? args[number]
                        : match
                        ;
                });
            };
        }

        function deleteFaqItem() {
            let deleteButton = $(this);
            let itemId = deleteButton.data('item-id');
            $(`#${itemId}`).remove();
        }

        jQuery(function () {
            let counter = {{ count($faq->items) }};
            let templateString = $('#faqItem').html();
            $('#addItemButton').on('click', function () {
                counter++;
                let itemString = templateString.format(counter);
                let faqItem = $(itemString);
                faqItem.find('.delete-button').on('click', deleteFaqItem);
                $('#faqItems').append(faqItem);
                CKEDITOR.replace(`ru_content${counter}`);
                CKEDITOR.replace(`en_content${counter}`);
                CKEDITOR.replace(`uz_content${counter}`);
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(`#faqItem${counter}`).offset().top
                }, 1000);
            });
            $('.delete-button').on('click', deleteFaqItem);
        })
    </script>
@endsection
