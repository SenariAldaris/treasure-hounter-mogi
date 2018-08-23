$(document).ready(function(){
    $('.block2').scrollbar({orientation: 'vertical'});
    $('.wrapper-creators__indoor__about__down').scrollbar({orientation: 'vertical'});
    $('.wrapper-footer__footer__news').scrollbar({orientation: 'vertical'});
	$('.general_cont').scrollbar({orientation: 'vertical'});
    $('.wrapper-footer__footer__button__big-block__main').scrollbar({orientation: 'vertical'});
	$('.undercover_front').scrollbar({orientation: 'vertical'});
	$('.undercover_back1').scrollbar({orientation: 'vertical'});
	$('.undercover_front1').scrollbar({orientation: 'vertical'});
	$('.undercover_front2').scrollbar({orientation: 'vertical'});
	$('.undercover_back2').scrollbar({orientation: 'vertical'});

    //beginning click
    // $('.wrapper-header__header__play-block__button').click(function() {
    //     $(this).children('.wrapper-header__header__play-block__button--arrows').toggleClass('active').closest('.wrapper-header__header__play-block').toggleClass('active');
    // });
    //end click
    //beginning menu clicks
    $('li[href^="."]').click(function(){
        var scroll_el = $(this).attr('href');
        $('html, body').animate({scrollTop: $(scroll_el).offset().top}, 600);
        return false;
    });
    //end menu clicks

        $('div[href^="."]').click(function(){
        var scroll_el = $(this).attr('href');
        $('html, body').animate({scrollTop: $(scroll_el).offset().top}, 600);
        return false;
    });
    //end menu clicks
/********************************************************************************************/
//beginning calcSlider
var calcWidth = $('.wrapper-heroes__slider-box').width();
var calcSlider = $('.wrapper-heroes__slider-box__slider');
var calcCount = $('.wrapper-heroes__slider-box__slider > li').length - 1;
var calcCourse = 1;
var calcMargin = 0;
var calcPrev = $('.wrapper-heroes__slider-box__controls--left');
var calcNext = $('.wrapper-heroes__slider-box__controls--right');
var calcControl = $('.wrapper-heroes__controls-buttons > img');
var flagControl = 0;
var one;
    function animate5(){
        if(calcMargin === -calcWidth && calcCourse === -1){
            calcPrev.css({'opacity':'0','cursor':'default'});
            calcMargin = calcMargin - calcWidth*(calcCourse);
        }
        else if(calcMargin === 0 && calcCourse === -1){
            calcCourse === 1;
            return false;
        }
        else if(flagControl === -1){
            calcMargin = one*calcWidth*(-1);

        }
        else if(calcMargin === -((calcCount - 1)*calcWidth) && calcCourse === 1){
            calcNext.css({'opacity':'0','cursor':'default'});
            calcMargin = calcMargin - calcWidth*(calcCourse);
        }
        else if(calcMargin === -(calcCount*calcWidth) && calcCourse === 1){
            calcCourse === -1;
            return false;
        }

        else{
            calcPrev.css({'opacity':'1','cursor':'pointer'});
            calcNext.css({'opacity':'1','cursor':'pointer'});
            calcMargin = calcMargin - calcWidth*(calcCourse);
        }
        var selectElement = calcMargin/calcWidth*(-1);
        $('.icon-' + selectElement).addClass('active').siblings('img').removeClass('active');
        $('.wrapper-heroes__slider-box__slider > li').removeClass('active');
        calcSlider.stop(true).delay(200).animate({'marginLeft':calcMargin},0, function() {
            $('.iconBig-' + selectElement).addClass('active');
        });

    }//end animate5

    calcPrev.click(function() {
        var calcCourse2 = calcCourse;
        calcCourse = -1;
        animate5();
        calcCourse = calcCourse2 ;
    });//end prev.click

    calcNext.click(function() {
        var calcCourse2 = calcCourse;
        calcCourse = 1;
        animate5();
        calcCourse = calcCourse2 ;
    });//end next.click

    calcControl.click(function() {
        one = $(this).index();
        var flagControl2 = flagControl;
        flagControl = -1;
        animate5();
        flagControl = flagControl2 ;
        if(one === 0){
            calcPrev.css({'opacity':'0','cursor':'default'});
            calcNext.css({'opacity':'1','cursor':'pointer'});
        }
        else if(one === 9){
            calcPrev.css({'opacity':'1','cursor':'pointer'});
            calcNext.css({'opacity':'0','cursor':'default'});
        }
        else{
            calcPrev.css({'opacity':'1','cursor':'pointer'});
            calcNext.css({'opacity':'1','cursor':'pointer'});
        }
    });//end next.click
/***********************************************************************************************/

/********************************************************************************************/
//beginning main3Slider
var main3SlideWidth = $('.wrapper-creators__indoor__about__slider-box__width__static').width();
var main3Slider = $('.wrapper-creators__indoor__about__slider-box__width__slider');
var main3SlideCount = $('.wrapper-creators__indoor__about__slider-box__width__slider > li').length;

var main3Course = 1;
var main3Margin = -(main3SlideCount/3 * main3SlideWidth);
var newStatic = main3Margin - main3SlideWidth
var main3Prev = $('.wrapper-creators__indoor__about__slider-box__controls--left');
var main3Next = $('.wrapper-creators__indoor__about__slider-box__controls--right');

    main3Slider.css('margin-left', main3Margin);

//    var i = 0;
//    $('.main3-slider-box__slider > li').each(function() {
//        i++;
//        $(this).addClass('.element-' + i);
//    });

    function animate6(){

        if(main3Margin === -((main3SlideCount/3 - 1)*main3SlideWidth) && main3Course === -1){
            main3Slider.css({'marginLeft': -(((main3SlideCount/3*2)-1)*main3SlideWidth)});
            main3Margin= -(((main3SlideCount/3*2)-1)*main3SlideWidth) + main3SlideWidth;
        }

        else if(main3Margin === -(main3SlideCount/3*2*main3SlideWidth) && main3Course === 1){
            main3Slider.css({'marginLeft': -(main3SlideCount/3*main3SlideWidth)});           // то блок .slider возвращается в начальное положение
            main3Margin = main3Margin/2 - main3SlideWidth;
        }
         else{

            main3Margin = main3Margin - main3SlideWidth*(main3Course);
        }

        var selectElement2 = main3Margin/main3SlideWidth*(-1);
        $('.general-for-slider').removeClass('active');
        $('.wrapper-creators__indoor__about__slider-box__width__slider > li').removeClass('active');
        main3Slider.stop(true).animate({'marginLeft':main3Margin},300, function(){
            $('.el-' + selectElement2).addClass('active');
            $('.general-for-slider-' + selectElement2).addClass('active');
        });



    }//end animate6

    main3Prev.click(function() {
        var main3Course2 = main3Course;
        main3Course = -1;
        animate6();
        main3Course = main3Course2 ;
    });//end prev.click

    main3Next.click(function() {
        var main3Course2 = main3Course;
        main3Course = 1;
        animate6();
        main3Course = main3Course2 ;
    });//end next.click
//end main3Slider

    var slider = $('.wrapper-videos__slider-box__slider-width__slider');
    sliderContent = slider.html(),                      // Содержимое слайдера
    slideWidth = $('.wrapper-videos__slider-box__slider-width').width();              // Ширина слайдера
    slideCount = $('.wrapper-videos__slider-box__slider-width__slider > li').length;               // Количество слайдов
    prev = $('.wrapper-videos__slider-box__controls--left');                      // Кнопка "назад"
    next = $('.wrapper-videos__slider-box__controls--right');                      // Кнопка "вперед"
    slideNum = 1;                                       // Номер текущего слайда
    index = 0;
    clickBullets = 0;
    sliderInterval = 2000;                              // Интервал смены слайдов
    animateTime = 1000;                                 // Время смены слайдов
    course = 1;                                         // Направление движения слайдера (1 или -1)
    margin = - slideWidth;                              // Первоначальное смещение слайдов

    for (var i = 0; i < slideCount; i++){                      // Цикл добавляет буллеты в блок .bullets
        html = $('.wrapper-videos__slider-box__controls-buttons').html() + '<li></li>';          // К текущему содержимому прибавляется один буллет
        $('.wrapper-videos__slider-box__controls-buttons').html(html);                         // и добавляется в код
    }
    var  bullets = $('.wrapper-videos__slider-box__controls-buttons li')          // Переменная хранит набор буллитов


    $('.wrapper-videos__slider-box__controls-buttons li:first').addClass('active');
    $('.wrapper-videos__slider-box__slider-width__slider > li:last').clone().prependTo('.wrapper-videos__slider-box__slider-width__slider');   // Копия последнего слайда помещается в начало.
    $('.wrapper-videos__slider-box__slider-width__slider > li').eq(1).clone().appendTo('.wrapper-videos__slider-box__slider-width__slider');   // Копия первого слайда помещается в конец.
    $('.wrapper-videos__slider-box__slider-width__slider').css('margin-left', -slideWidth);         // Контейнер .slider сдвигается влево на ширину одного слайда.

    function nextSlide(){                                 // Запускается функция animation(), выполняющая смену слайдов.
        interval = window.setInterval(animate, sliderInterval);
    }

    function animate(){
        if (margin == -slideCount*slideWidth-slideWidth  && course == 1){     // Если слайдер дошел до конца
            slider.css({'marginLeft':-slideWidth});           // то блок .slider возвращается в начальное положение
            margin = -slideWidth*2;
        }
        else if(margin == 0 && course == -1){                  // Если слайдер находится в начале и нажата кнопка "назад"
            slider.css({'marginLeft':-slideWidth*slideCount});// то блок .slider перемещается в конечное положение
            margin = -slideWidth*slideCount+slideWidth;
        }
        else{                                              // Если условия выше не сработали,
            margin = margin - slideWidth*(course);            // значение margin устанавливается для показа следующего слайда
        }
        slider.animate({'marginLeft':margin},animateTime);  // Блок .slider смещается влево на 1 слайд.

        if (clickBullets == 0){                               // Если слайдер сменился не через выбор буллета
            bulletsActive();                                // Вызов функции, изменяющей активный буллет
        }
        else{                                              // Если слайдер выбран с помощью буллета
            slideNum = index + 1;                               // Номер выбранного слайда
        }
    }//Конец animate

    function bulletsActive(){
        if (course == 1 && slideNum != slideCount){        // Если слайды скользят влево и текущий слайд не последний
            slideNum++;                                     // Редактирунтся номер текущего слайда
            $('.wrapper-videos__slider-box__controls-buttons .active').removeClass('active').next('li').addClass('active'); // Изменить активный буллет
        }
        else if (course == 1 && slideNum == slideCount){       // Если слайды скользят влево и текущий слайд последний
            slideNum = 1;                                     // Номер текущего слайда
            $('.wrapper-videos__slider-box__controls-buttons li').removeClass('active').eq(0).addClass('active'); // Активным отмечается первый буллет
            return false;
        }
        else if (course == -1  && slideNum != 1){              // Если слайды скользят вправо и текущий слайд не последни
            slideNum--;                                     // Редактирунтся номер текущего слайда
            $('.wrapper-videos__slider-box__controls-buttons .active').removeClass('active').prev('li').addClass('active'); // Изменить активный буллет
            return false;
        }
        else if (course == -1  && slideNum == 1){              // Если слайды скользят вправо и текущий слайд последни
            slideNum = slideCount;                            // Номер текущего слайда
            $('.wrapper-videos__slider-box__controls-buttons li').removeClass('active').eq(slideCount - 1).addClass('active'); // Активным отмечается последний буллет
        }
    }//Конец bulletsActive

    function sliderStop(){                                // Функция преостанавливающая работу слайдера
        window.clearInterval(interval);
    }

    prev.click(function() {                               // Нажата кнопка "назад"
        if (slider.is(':animated')) { return false; }       // Если не происходит анимация
        var course2 = course;                               // Временная переменная для хранения значения course
        course = -1;                                        // Устанавливается направление слайдера справа налево
        animate();                                          // Вызов функции animate()
        course = course2 ;                                  // Переменная course принимает первоначальное значение
        $('.wrapper-videos__slider-box__slider-width__slider__video-main__indoor__video').html('<iframe></iframe>').prev('div').removeClass('active').closest('.wrapper-header__header__video-main').removeClass('active');
    });//Конец prev.click

    next.click(function() {                               // Нажата кнопка "назад"
        if (slider.is(':animated')) { return false; }       // Если не происходит анимация
        var course2 = course;                               // Временная переменная для хранения значения course
        course = 1;                                         // Устанавливается направление слайдера справа налево
        animate();                                          // Вызов функции animate()
        course = course2 ;                                  // Переменная course принимает первоначальное значение
        $('.wrapper-videos__slider-box__slider-width__slider__video-main__indoor__video').html('<iframe></iframe>').prev('div').removeClass('active').closest('.wrapper-header__header__video-main').removeClass('active');
    });//Конец next.click

    bullets.click(function() {                            // Нажат один из буллетов
                                              // Таймер на показ очередного слайда выключается
        index = bullets.index(this);                        // Номер нажатого буллета
        if (course == 1){                                     // Если слайды скользят влево
            margin = -slideWidth*index;                       // значение margin устанавливается для показа следующего слайда
        }
        else if (course == -1){                              // Если слайды скользят вправо
            margin = -slideWidth*index-2*slideWidth;
        }
        $('.wrapper-videos__slider-box__controls-buttons li').removeClass('active').eq(index).addClass('active');  // Выбранному буллету добавляется класс .active
        clickBullets = 1;                                     // Флаг информирующий о том, что слайд выбран именно буллетом
        animate();
        clickBullets = 0;
        $('.wrapper-videos__slider-box__slider-width__slider__video-main__indoor__video').html('<iframe></iframe>').prev('div').removeClass('active').closest('.wrapper-header__header__video-main').removeClass('active');
    });//Конец bullets.click

    // slider.add(next).add(prev).hover(function() {         // Если курсор мыши в пределах слайдера
    //     sliderStop();                                       // Вызывается функция sliderStop() для приостановки работы слайдера
    // }, nextSlide);                                        // Когда курсор уходит со слайдера, анимация возобновляется.

     // nextSlide();                                          // Вызов функции nextSlide()























    $('.wrapper-videos__slider-box__slider-width__slider__video-main__indoor__video').click(function() {
        $(this).addClass('active').prev('div').addClass('active');
    });

    $('.wrapper-header__header__video-main__indoor__video').click(function() {
        $(this).addClass('active').html('<iframe src="http://www.youtube.com/embed/Xho2ZZCJvXo?feature=player_detailpage&amp;rel=0&amp;showinfo=0&amp;autoplay=1;hd=1" width="100%" height="100%" frameborder="0" wmode="opaque" allowfullscreen></iframe>').prev('div').addClass('active').closest('.wrapper-header__header__video-main').addClass('active');

    });

    $('.one-video').click(function() {
        $(this).addClass('active').html('<iframe src="http://www.youtube.com/embed/7Zl8KF-CFY0?feature=player_detailpage&amp;rel=0&amp;showinfo=0&amp;autoplay=1;hd=1" width="100%" height="100%" frameborder="0" wmode="opaque" allowfullscreen></iframe>').prev('div').addClass('active').closest('.wrapper-header__header__video-main').addClass('active');
    });

    $('.two-video').click(function() {
        $(this).addClass('active').html('<iframe src="http://www.youtube.com/embed/Ay4yMiHqQxE?feature=player_detailpage&amp;rel=0&amp;showinfo=0&amp;autoplay=1;hd=1" width="100%" height="100%" frameborder="0" wmode="opaque" allowfullscreen></iframe>').prev('div').addClass('active').closest('.wrapper-header__header__video-main').addClass('active');
    });

    $('.five-video').click(function() {
        $(this).addClass('active').html('<iframe src="http://www.youtube.com/embed/TMdl-S4X6TA?feature=player_detailpage&amp;rel=0&amp;showinfo=0&amp;autoplay=1;hd=1" width="100%" height="100%" frameborder="0" wmode="opaque" allowfullscreen></iframe>').prev('div').addClass('active').closest('.wrapper-header__header__video-main').addClass('active');
    });

    $('.three-video').click(function() {
        $(this).addClass('active').html('<iframe src="http://www.youtube.com/embed/-cG0P1nRmOk?feature=player_detailpage&amp;rel=0&amp;showinfo=0&amp;autoplay=1;hd=1" width="100%" height="100%" frameborder="0" wmode="opaque" allowfullscreen></iframe>').prev('div').addClass('active').closest('.wrapper-header__header__video-main').addClass('active');
    });

    $('.four-video').click(function() {
        $(this).addClass('active').html('<iframe src="http://www.youtube.com/embed/S3B8MPPowLs?feature=player_detailpage&amp;rel=0&amp;showinfo=0&amp;autoplay=1;hd=1" width="100%" height="100%" frameborder="0" wmode="opaque" allowfullscreen></iframe>').prev('div').addClass('active').closest('.wrapper-header__header__video-main').addClass('active');
    });


    //beginning menu changes
    $('.wrapper-footer__footer__news__block__list__button--more').click(function (){
        if(!($(this).hasClass('on'))){
            $(this).addClass('on').text("свернуть").prev('p').addClass('active');
        }
        else{
            $(this).removeClass('on').text("подробнее »").prev('p').removeClass('active');
        }
    });
    //end menu changes



    $('.wrapper-footer__footer__button').click(function() {
        $(this).next('div').toggleClass('active');
    });

    $('.wrapper-footer__footer__button__big-block__close').click(function() {
        $(this).parent('div').removeClass('active');
    });




});//end .ready
