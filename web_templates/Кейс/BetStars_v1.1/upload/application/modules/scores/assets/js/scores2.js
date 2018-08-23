var direct_url = "http://gigascore.com/";
var fav_soccer = new Array();
var fav_tennis = new Array();
var fav_hockey = new Array();
var fav_volleyball = new Array();
var fav_basketball = new Array();
var fav_baseball = new Array();
var fav_handball = new Array();
var fav_football = new Array();
var sport_tab = new Array();
var rem_menu = new Array('block', 'block', 'none', 'none', 'none', 'none', 'none', 'none');
var fav_m_tab = new Array();

var my_matches_activ;
var ended_activ;
var all_activ;
var live_activ;
var my_matches_view;

var freebet_date = new Date();
var draw_h = 1;

var day = freebet_date.getDate();
var month_nr = freebet_date.getMonth();
var year = freebet_date.getFullYear();
var get_count;
var img_src;
var src_length;
var replace;
var fav_id;
var fav_m_tab_length;
var fav_val;
var cur_sport;

var set_m_active;

$(document).ready(function() {
    check_cookies();
    var no_found_fav = $('.no_found_fav');
    var no_found_m = $('.no_found_m');

    $('.main_bar').after(no_found_fav);
    $('.main_bar').after(no_found_m);

    $(".date-pick").datepicker({
        prevText: '<<',
        nextText: '>>',
        numberOfMonths: [1, 1],
        dateFormat: 'dd-mm-yy',
        altFormat: 'yy-mm-dd',
        firstDay: 1,
        inline: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1940:2020',
        showOn: 'both'
    });



    $('.pagination_ajax a').live("click", function(event) {
        var selected = '#ui-tabs-' + parseInt($("#tabs").tabs("option", "selected"));
        $.ajax({

            url: $(this).attr('href'),
            success: function(data) {
                $(selected).html(data);
            },
            beforeSend: function() {
                $(selected).html('<img src="' + direct_url.substr(0, direct_url.length - 3) + '/static/img/ajax-loader1.gif" alt="loader" />');
            }
        });
        return false;
    });




    $(function() {
        $("#tabs").tabs({
            ajaxOptions: {
                error: function(xhr, status, index, anchor) {
                    $(anchor.hash).html(
                            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                            "If this wouldn't be a demo.");
                }

            }

        });
    });


    $('#change_competition').change(function() {
        var stage_id = $('#change_competition').val();
        $('#change_form').attr('action', direct_url + '/soccer/fixtures/' + stage_id);
        $('#change_form').submit();
    }
    );

    /* check if there is a cookie for control side menu display and if yes then set menu correctly */
    if ($.cookie('menu')) {
        var read_menu_cookie = $.cookie('menu');
        var save_to_rem = read_menu_cookie.split(/\,/g);
        $.each(
                rem_menu,
                function(intIndex, objValue) {
                    $('#col1 ul li ul').each(function() {
                        var ul_id = ($(this).attr('id'));
                        var id_len = ul_id.length;
                        var id_nr = $(this).attr('id').substring(id_len - 1, id_len);

                        if (id_nr == intIndex + 1) {
                            $(this).css('display', save_to_rem[intIndex]);
                            if (save_to_rem[intIndex] == 'block') {
                                $(this).prev().children().eq(1).toggleClass('down');
                            }
                        }
                        rem_menu[intIndex] = save_to_rem[intIndex];
                    });
                });
    } else {
        $('#col1 ul li ul').css('display', 'none');
        $('#col1 ul li ul#sub_m_1').css('display', 'block');
        $('#col1 ul li ul#sub_m_2').css('display', 'block');
    }
    /* end - check if there is a cookie for control side menu display and if yes then set menu correctly */
    //TODO ROBERT active
    $('#col1 ul li ul li a').click(function() {
        var menu_act_sport = 'm_' + cur_sport;
        $.cookie(menu_act_sport, $(this).parent().attr('id'), {
            expires: 7,
            path: '/',
            domain: ''
        })
    });

    $('#top_menu li a').click(function() {
        $.cookie('m_soccer', 'none', {
            expires: 7,
            domain: '',
            path: '/'
        });
        $.cookie('m_hockey', 'none', {
            expires: 7,
            domain: '',
            path: '/'
        });
        $.cookie('m_basketball', 'none', {
            expires: 7,
            domain: '',
            path: '/'
        });
        $.cookie('m_tennis', 'none', {
            expires: 7,
            domain: '',
            path: '/'
        });
        $.cookie('m_handball', 'none', {
            expires: 7,
            domain: '',
            path: '/'
        });
        $.cookie('m_voleyball', 'none', {
            expires: 7,
            domain: '',
            path: '/'
        });
        $.cookie('m_football', 'none', {
            expires: 7,
            domain: '',
            path: '/'
        });
    })

    /* adding to fav */
    $('.favs').livequery('click', function() {
        var this_ = $(this);
        img_src = $(this).attr('src');
        src_length = img_src.length;

        if (get_count < 20) {
            if (img_src.substring(src_length - 7, src_length) == 'add.png') {
                add_to_fav(this_);
            }
            else if (img_src.substring(src_length - 7, src_length) == 'rem.png') {
                rem_from_fav(this_);

            }
        } else {
            if (img_src.substring(src_length - 7, src_length) == 'add.png') {
                $("#to_much_favs").dialog({
                    width: 500,
                    minHeight: 50,
                    modal: true,
                    resizable: false,
                    draggable: false,
                    hide: 'highlight',
                    dialogClass: 'popup_class'
                })
            } else if (img_src.substring(src_length - 7, src_length) == 'rem.png') {
                rem_from_fav(this_);
            }
        }
        // usuwa tr'a z my matches, chowa belke z liga jesli w jej tabeli nie ma juz ulubionych
        if (my_matches_view == 1) {
            $(this).parent().parent().hide();
            $(this).parent().parent().removeClass('my_matches');
            if ($(this).parent().parent().parent().parent().children().has('.my_matches:visible').length == 0) {
                $(this).parent().parent().parent().parent().prev().hide();

//                $(this).parent().parent().parent().parent().addClass('delete');
            }
            $(this).parent().parent().remove();

            if ($('#dynamic_data .league_header_bar:visible').length === 0) {
                $('#sort_not_found').removeClass('hide');
            }
        }

        if (get_count <= 0 && my_matches_view == 1) {
            get_count = 0;
//            $('.main_bar').after($(no_found_m).show());
            $.cookie('soccer', null);
        }
    });


    /* end - adding to fav */


    /* actions with favs on mouse over and out */
    var tooltip;
    var text;
    var replace_m_over;

    $('.favs').livequery(function() {
        $(this).hover(function(e) {
            replace_m_over = $(this).attr('src').replace('ina', 'act');
            $(this).attr('src', replace_m_over);
            if ($(this).attr('alt') != '') {
                text = $(this).attr('alt');
                $('.tooltip').remove();
                tooltip = $('<div class="tooltip"><div class="tooltip_l">' + text + '</div><div class="tooltip_r"></div></div>').prependTo('body');
                var pos = $(this).position();
                $(tooltip).css('left', pos.left + 23);
                $(tooltip).css('top', pos.top - 5);
            }
        }, function() {
            replace_m_over = $(this).attr('src').replace('act', 'ina');
            $(this).attr('src', replace_m_over);
            $(tooltip).remove();
        });
    }, function() {
        $(this).unbind('mouseover').unbind('mouseout');

    });
    /* actions with favs on mouse over and out */



    $('.td_option a').livequery(function() {
        $(this).hover(function(e) {
            replace_m_over = $(this).css('background-image').replace('ina', 'act');
            $(this).css('background-image', replace_m_over);
            if ($(this).attr('rel') != '') {
                text = $(this).attr('rel');
                tooltip = $('<div class="tooltip"><div class="tooltip_l">' + text + '</div><div class="tooltip_r"></div></div>').prependTo('body');
                var pos = $(this).position();
                $(tooltip).css('left', pos.left + 23);
                $(tooltip).css('top', pos.top);
            }
        }, function() {
            replace_m_over = $(this).css('background-image').replace('act', 'ina');
            $(this).css('background-image', replace_m_over);
            $(tooltip).remove();
        });
    }, function() {
        $(this).unbind('mouseover').unbind('mouseout');

    });

// sortowanie meczów po: Wszystkie, W trakcie, Zakończone
    $('#sort_options a').click(function() {
        var $this = $(this),
                sort = $this.data('sort'),
                not_found = $('#sort_not_found');

        if (!$this.hasClass('active')) {
            // nie ma klasy active
            if (!not_found.hasClass('hide')) {
                not_found.addClass('hide'); // ukryj diva z inf.- Nie znaleziono meczów
            }
            $matchesTab.find('tr:hidden').show(); // pokaż wszystko co było ukryte

            $matchesTab.prev('.league_header_bar:hidden').show();

            if (my_matches_view === 1) {
                $matchesTab.each(function() {
                    var $this = $(this);
                    if ($this.find('tr').length === 0) {
                        $this.prev().hide();
                    }
                });
            }

            $('#dynamic_data .text_ad').show();

            if (sort !== 'all') {
                showMatches(sort); // jeśli ktoś kliknął w co innego niż 'wszystkie' to trzeba odpowiednio to posortować
            }

            // jeśli okazało się, że wszystko jest ukryte to pokaż diva z inf.- Nie znaleziono meczów
            if ($('#dynamic_data .league_header_bar:visible').length === 0 && $('#dynamic_data .league_header_bar').length > 0) {
                not_found.removeClass('hide');
            }

            $this.siblings().removeClass('active');
            $this.addClass('active');

        }
    });
    // end - sortowanie meczów po: Wszystkie, W trakcie, Zakończone

    $('.show_all').click(function() {
        $(this).parent().parent().parent().parent().next().children().show();
        return false;
    });

    $('.show_home').click(function() {
        var $childrenToShow = $(this).parent().parent().parent().parent().next().children();
        $childrenToShow.show();
        $childrenToShow.not('.played_home').hide();
        return false;
    });

    $('.show_away').click(function() {
        var $childrenToShow = $(this).parent().parent().parent().parent().next().children();
        $childrenToShow.show();
        $childrenToShow.not('.played_away').hide();
        return false;
    });

    /* control side menu after click on arrows */
    var repl;
    $('#col1 ul li div').click(function() {
        var $next = $(this).next(),
        id = $next.attr('id');

        $next.slideToggle('fast', function() {
            var $this = $(this);
            $this.prev().children().eq(1).toggleClass('down');

            var disp = $this.css('display'),
            menu_tab_index = id.substring(id.length - 1, id.length);
            rem_menu[menu_tab_index - 1] = disp;

            var menu_status = rem_menu.join(',');

            $.cookie('menu', menu_status, {
                expires: 7,
                path: '/',
                domain: ''
            });
        });
        return false;
    });
    /* end of control side menu after click on arrows */

    if ($('#countdown').length)
    {
        if (curr_lang == 'ro')
            draw_h = 0;
        if (curr_lang == 'en')
            draw_h = 2;
        count();
    }

    /* side calendar */
    var lang = curr_lang;
    //lang = lang.substring(lang.length-3, lang.length-1);

    //TODO ROBERT set correctly languages after adding them to site

    if (lang == 'en')
        lang = 'en-GB';
    if (lang == 'cz')
        lang = 'cs';
    if (lang == 'si')
        lang = 'sl';
    if (lang == 'se')
        lang = 'sv';
    if (lang == 'gr')
        lang = 'el';
    $.datepicker.setDefaults($.datepicker.regional[lang]);
    var set_date,
    url,
    format_date,
    day,
    month,
    year,
    formated;

    $('#calendar').datepicker({
        disabled: true,
        showOtherMonths: true,
        onSelect: function(dateText, inst) {
            format_date = dateText.replace(/\//g, "-");
            day = format_date.substring(0, 2);
            month = format_date.substring(3, 5);
            year = format_date.substring(6, 10);
            formated = day + '-' + month + '-' + year;

            if (show_calendar == true) {

                var url_without_hash = window.location.href.replace('#', '');

                if (get_param_from_url('date_select') == null) {

                    if (get_param_from_url('alias') == null) {
                        window.location.href = url_without_hash + '?date_select=' + formated;
                    }
                    else {
                        window.location.href = url_without_hash + '&date_select=' + formated;
                    }

                }
                else {
                    if (get_param_from_url('alias') == null) {
                        window.location.href = url_without_hash.substr(0, url_without_hash.length - 23) + '?date_select=' + formated;
                    }
                    else {
                        window.location.href = url_without_hash.substr(0, url_without_hash.length - 23) + '&date_select=' + formated;
                    }
                }

            }
            else {

                if (get_param_from_url('alias') == null) {
                    window.location.href = show_calendar + '?date_select=' + formated;
                }
                else {
                    window.location.href = show_calendar + '&date_select=' + formated;
                }

            }

        }

    });


    set_date = $('.view_name').text();

    if (set_date != '  ' && $('.view_name').length != 0) {
        day = set_date.substring(0, 2);
        month = set_date.substring(3, 5);
        year = set_date.substring(6, 10);
        set_date = day + '/' + month + '/' + year;
        $('#calendar').datepicker("setDate", set_date);
    }
    /* end - side calendar */

    $('.close').livequery('click', function() {
        $("#to_much_favs").dialog("close");
        $("#popup").dialog("close");
        $("#bookie_popup").dialog("close");

        $("#bookie_popup").dialog("destroy");
        $("#to_much_favs").dialog("destroy");
        $("#popup").dialog("destroy");
    });

    $('.td_score').livequery('click', function(e) {
        var get_id = $(this).parent().attr('id'),
        sport = $('h2').attr('title'),
        top = e.clientY - 50;

        $("#popup").dialog({
            width: 600,
            minHeight: 130,
            modal: true,
            resizable: false,
            draggable: false,
            hide: 'highlight',
            position: ['center', top],
            dialogClass: 'popup_class'

        });


        $.ajax({
            url: direct_url + "/" + sport + "/get_incidents/" + get_id + "?alias=" + get_param_from_url('alias'),
            timeout: 10000,
            success: function(data) {
                $("#popup").html(data);
            }
        });
        $('#popup').html('<div class="loader_light"></div>');
    });

    $('.bookies').livequery('click', function(e) {
        var get_id = $(this).parent().parent().attr('id'),
        sport = $('h2').attr('title'),
        position = e.clientY - 50;

        $.ajax({
            url: direct_url + "/" + sport + "/get_odds/" + get_id + "/?alias=" + get_param_from_url('alias'),
            timeout: 10000,
            success: function(data) {
                $("#bookie_popup").html(data);

                var set_def = $("#slider_bg .rate"),
                risk = $('.risk'),
                min = parseInt($(".rate").attr('title')),
                max = parseInt($("#slider").attr('title')),
                bonus = parseInt($(".risk").attr('title'));
                $(".rate").text(min);
                var bt1,
                bt2,
                btX,
                trs = $('#odds_table tr');

                $('#slider').slider({
                    value: min,
                    min: min,
                    max: max,
                    step: 5,
                    slide: function(event, ui) {
                        set_def.text(ui.value);
                        var i = 0;
                        for (tr in trs) {
                            if ((lang == 'de') || (lang == 'gr')) {
                                bt1 = $("#bt1_" + i).attr('title') * (ui.value + (ui.value / 2));
                                bt2 = $("#bt2_" + i).attr('title') * (ui.value + (ui.value / 2));
                                btX = $("#btx_" + i).attr('title') * (ui.value + (ui.value / 2));
                                bonus = ui.value / 2;
                            } else {
                                bt1 = $("#bt1_" + i).attr('title') * ui.value;
                                bt2 = $("#bt2_" + i).attr('title') * ui.value;
                                btX = $("#btx_" + i).attr('title') * ui.value;
                            }


                            $("#bt1_" + i).text(bt1.toFixed(2));
                            $("#bt2_" + i).text(bt2.toFixed(2));
                            $("#btx_" + i).text(btX.toFixed(2));
                            i = i + 1;

                        }

                        if (ui.value > bonus) {
                            risk.text(ui.value - bonus);
                            $('.win').removeClass().addClass('lost');
                        } else {
                            risk.text(0);
                            $('.lost').removeClass().addClass('win');
                        }
                    }
                });
            }
        });
        $('#bookie_popup').html('<div class="loader_light"></div>');

        $("#bookie_popup").dialog({
            width: 810,
            minHeight: 100,
            modal: true,
            resizable: false,
            draggable: false,
            hide: 'highlight',
            dialogClass: 'popup_class',
            position: ['center', position]
        });
        return false;
    });
    /* end popup with bookies */

    if (get_param_from_url('alias')) {
        $('a').livequery('click', function() {
            var $this = $(this),
            href = $this.attr('href');
            
            if (href != '#') {
                var temp_url = href;
                $(this).attr('href', temp_url + '?alias=' + get_param_from_url('alias'));
                window.location.href = $(this).attr('href');
            }
        });
    }

    $('#languages span').click(function() {
        var span_lang = $(this).attr('title');
        if (span_lang != '') {
            span_lang = span_lang + '.';
        }
        var replace_url = url_to_edit.replace('#lang_code#', span_lang);
        window.location.href = replace_url;
        return false;
    });


    $('.link').click(function() {
        var href = $(this).attr('href');
        var replace_link = href.replace('#', '');
        $(this).attr('href', replace_link);
    });



});





function get_ads(ads_size, div_id) {
    $.ajax({
        url: direct_url + "/adserver/get_ads/",
        datatype: "text",
        timeout: 10000,
        type: "GET",
        data: "ads_size=" + ads_size,
        success: function(data) {
            $(".adserver").html(data);
        }
    });
}

function get_live(date_sql, sport_name) {
    $.ajax({
        url: direct_url + sport_name + "/get_data/",
        type: "POST",
        timeout: 10000,
        data: "date=" + date_sql,
        success: function(data) {
            $("#dynamic_data").html(data);
            check_cookies();
        }

    });
    setTimeout(function() {
        get_live(date_sql, sport_name);
    }, 80000);
    $('.tooltip').remove();
}

function get_country_live(country_id, sport_name, date_select) {
    $.ajax({
        url: direct_url + sport_name + "/get_country_data/",
        type: "POST",
        timeout: 10000,
        data: "country_id=" + country_id + "&date_select=" + date_select,
        success: function(data) {
            $("#dynamic_data").html(data);
            check_cookies();
        }
    });
    setTimeout(function() {
        get_country_live(country_id, sport_name, date_select);
    }, 80000);
    $('.tooltip').remove();
}

function sport_table_fn() {

    var sport = $('h2').attr('title');
    var tab = new Array();
    switch (sport)
    {
        case 'soccer':
            tab = fav_soccer;
            break;
        case 'hockey':
            tab = fav_hockey;
            break;
        case 'tennis':
            tab = fav_tennis;
            break;
        case 'volleyball':
            tab = fav_volleyball;
            break;
        case 'basketball':
            tab = fav_basketball;
            break;
        case 'baseball':
            tab = fav_baseball;
            break;
        case 'handball':
            tab = fav_handball;
            break;
        case 'football':
            tab = fav_football;
            break;
    }
    return tab;
}

function cookies(sport_type) {
    sport_tab = sport_table_fn();
    $.each(
            sport_tab,
            function(intIndex, objValue) {
                $('#content tr').each(function() {
                    var $this = $(this);
                    if ($this.attr('id') == objValue) {
                        replace = $('.favs', this).attr('src').replace('add', 'rem');
                        $('.favs', this).attr('src', replace);
                        $this.addClass('my_matches');
                        return true;
                    }
                });
            }
    );
    get_count = sport_tab.length;
    $('.selected_counter').text(get_count);
}


function check_cookies() {
    get_count = parseInt($('#col1 .selected_counter').text());
    cur_sport = $('h2').attr('title');

    $matchesTab = $('.table_with_matches');
    $('#sort_options a.active').removeClass('active').trigger('click');

    if ($.cookie('soccer')) {
        var read_soccer = $.cookie('soccer');
        var save_soccer = read_soccer.split(/\,/g);
        fav_soccer = save_soccer;
        cookies('soccer');
    }
    if ($.cookie('tennis')) {
        var read_tennis = $.cookie('tennis');
        var save_tennis = read_tennis.split(/\,/g);
        fav_tennis = save_tennis;
        cookies('tennis');
    }
    if ($.cookie('hockey')) {
        var read_hockey = $.cookie('hockey');
        var save_hockey = read_hockey.split(/\,/g);
        fav_hockey = save_hockey;
        cookies('hockey');
    }
    if ($.cookie('volleyball')) {
        var read_volleyball = $.cookie('volleyball');
        var save_volleyball = read_volleyball.split(/\,/g);
        fav_volleyball = save_volleyball;
        cookies('volleyball');
    }
    if ($.cookie('basketball')) {
        var read_basketball = $.cookie('basketball');
        var save_basketball = read_basketball.split(/\,/g);
        fav_basketball = save_basketball;
        cookies('basketball');
    }
    if ($.cookie('baseball')) {
        var read_baseball = $.cookie('baseball');
        var save_baseball = read_baseball.split(/\,/g);
        fav_baseball = save_baseball;
        cookies('baseball');
    }
    if ($.cookie('handball')) {
        var read_handball = $.cookie('handball');
        var save_handball = read_handball.split(/\,/g);
        fav_handball = save_handball;
        cookies('handball');
    }
    if ($.cookie('football')) {
        var read_football = $.cookie('football');
        var save_football = read_football.split(/\,/g);
        fav_football = save_football;
        cookies('football');
    }

    //TODO ROBERT active1
    if ($.cookie('m_' + cur_sport) != '') {
        set_m_active = $.cookie('m_' + cur_sport);
        $('#col1 ul li ul li').filter('#' + set_m_active).addClass('active').children().eq(0).css('background', 'none');
    }
}

function rem_from_fav(this_) {
    replace = $(this_).attr('src').replace('rem', 'add');
    $(this_).attr('src', replace);
    get_count = get_count - 1;
    $('.selected_counter').text(get_count);
    $(this_).parent().parent().removeClass('my_matches');

    fav_id = $(this_).parent().parent().attr('id');
    var ind = $.inArray(fav_id, sport_tab);

    if (ind != -1)
        sport_tab.splice(ind, 1);

    $.unique(sport_tab);
    fav_val = sport_tab.join(',');

    $.cookie(cur_sport, fav_val, {
        expires: 7,
        path: '/',
        domain: ''
    });
}

function add_to_fav(this_) {
    replace = $(this_).attr('src').replace('add', 'rem');
    $(this_).attr('src', replace);

    get_count = get_count + 1;
    $('.selected_counter').text(get_count);
    $(this_).parent().parent().addClass('my_matches');

    fav_id = $(this_).parent().parent().attr('id');
    fav_m_tab_length = sport_tab.length;
    sport_tab[fav_m_tab_length] = fav_id;
    $.unique(sport_tab);
    fav_val = sport_tab.join(',');

    $.cookie(cur_sport, fav_val, {
        expires: 7,
        path: '/',
        domain: ''
    });
}

function count() {
    $('#countdown').countDown({
        targetDate: {
            'day': day,
            'month': month_nr + 1,
            'year': year,
            'hour': draw_h,
            'min': 0,
            'sec': 0
        },
        onComplete: function() {
            day = day + 1;
            count();
        }
    });
}


function get_my_matches(sport_name) {
    $.ajax({
        url: direct_url + "/" + sport_name + "/my_matches/",
        success: function(data) {
            $("#dynamic_data").html(data);
            $('.no_found_m').hide();
            check_cookies();
            if ($('#dynamic_data .no_found').length > 0) {
                $('#sort_not_found').addClass('hide');
            }
        }
    });
    setTimeout(function() {
        get_my_matches(sport_name);
    }, 80000);
    $('.tooltip').remove();

}


function get_param_from_url(name) {
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results != null) {
        return results[1];
    }
    return null;
}

// pokazywanie meczów z wybranym statusem - zakończone lub trwające
function showMatches(sort) {
    $matchesTab.find('td.td_date span.status').not('.' + sort).closest('tr').hide(); // znajdź wszystkie TR, które mają być ukryte i ukryj je
    $matchesTab.each(function() {
        var $this = $(this);
        if ($this.find('tr:visible').length === 0) { // sprawdzanie czy jakieś tabele zostały w całości ukryte. Jeśli tak to kryj też nagłówek ligi.
            $this.prev('.league_header_bar').hide();
        }
    });
}
//end pokazywanie meczów z wybranym statusem - zakończone lub trwające