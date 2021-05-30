<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Административная панель бота</title>
    <link href="https://unpkg.com/@tailwindcss/forms/dist/forms.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <link href="/css/all.min.css" rel="stylesheet">
    <style>
      .bg-main { background: linear-gradient(90deg, #7D7CD3 0%, #5553C4 100%); }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  </head>
  <body>
    <header class="flex bg-main py-12 px-4 md:px-12">
      <ul class="container grid md:grid-cols-3 grid-rows-1 text-center text-white">
        <li class="col-4">
          <a class="underline" href="{{ route('site.page', 'about') }}">О компании</a>
        </li>
        <li class="col-4">
          Почта:  itcase.com@yandex.ru
        </li>
        <li class="col-4">
          Телефон для справок:  +99899420 00 00
        </li>
      </ul>
    </header>
    <main class="text-center w-full md:w-1/2 mx-auto py-8">
        <img class="w-32 h-auto mx-auto" src="/resources/images/itcase.png">
        <div class="text-6xl font-semibold">itcase.com</div>
        <div class="text-4xl mt-4 font-bold">Персональный помощник itcase.com в вашем кормане</div>
        <div class="text-4xl mt-4">
          Скачайте наше приложение и пользуйтесь itcase.com, где бы вы ни находились. Разовая оплата за использование сервиса производится в размере 53 000 сум
        </div>
        <img class="w-128 h-auto mx-auto my-8 cursor-pointer" src="/resources/images/googleplay.svg">
        <div class="text-4xl mb-8">А также можете скачать приложение с нашего сайта:</div>
        <img class="w-16 h-auto mx-auto" src="/resources/images/itcase.png">
        <div class="text-4xl font-medium hover:text-blue-500"><a href="/itcase.apk">Скачать</a></div>
    </main>
    <footer class="bg-main text-white py-12">
      <div class="grid grid-rows-1 md:grid-cols-2 gap-4 container mx-auto px-4 md:px-12 items-center">
        <div class="px-4">
          <b>Реквизиты компании</b><br>
          Общество с ограниченной ответственностью «Avto Powerball»<br>
          Адрес для корреспонденции, направления жалоб и предложений: Узбекистан , г. Ташкент, Олтин тепа, д. 204<br>
          ИНН 306870820<br>
          МФО: 01041<br>
          ОКЭД: 73110<br>
          Почта: avtopowerball@gmail.com
        </div>
        <div class="text-center px-4 text-xl">
          Способы разовой оплаты за использования сервиса
          <div class="">
            <img class="inline" style="width: 72px; height: 72px;" src="/resources/images/visa.png">
            <img class="inline ml-2" style="width: 72px; height: 44px;" src="/resources/images/mastercard.png">
            <img class="inline ml-2" style="width: 72px; height: 43px;" src="/resources/images/uzcard.png">
            <img class="inline ml-2" style="width: 65px; height: 43px;" src="/resources/images/humo.png">
          </div>
        </div>
      </div>
      <hr class="w-full my-6">
      <div class="flex px-4 md:px-12 container text-xl mx-auto">
        <div class="whitespace-nowrap text-left">© 2021 itcase.com</div>
        <div class="w-full text-center mx-auto">
          <a class="hover:underline" href="{{ route('site.page', 'terms-of-service') }}">Правила сервиса</a> |
          <a class="hover:underline" href="{{ route('site.page', 'offerta') }}"> Оферта</a> |
          <a class="hover:underline" href="{{ route('site.page', 'privacy-policy') }}">Политика конфиденциальности</a>
        </div>
      </div>
    </footer>
  </body>
</html>