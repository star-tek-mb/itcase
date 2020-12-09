@extends('site.layouts.static')

@section('title', '<<< Title here >>>')

@section('headerjs')
<script>
document.addEventListener('DOMContentLoaded', function() {
    Array.prototype.slice.call(document.querySelectorAll('a span[id^="cloak"]')).forEach(function(span) {
        span.innerText = span.textContent;
    });
});
</script>
@endsection

@section('content')
    <div id="system-message-container" data-messages="[]"></div>
    <div class="uk-section-default uk-light">
        <div style="background-image: url(&quot;/templates/yootheme/cache/3175-f2d3e635.webp&quot;); min-height: calc((100vh - 0px) - 20vh);" class="uk-background-norepeat uk-background-cover uk-background-center-center uk-section uk-flex uk-flex-middle" uk-height-viewport="offset-top: true; offset-bottom: 20;">    
            <div class="uk-width-1-1">
                <div class="uk-container"><div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                    <div class="uk-width-1-1@m uk-first-column">
                        <h1 class="uk-heading-large uk-text-left"><b>Реклама на пакетах</b></h1>
                        <div class="uk-text-primary uk-margin"><b>Это, пожалуй, самый дешевый и доступный способ заявить о себе.</b>
                        </div>
                        <b></b>
                    </div>
                    <b></b>
                </div>
            </div>
            <b></b>
        </div>
        <b></b>
    </div>
    <b></b>
</div>
<b>
    <div class="uk-section-default uk-section">
        <div class="uk-container"><div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
            <div class="uk-width-1-1@m uk-first-column">
                <h1>Прайс лист</h1>
                <div class="uk-overflow-auto">    
                    <table class="uk-table">
                        <thead>
                            <tr>
                                <th class="uk-text-nowrap">Наименование</th>
                                <th>Информация</th>
                                <th class="uk-text-nowrap">Цена</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="el-item">
                                <td class="uk-text-nowrap uk-table-shrink">
                                    <div class="el-title">1 тираж</div>
                                </td>
                                <td>
                                    <div class="el-content uk-panel">реклама на пакетах</div>
                                </td>
                                <td class="uk-text-nowrap uk-table-shrink">
                                    <div class="el-meta uk-text-meta">80 000 сум</div>
                                </td>
                            </tr>
                            <tr class="el-item">
                                <td class="uk-text-nowrap">
                                    <div class="el-title">1 модуль</div>
                                </td>
                                <td>
                                    <div class="el-content uk-panel">размер пакета 30 x 40 см</div>
                                </td>
                                <td class="uk-text-nowrap">
                                    <div class="el-meta uk-text-meta">3 400 000 сум</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="uk-section-default uk-section">
    <div class="uk-container"></div>
</div>
</b>
@endsection

