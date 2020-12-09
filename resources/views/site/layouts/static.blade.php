<!DOCTYPE html>
<html lang="ru-ru" dir="ltr" vocab="http://schema.org/">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') | TezInfo</title>
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <style type="text/css">
    :root #content > #right > .dose > .dosesingle,
    :root #content > #center > .dose > .dosesingle
      { display: none !important; }</style>
	<script src="{{ asset('assets/js/uikit.min.js') }}"></script>
	<script src="{{ asset('assets/js/uikit-icons.min.js') }}"></script>
	<script>
document.addEventListener('DOMContentLoaded', function() {
Array.prototype.slice.call(document.querySelectorAll('a span[id^="cloak"]')).forEach(function(span) {
    span.innerText = span.textContent;
});
});
var $theme = {};
	</script>
  @yield('headerjs')
</head>
  <body>
    <div class="tm-page">
      @yield('content')
    </div>
  </body>
</html>
