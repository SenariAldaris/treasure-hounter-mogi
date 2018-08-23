$(function () { // выполнять данный код при загрузке страницы (AKA DOM load)
/* устанавливаем переменные */
var scroll_timer;
var displayed = false;
var $message = $('#message');
var $window = $(window);
var top = $(document.body).children(0).position().top;

/* реагируем при событии "прокрутки в окне" */
$window.scroll(function () {
	window.clearTimeout(scroll_timer);
	scroll_timer = window.setTimeout(function () { // используем таймер для выполнения
		if($window.scrollTop() <= top) // скрываем кнопку, если находимся в верхней части страницы
		{
			displayed = false;
			$message.fadeOut(500);
		}
		else if(displayed == false) // показываем кнопку, если прокручиваем вниз страницу
		{
			displayed = true;
			$message.stop(true, true).fadeIn(500).click(function () { $message.fadeOut(500); });
		}
	}, 100);
});
	$('#top-link').click(function(e) { 
		e.preventDefault();
		$.scrollTo(0,300); 
   });
});

