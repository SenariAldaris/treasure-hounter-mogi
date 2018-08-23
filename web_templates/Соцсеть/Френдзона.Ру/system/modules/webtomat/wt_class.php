<?php

class Wt
{

    var $wt_query = '';
    var $wt_result = array();
    var $genres_arr = array();
    var $arr_tag_en = array();
    var $arr_tag_rus = array();
    var $arr_genre_en = array();
    var $arr_genre_rus = array();
    var $arr_top_games = array();
	var $wt_dir='';

    function __construct ()
    {
        
		if (empty($this->arr_tag_en) and empty($this->arr_tag_rus) and empty($this->arr_genre_en) and empty($this->arr_genre_rus)) {
            WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtnames");
            while ($row = WebTomat_Data::wt_getrow()) {
                if ($row['type'] == 'tag') {
                    $this->arr_tag_en[] = $row['en_name'];
                    $this->arr_tag_rus[] = $row['rus_name'];
                }
                elseif ($row['type'] == 'genre') {
                    $this->arr_genre_en[] = $row['en_name'];
                    $this->arr_genre_rus[] = $row['rus_name'];
                }
            }
        }
        $genres_arr = $this->genres_arr;
        if (empty($genres_arr)) {
            WebTomat_Data::wt_mysql("SELECT DISTINCT en_name FROM " . WEBTOMAT_PREF . "wtnames WHERE type='genre' ORDER BY in_count DESC");
            while ($row = WebTomat_Data::wt_getrow()) {
                $genres_arr[] = $row['en_name'];
            }
            $this->genres_arr = $genres_arr;
        }
    }

    function globper ($a)
    {

        if (isset($_REQUEST[$a])) {
            $per = $_REQUEST[$a];
            $per = trim($per);
            $per = htmlspecialchars($per);
            return $per;
        }
        else {
            return null;
        }
    }

    function wt_menu_sel ($x, $z)
    {

        $s = $this->globper($x);

        if (isset($s) and $s == $z)
            return ' class="active"';
        else
            return '';
    }

    function wt_slider ($str)
    {
        $str = stripslashes($str);
		
        $slider = '';
        if (strpos($str, "[cont2=slider]") !== false)
            preg_match("#\\[cont2=slider\\](.*?)\\[/cont2\\]#is", $str, $slid_matches);

        WebTomat_Data::wt_mysql("SELECT wtg_apppath,wtg_name,wtg_img120,wtg_id,wtg_title FROM " . WEBTOMAT_PREF . "wtgames ORDER BY wtg_popular DESC limit 20");
        while ($row = WebTomat_Data::wt_getrow()) {
		
//* Q=webtomat *//
		
            $wt_href_slid = $wt_dir.'ingame='.$row['wtg_id'];
            $replace = array(
                '{wtg_title}' => $row['wtg_title'],
                '{wt_href_slid}' => $wt_href_slid,
                '{wt_href_slidimg}' => $row['wtg_apppath'].'/'.$row['wtg_name'].'_m_old.'.$row['wtg_img120']
            );
            $slider .= strtr($slid_matches[1], $replace);
        }

        if (strpos($str, "[cont2=slider]") !== false)
            $str = preg_replace("#\\[cont2=slider\\](.*?)\\[/cont2\\]#is", $slider, $str);

        return $str;
    }

    function wt_blocksort ($str)
    {
        $str = stripslashes($str);

        $ingenre    = $this->globper('ingenre');
        $intag      = $this->globper('intag');
        $cat        = $this->globper('cat');
        $search     = $this->globper('search');

        if ($this->globper('sort') == null) $_REQUEST['sort'] = isset($cat) ? $cat : 'pop';

        if (isset($cat))
            $wt_urlnow = 'cat=' . $cat;
        elseif (isset($ingenre))
            $wt_urlnow = 'ingenre=' . $ingenre;
        elseif (isset($intag))
            $wt_urlnow = 'intag=' . $intag;
        elseif (isset($search))
            $wt_urlnow = 'search=' . $search;
			
//* Q=webtomat *//
			
        $wt_urlnow = $wt_dir.'' . $wt_urlnow;

        $replace = array(
            '{wt_href_sortn}'   => $wt_urlnow.'&sort=new',
            '{wt_href_sortp}'   => $wt_urlnow.'&sort=pop',
            '{wt_sort_new}'     => $this->wt_menu_sel('sort', 'new'),
            '{wt_sort_pop}'     => $this->wt_menu_sel('sort', 'pop')
        );
        $str = strtr($str, $replace);

        return $str;
    }

    function wt_gameblock ($str)
    {
        $str = stripslashes($str);

        $ingenre = $this->globper('ingenre');
        $intag = $this->globper('intag');
        $cat = $this->globper('cat');
        $search = $this->globper('search');
        $p = $this->globper('p');

        if ($this->globper('sort') == null) $_REQUEST['sort'] = isset($cat) ? $cat : 'pop';

        $start = (!isset($p) or empty($p)) ? 0 : $p;

        $b_sort = $this->wt_sort('sort');

        if (isset($cat)) {

            $b_sort = $this->wt_sort('cat');
            $b_ingenres = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames ORDER BY {$b_sort} limit $start, 20");

            $start = $start + 20;
            $count_last = WebTomat_Data::wt_mysql("SELECT id FROM " . WEBTOMAT_PREF . "wtgames limit $start, 20");

        } elseif (isset($ingenre)) {

            $ingenre = WebTomat_Data::wt_safesql($ingenre);

            $b_ingenres = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_genres LIKE '%{$ingenre}%' ORDER BY {$b_sort} limit $start, 20");

            $start = $start + 20;
            $count_last = WebTomat_Data::wt_mysql("SELECT id FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_genres LIKE '%{$ingenre}%' limit $start, 20");

        } elseif (isset($intag)) {

            $intag = WebTomat_Data::wt_safesql($intag);

            $this->krosh_text = WebTomat_Data::$lang['wt_all_tags'];
            $this->krosh_link = 'a=tags';

            $b_sort = $this->wt_sort('sort');
            $b_ingenres = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_tags LIKE '%{$intag}%' ORDER BY {$b_sort} limit $start, 20");

            $start = $start + 20;
            $count_last = WebTomat_Data::wt_mysql("SELECT id FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_tags LIKE '%{$intag}%' limit $start, 20");

        } elseif (isset($search)) {

            $search = WebTomat_Data::wt_safesql($search);

            $b_sort = $this->wt_sort('sort');
            $b_ingenres = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_name LIKE '%{$search}%' OR wtg_title LIKE '%{$search}%' OR wtg_desc LIKE '%{$search}%' ORDER BY {$b_sort} limit $start, 20");

            $start = $start + 20;
            $count_last = WebTomat_Data::wt_mysql("SELECT id FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_name LIKE '%{$search}%' OR wtg_title LIKE '%{$search}%' OR wtg_desc LIKE '%{$search}%' limit $start, 20");
            $count_all = WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_name LIKE '%{$search}%' OR wtg_title LIKE '%{$search}%' OR wtg_desc LIKE '%{$search}%'");

        }

        $game_block = '';

        if (strpos($str, "[var=searchfalse]") !== false) {
            preg_match("#\\[var=searchfalse\\](.*?)\\[/var\\]#is", $str, $sf_matches);
            $str = preg_replace("#\\[var=searchfalse\\](.*?)\\[/var\\]#is", "", $str);
        }
        if (strpos($str, "[var=gonext]") !== false) {
            preg_match("#\\[var=gonext\\](.*?)\\[/var\\]#is", $str, $gn_matches);
            $str = preg_replace("#\\[var=gonext\\](.*?)\\[/var\\]#is", "", $str);
        }
        if (strpos($str, "[cont2=top_img]") !== false)
            preg_match("#\\[cont2=top_img\\](.*?)\\[/cont2\\]#is", $str, $imgp_matches);
        if (strpos($str, "[cont2=new_img]") !== false)
            preg_match("#\\[cont2=new_img\\](.*?)\\[/cont2\\]#is", $str, $imgn_matches);

        if (WebTomat_Data::wt_numrow($b_ingenres) > 0) {

            while ($row = WebTomat_Data::wt_getrow($b_ingenres)) {

                $n = !isset($n) ? 1 : $n + 1;

                $game_name_en = $row['wtg_name'];

                $tagname_rus = $this->wt_gametags($str, $row['wtg_tags'], 3);

                $img100 = $row['wtg_apppath'] . '/' . $game_name_en . '_c_old.' . $row['wtg_img75'];

                $game_name_rus = $row['wtg_title'];
				$game_desc = $row['wtg_desc'];
                
                $new_img = $top_img = '';
                if ($_REQUEST['sort'] == 'pop') {
                    $cnpb = WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_popular > '{$row['wtg_popular']}' limit 100");
                    $cnp = WebTomat_Data::wt_getrow($cnpb);
                    if ($cnp['count'] < 100)
                        $top_img = $imgp_matches[1];
                    else
                        $top_img = '';
                } else {
                    $cnnb = WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_new < '{$row['wtg_new']}' limit 20");
                    $cnn = WebTomat_Data::wt_getrow($cnnb);
                    if ($cnn['count'] < 20)
                        $new_img = $imgn_matches[1];
                    else
                        $new_img = '';
                }

                if (mb_strlen($game_desc, 'UTF-8') > 60)
                    $game_desc = mb_substr($game_desc, 0, 60, 'UTF-8') . '...';

                if (isset($search)) {

                    $game_desc = $this->wt_search_colorize($game_desc, $search);
                    $game_name_rus = $this->wt_search_colorize($game_name_rus, $search);

                }

                if (!empty($new_img) or !empty($top_img))
                    $wt_div_intitle = 'class="wt_title_min"';
                else
                    $wt_div_intitle = '';

                $game_id = $row['wtg_id'];

                if ($n % 2 != 0)
                    $game_list_2 = ' game_list_2';
                else
                    $game_list_2 = '';


                $replace = array(
                    '{img100}' => $img100,
                    '{game_name_rus}' => $game_name_rus,
                    '{game_desc}' => $game_desc,
                    '{wt_div_intitle}' => $wt_div_intitle,
                    '{wt_item_bg}' => $game_list_2,
					
//* Q=webtomat *//
					
                    '{wt_href_ingame}' => $wt_dir.'ingame='.$game_id
                );
                $game_block .= strtr($str, $replace);

                if (strpos($game_block, "[cont2=tagname_rus]") !== false)
                    $game_block = preg_replace("#\\[cont2=tagname_rus\\](.*?)\\[/cont2\\]#is", $tagname_rus, $game_block);
                if (strpos($game_block, "[cont2=top_img]") !== false)
                    $game_block = preg_replace("#\\[cont2=top_img\\](.*?)\\[/cont2\\]#is", $top_img, $game_block);
                if (strpos($game_block, "[cont2=new_img]") !== false)
                    $game_block = preg_replace("#\\[cont2=new_img\\](.*?)\\[/cont2\\]#is", $new_img, $game_block);

            }

            if (isset($search) and (strpos($gn_matches[1], "[cont2=search_all]") !== false)) {
                $row_all = WebTomat_Data::wt_getrow($count_all);
                $ca = $row_all['count'];
                $replace = array(
                    '{count_all}' => $ca,
                    '{wt_game_words_all}' => $this->wt_words($ca),
                    '{wt_search}' => $search
                );
                $gn_matches[1] = preg_replace("#\\[cont2=search_all\\](.*?)\\[/cont2\\]#is", "\\1", $gn_matches[1]);
                $gn_matches[1] = strtr($gn_matches[1], $replace);
            } else {
                $gn_matches[1] = preg_replace("#\\[cont2=search_all\\](.*?)\\[/cont2\\]#is", "", $gn_matches[1]);
            }
            $count = WebTomat_Data::wt_numrow($count_last);
            if ($count > 0) {
                $replace = array(
                    '{count}' => $count,
                    '{wt_game_words}' => $this->wt_words($count)
                );
                $gn_matches[1] = preg_replace("#\\[cont2=count\\](.*?)\\[/cont2\\]#is", "\\1", $gn_matches[1]);
                $gn_matches[1] = strtr($gn_matches[1], $replace);
            } else {
                $gn_matches[1] = preg_replace("#\\[cont2=count\\](.*?)\\[/cont2\\]#is", "", $gn_matches[1]);
            }
			
            $game_block .= $gn_matches[1];

        } else {

            if (isset($search)) {
                $replace = array('{wt_search}' => $search);
                $game_block .= strtr($sf_matches[1], $replace);
            }

        }

        return $game_block;

    }

    function tags ($str)
    {
        $str = stripslashes($str);
        $a = '';

        $arr_strTags = explode('{wt_SPLIT}', $str);

        $tags_rus = $this->arr_tag_rus;
        $n = 0;
        $simbols = array();
        sort($tags_rus);
        $a .= $arr_strTags[0];
        $td = count($tags_rus) / 4;
        foreach ($tags_rus as $tag) {
            $n++;
            if ($n > $td) {
                $a .= $arr_strTags[1];
                $n = 0;
            }
            if (WEBTOMAT_DECODE == "utf-8")
                $simbols[$n] = substr($tag, 0, 1);
            else
                $simbols[$n] = mb_substr($tag, 0, 1, 'UTF-8');
            if (!isset($simbols[$n - 1]) or ($simbols[$n - 1] !== $simbols[$n])) {
                $a .= str_replace('{wt_simbols_n}', $simbols[$n], $arr_strTags[2]);
            }
            $wt_tag_en = $this->arr_tag_en[array_search($tag, $this->arr_tag_rus)];
            $replace = array(
			
//* Q=webtomat *//
			
                '{wt_href_tags}' => $wt_dir.'intag='.$wt_tag_en,
                '{wt_tag_rus}' => $tag
            );
            $a .= strtr($arr_strTags[3], $replace);
        }
        $a .= $arr_strTags[4];

        return $a;

    }

    function wt_reating ($str)
    {
        $str = stripslashes($str);
		$ingame = $this->globper('ingame');
		
        if (isset($ingame) and !empty($ingame)) {

            WebTomat_Data::wt_mysql("SELECT wtg_popular FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_id='{$ingame}' limit 1");
            $row = WebTomat_Data::wt_getrow();

            $game_popular = $row['wtg_popular'];

            $wt_uv = 'true';

            session_start();

            if (isset($_SESSION['wt_id']) and !empty($_SESSION['wt_id'])) {
                $wt_id = $_SESSION['wt_id'];
                WebTomat_Data::wt_mysql("SELECT id,games_id FROM " . WEBTOMAT_PREF . "wtusrate WHERE user_id='{$wt_id}' LIMIT 1");
                if (WebTomat_Data::wt_numrow() > 0) {
                    $row = WebTomat_Data::wt_getrow();
                    $arr_ids = explode(',', $row['games_id']);
                    if (!in_array($ingame, $arr_ids)) {
                        $wt_uv = 'false';
                    }
                } else
                    $wt_uv = 'false';
            }
            $rate_percent = round($game_popular / 0.05);
            if ($rate_percent > 100) $rate_percent = 100;

            $star_pos = -20;
            $reating_str = '';

            if (strpos($str, "[cont2=reating_str]") !== false)
                preg_match("#\\[cont2=reating_str\\](.*?)\\[/cont2\\]#ies", $str, $matches);

            for ($i = 0; $i < 5; $i++) {
                $star_pos = $star_pos + 19;
                $replace = array(
                    '{star_pos}' => $star_pos,
                    '{n}' => $i + 1
                );
                $reating_str .= strtr($matches[1], $replace);
            }

            if (strpos($str, "[cont2=reating_str]") !== false)
                $str = preg_replace("#\\[cont2=reating_str\\](.*?)\\[/cont2\\]#ies", "\$reating_str", $str);

            $replace = array(
                '{wt_uv}' => $wt_uv,
                '{rate_percent}' => $rate_percent
            );
            $str = strtr($str, $replace);

        }

        return $str;
    }

    function main ($str)
    {
        $str = stripslashes($str);
        $genres_arr = $this->genres_arr;
        $a = '';

        for ($i = 0; $i < count($genres_arr); $i++) {
            $genre = $genres_arr[$i];
            $a .= $this->wt_genre_block($genre, $str);
        }

        return $a;

    }

    function wt_gbs2 ($str)
    {
        $str = stripslashes($str);
        $genres_arr = $this->genres_arr;
        $a = '';
        $is = array();

        for ($i = 0; $i < 2; $i++) {
            $genre = $genres_arr[array_rand($genres_arr)];
            if (!in_array($genre, $is)) {
				if ($i == 1) $sn = true;
				else $sn = false;
                $is[] = $genre;
                $a .= $this->wt_genre_block($genre, $str, $sn);
            } else {
                $i--; continue; }
        }

        return $a;

    }

    function wt_genre_block ($genre, $str, $sn = false)
    {
        $ingame     = $this->globper('ingame');

        $count = 0;
        $most_popular = '';
        $a = '';
		$new_img = '';
		$pop_img = '';

        if (strpos($str, "[cont2=most_popular]") !== false)
            preg_match("#\\[cont2=most_popular\\](.*?)\\[/cont2\\]#ies", $str, $pop_matches);
        
        $wt_game = WebTomat_Data::wt_mysql("SELECT wtg_id,wtg_name,wtg_apppath,wtg_img100,wtg_title,wtg_desc,wtg_tags,wtg_img16,wtg_new,wtg_popular FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_genres LIKE '%{$genre}%' ORDER BY wtg_popular DESC limit 5");

        if (WebTomat_Data::wt_numrow($wt_game) > 0) {
            while ($row = WebTomat_Data::wt_getrow($wt_game)) {

                $count++;

                if ($count == 1) {

                    if ( isset($ingame) and $sn ){
                        WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_genres LIKE '%{$genre}%' ORDER BY wtg_new limit 1");
                        $row = WebTomat_Data::wt_getrow();
                        @mysql_data_seek($wt_game,0);
                    }
                    $cnb = WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_new < '{$row['wtg_new']}' limit 20");
                    $cn = WebTomat_Data::wt_getrow($cnb);
                    if ( $cn['count'] < 20) {
                        $new_img = '\\1';
                        $pop_img = '';
                    } else {
                        $new_img = '';
                        $cpb = WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_popular > '{$row['wtg_popular']}' limit 100");
                        $cp = WebTomat_Data::wt_getrow($cpb);
                        if ($cp['count'] < 100)
                            $pop_img = '\\1';
                        else
                            $pop_img = '';
                    }

                    if (in_array($row['wtg_id'],$this->arr_top_games)){
                        $count--;
                        continue;
                    } else
                        $this->arr_top_games[] = $row['wtg_id'];
                    $game_id = $row['wtg_id'];
                    $game_name_en = $row['wtg_name'];

                    $top_game_img = $row['wtg_apppath'] . '/' . $game_name_en . '_c1.' . $row['wtg_img100'] . '';

                    $top_game_name = $row['wtg_title'];

                    $top_game_desc = $row['wtg_desc'];

                    $tagname_rus = $this->wt_gametags($str, $row['wtg_tags'], 3);

                }
                elseif ($count <= 7) {

                    $game_name = $row['wtg_title'];

                    $n = !isset($n) ? 0 : $n + 1;
                    $class_a2 = !isset($class_a2) ? '' : $class_a2;
                    if ($n % 2 == 0)
                        $class_a2 = empty($class_a2) ? ' class="game_a_2"' : '';


                    $replace = array(
                        '{wtg_img16}' => $row['wtg_apppath'].'/'.$row['wtg_name'].'_vs.'.$row['wtg_img16'],
                        '{wtg_mp_class}' => $class_a2,
						
//* Q=webtomat *//
						
                        '{wt_href_gbmostp}' => $wt_dir.'ingame='.$row['wtg_id'],
                        '{game_name}' => $game_name
                    );

                    $most_popular .= strtr(stripcslashes($pop_matches[1]), $replace);

                } else
                    break;
            }
        } else return '';
        $res = WebTomat_Data::wt_mysql("SELECT COUNT(*) FROM ". WEBTOMAT_PREF . "wtgames WHERE wtg_genres LIKE '%{$genre}%'");
		while ($row = WebTomat_Data::wt_getrow($res)) $count = $row['COUNT(*)'];

        if (strpos($str, "[cont2=tagname_rus]") !== false)
            $str = preg_replace("#\\[cont2=tagname_rus\\](.*?)\\[/cont2\\]#is", $tagname_rus, $str);
        if (strpos($str, "[cont2=most_popular]") !== false)
            $str = preg_replace("#\\[cont2=most_popular\\](.*?)\\[/cont2\\]#is", $most_popular, $str);
		if (strpos($str, "[cont2=new_img]") !== false)
			$str = preg_replace("#\\[cont2=new_img\\](.*?)\\[/cont2\\]#is", $new_img, $str, 1);
		if (strpos($str, "[cont2=pop_img]") !== false)
			$str = preg_replace("#\\[cont2=pop_img\\](.*?)\\[/cont2\\]#is", $pop_img, $str, 1);

        $genrename_rus = $this->arr_genre_rus[array_search($genre, $this->arr_genre_en)];

        $replace = array(
		
//* Q=webtomat *//
		
            '{wt_href_genre}' => $wt_dir.'ingenre='.$genre,
            '{count}' => $count,
            '{genrename_rus}' => $genrename_rus,
            '{top_game_img}' => $top_game_img,
            '{game_name_en}' => $game_name_en,
            '{top_game_name}' => $top_game_name,
            '{top_game_desc}' => $top_game_desc,
			
//* Q=webtomat *//
			
            '{wt_href_gbingame}' => $wt_dir.'ingame='.$game_id
        );
        $a .= strtr($str, $replace);

        return $a;

    }

    function wt_kroshki ($str)
    {
        $a          = $this->globper('a');
        $ingenre    = $this->globper('ingenre');
        $intag      = $this->globper('intag');
        $ingame     = $this->globper('ingame');
        $cat        = $this->globper('cat');
        $search     = $this->globper('search');

        if (isset($intag)) {
            $this->krosh_link = 'a=tags';
            $this->krosh_text = WebTomat_Data::$lang['wt_all_tags'];
            $genre_rus = $this->arr_tag_rus[array_search($intag, $this->arr_tag_en)];
        }
        elseif (isset($a) and $a == 'tags')
            $genre_rus = WebTomat_Data::$lang['wt_all_tags'];
        elseif (isset($a) and $a == 'main')
            $str = '';
        elseif (isset($ingenre))
            $genre_rus = $this->arr_genre_rus[array_search($ingenre, $this->arr_genre_en)];
        elseif (isset($ingame)) {
            $ingame = WebTomat_Data::wt_safesql($ingame);
            WebTomat_Data::wt_mysql("SELECT wtg_title,wtg_genres FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_id='{$ingame}' LIMIT 1");
            $row = WebTomat_Data::wt_getrow();
            $genre_rus = $row['wtg_title'];
            $this->krosh_text = $this->arr_genre_rus[array_search($row['wtg_genres'], $this->arr_genre_en)];
            $this->krosh_link = 'ingenre=' . $row['wtg_genres'];
        }
        elseif (isset($cat)) {
            switch ($cat) {
                case 'new' :
                    $genre_rus = 'Новое';
                    break;
                case 'pop' :
                    $genre_rus = 'Интересное';
                    break;
                default :
                    $genre_rus = '';
            }
            if (WEBTOMAT_DECODE == "utf-8") {
                $genre_rus = iconv('UTF-8', 'utf-8', $genre_rus);
            }
        }
        elseif (isset($search)) {
            $genre_rus = 'Результаты поиска по запросу';
            if (WEBTOMAT_DECODE == "utf-8") {
                $genre_rus = iconv('UTF-8', 'utf-8', $genre_rus);
            }
            $genre_rus .= ' "' . $search . '"';
        }


        $str = stripslashes($str);
        if (isset($genre_rus)) $str = str_replace('{krosh_rus}', $genre_rus, $str);
        if (isset($this->krosh_link) and isset($this->krosh_text)) {

            $replace = array(
			
//* Q=webtomat *//
			
                '{wt_href_krosh}' => $wt_dir.''.$this->krosh_link,
                '{krosh_text}' => $this->krosh_text
            );
            $str = $this->wt_searchReplace($str, 'cont2=krosh', $replace);

        } else {
            if (strpos($str, "[cont2=krosh]") !== false)
                $str = preg_replace("#\\[cont2=krosh\\](.*?)\\[/cont2\\]#i", "", $str);
        }

        return $str;
    }

    function wt_ingame ($str, $ingame)
    {
        WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_id='{$ingame}' limit 1");
        $row = WebTomat_Data::wt_getrow();

        $img200 = $row['wtg_apppath'] . '/' . $row['wtg_name'] . '_l.' . $row['wtg_img200'];

        $this->krosh_link = $row['wtg_genres'];
        $this->krosh_text = $this->arr_genre_rus[array_search($row['wtg_genres'], $this->arr_genre_en)];

        $game_desc = $row['wtg_desc'];

        $tagname_rus = $this->wt_gametags($str, $row['wtg_tags'], 99);
        if (strpos($str, "[cont2=tagname_rus]") !== false)
            $str = preg_replace("#\\[cont2=tagname_rus\\](.*?)\\[/cont2\\]#ies", "\$tagname_rus", $str, 1);

        $game_name_rus = $row['wtg_title'];
        $this->game_name_rus = $game_name_rus;

        $wt_game_width = $row['wtg_width'];
        $wt_game_height = $row['wtg_height'];

        $game_popular = $row['wtg_popular'];

        WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_popular > '{$row['wtg_popular']}' limit 100");
        $rowpop = WebTomat_Data::wt_getrow();
        if ($rowpop['count'] < 100)
            $str = preg_replace("#\\[cont2=top_img\\](.*?)\\[/cont2\\]#is", "\\1", $str);
        else
            $str = preg_replace("#\\[cont2=top_img\\](.*?)\\[/cont2\\]#is", "", $str);

        WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_new < '{$row['wtg_new']}' limit 20");
        $rownew = WebTomat_Data::wt_getrow();
        if ($rownew['count'] < 20)
            $str = preg_replace("#\\[cont2=new_img\\](.*?)\\[/cont2\\]#is", "\\1", $str, 1);
        else
            $str = preg_replace("#\\[cont2=new_img\\](.*?)\\[/cont2\\]#is", "", $str, 1);

        $replace = array(
            '{game_name_rus}' => $game_name_rus,
            '{game_desc}' => preg_replace("(\r\n|\n|\r)", "", $game_desc),
            '{img200}' => $img200
        );
        $str = $this->wt_searchReplace($str, 'var=src', $replace);

        $wt_rnum = '';
        for ($i = 0; $i < 5; $i++) {
            $wt_rnum .= rand(0, 9);
        }

        global $wt_webid,$wt_mainpage;
        $replace = array(
            '{game_name_rus}' => $game_name_rus,
            '{img200}' => $img200,
            '{game_desc}' =>$game_desc,
            '{ingame}' => $ingame,
            '{webid}' => $wt_webid,
			'{mainpage}' => $wt_mainpage,
            '{wt_game_width}' => $wt_game_width,
            '{wt_game_height}' => $wt_game_height,
            '{wt_rnum}' => $wt_rnum
        );
        $str = strtr($str, $replace);

        return $str;
    }

    function wt_menu ($str)
    {
        $str = stripslashes($str);
        $genres_arr = $this->genres_arr;
        sort($genres_arr);
        $wt_genre = '';

        if (strpos($str, "[cont2=genre]") !== false)
            preg_match("#\\[cont2=genre\\](.*?)\\[/cont2\\]#ies", $str, $matches);

        for ($i = 0; $i < count($genres_arr); $i++) {
            $genre = $genres_arr[$i];
            $genre_rus = $this->arr_genre_rus[array_search($genre, $this->arr_genre_en)];
            $replace = array(
                '{genre_rus}' => $genre_rus,
				
//* Q=webtomat *//
				
                '{wt_href_mg}' => $wt_dir."ingenre=".$genre,
                '{wt_menu_sel_ingenre}' => $this->wt_menu_sel('ingenre', $genre)
            );
            $wt_genre .= strtr($matches[1], $replace);
        }

        if (strpos($str, "[cont2=genre]") !== false)
            $str = preg_replace("#\\[cont2=genre\\](.*?)\\[/cont2\\]#ies", "\$wt_genre", $str);

        $replace = array(
		
//* Q=webtomat *//
		
            '{wt_href_mn}' => $wt_dir."cat=new",
            '{wt_menu_sel_new}' => $this->wt_menu_sel('cat', 'new')
        );

        $str = strtr($str, $replace);

        return $str;
    }

    function wt_search ()
    {
        $a = file_get_contents(WEBTOMAT_DIR . '/themes/Old/wt_searchblock.tpl');
        return $a;
    }

    function wt_sort ($z)
    {

        $a = $this->globper($z);
        if (isset($a)) {
            switch ($a) {
                case 'new' :
                    $b = 'wtg_new ASC';
                    break;
                case 'pop' :
                    $b = 'wtg_popular DESC';
                    break;
                default :
                    $b = 'wtg_popular DESC';
            }
        } else {
            $b = 'wtg_popular DESC';
        }
        return $b;
    }

    function wt_search_colorize ($str, $search)
    {
        if (WEBTOMAT_DECODE == "utf-8") {
            $str_lower = strtolower($str);
            $search = strtolower($search);
        } else {
            $str_lower = mb_strtolower($str, 'UTF-8');
            $search = mb_strtolower($search, 'UTF-8');
        }

        $ss = strpos($str_lower, $search);
        $len = strlen($search);

        if ($ss !== false)
            $str = substr_replace($str, '<span style="color:red">' . substr($str, $ss, $len) . '</span>', $ss, $len);

        return $str;
    }

    function wt_addVote ($id, $rate)
    {
        WebTomat_Data::wt_mysql("SELECT wtg_popular,wtg_votes FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_id='{$id}' LIMIT 1");
        $row = WebTomat_Data::wt_getrow();
        $new_rate = round(($row['wtg_popular'] * $row['wtg_votes'] + $rate) / ($row['wtg_votes'] + 1), 2);
        $new_rate = str_replace(',', '.', $new_rate);
        WebTomat_Data::wt_mysql("UPDATE " . WEBTOMAT_PREF . "wtgames SET wtg_popular={$new_rate}, wtg_votes=wtg_votes + 1 WHERE wtg_id='$id' ");

        return $new_rate;
    }

    function wt_sessWtId ($wt_id)
    {
        if (!session_name()) {
            session_start();
        }

        if ($wt_id == 'logout') {
            unset($_SESSION['wt_id']);
        } else {
            $wt_id_hash = md5($wt_id);
            $_SESSION['wt_id'] = $wt_id_hash;
        }

        return ( isset($_SESSION['wt_id']) and !empty($_SESSION['wt_id']) ) ? 'ok' : 'error';
    }

    function wt_rate ($rate, $ingame, $wt_id)
    {
        $rate = WebTomat_Data::wt_safesql($rate);
        $ingame = WebTomat_Data::wt_safesql($ingame);
        $wt_id = md5($wt_id);

        $msg = '';

        WebTomat_Data::wt_mysql("SELECT id,games_id FROM " . WEBTOMAT_PREF . "wtusrate WHERE user_id='{$wt_id}' LIMIT 1");
        if (WebTomat_Data::wt_numrow() > 0) {
            $row = WebTomat_Data::wt_getrow();
            $arr_ids = explode(',', $row['games_id']);
            if (!in_array($ingame, $arr_ids)) {
                unset($arr_ids[count($arr_ids) - 1]);
                $arr_ids[] = $ingame;
                $d = implode(",", $arr_ids) . ',';

                WebTomat_Data::wt_mysql("UPDATE " . WEBTOMAT_PREF . "wtusrate SET games_id='{$d}' WHERE id='{$row['id']}'");

                $msg = $this->wt_addVote($ingame, $rate);
            }
        } else {

            WebTomat_Data::wt_mysql("INSERT INTO " . WEBTOMAT_PREF . "wtusrate ( user_id, games_id ) VALUES ( '{$wt_id}','{$ingame}' )");

            $msg = $this->wt_addVote($ingame, $rate);
        }

        return $msg;
    }

    function wt_searchReplace ($str, $var, $arr)
    {
        $z = explode('=', $var);
        if (strpos($str, "[" . $var . "]") !== false)
            preg_match("#\\[" . $var . "\\](.*?)\\[/" . $z[0] . "\\]#ies", $str, $matches);

        $a = strtr($matches[1], $arr);

        if (strpos($str, "[" . $var . "]") !== false)
            $str = preg_replace("#\\[" . $var . "\\](.*?)\\[/" . $z[0] . "\\]#ies", "\$a", $str);

        return $str;

    }

    function wt_gametags ($tpl, $tags, $num)
    {
        if (strpos($tpl, "[cont2=tagname_rus]") !== false)
            preg_match("#\\[cont2=tagname_rus\\](.*?)\\[/cont2\\]#is", $tpl, $matches);

        $arr_tags = explode(',', $tags);
        $tagname_rus = '';
        $n = 0;
        $tgn = '';

        foreach ($arr_tags as $tag) {
            if ($num != 99)
                if (WEBTOMAT_DECODE == "utf-8")
                    $a = strlen($tgn) < 20 ? true : false;
                else
                    $a = mb_strlen($tgn, 'UTF-8') < 20 ? true : false;
            else
                $a = true;

            if ($n < $num and $a) {
                $n++;
                $tgr = $this->arr_tag_rus[array_search($tag, $this->arr_tag_en)];
                $replace = array(
				
//* Q=webtomat *//
				
                    '{wt_href_tag}' => $wt_dir.'intag='.$tag,
                    '{tgr}' => $tgr
                );
                $tagname_rus .= strtr($matches[1], $replace);
                $tgn .= $tgr . ', ';
            }
            else break;
        }
        unset($tpl, $tags, $num, $matches, $tgn, $arr_tags, $tgr);
        if (WEBTOMAT_DECODE == "utf-8") {
            $tagname_rus = substr($tagname_rus, 0, strlen($tagname_rus) - 1);
        } else {
            $tagname_rus = mb_substr($tagname_rus, 0, mb_strlen($tagname_rus, 'UTF-8') - 1, 'UTF-8');
        }

        return $tagname_rus;
    }

    function wt_words ($cnt)
    {
        $words = array("игра", "игры", "игр");
        $cases = array(2, 0, 1, 1, 1, 2);
        $word = $words[($cnt % 100 > 4 && $cnt % 100 < 20) ? 2 : $cases[min($cnt % 10, 5)]];
        if (WEBTOMAT_DECODE == "utf-8") {
            $word = iconv("UTF-8", "utf-8", $word);
        }
        return $word;
    }

    function wt_meta ($teg)
    {
        $a          = $this->globper('a');
        $ingenre    = $this->globper('ingenre');
        $intag      = $this->globper('intag');
        $ingame     = $this->globper('ingame');
        $cat        = $this->globper('cat');
        $search     = $this->globper('search');

        $title = '';

        if ($a == 'main') {
            $title .= WebTomat_Data::$lang['wt_catalog'];
        }
        elseif ($a == 'tags') {
            $title .= WebTomat_Data::$lang['wt_all_tags'];
        }
        elseif (isset($ingenre)) {
            $title .= WebTomat_Data::$lang['wt_genre'] . ' "' . $this->arr_genre_rus[array_search($ingenre, $this->arr_genre_en)] . '"';
        }
        elseif (isset($intag)) {
            $title .= WebTomat_Data::$lang['wt_tag'] . ' "' . $this->arr_tag_rus[array_search($intag, $this->arr_tag_en)] . '"';
        }
        elseif (isset($cat)) {
            if ($cat == 'new')
                $title .= WebTomat_Data::$lang['wt_cat_new'];
            elseif ($cat == 'pop')
                $title .= WebTomat_Data::$lang['wt_cat_pop'];
        }
        elseif (isset($search)) {
            $title .= WebTomat_Data::$lang['wt_search_result'] . ' "' . $search . '"';
        }
        elseif (isset($ingame)) {
            if (isset($this->game_name_rus))
                $title .= $this->game_name_rus;
            else {
                $b = WebTomat_Data::wt_mysql("SELECT wtg_title FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_id = '$ingame' limit 1");
                $r = WebTomat_Data::wt_getrow($b);
                $this->game_name_rus = $r['wtg_title'];
                $title .= $r['wtg_title'];
            }
        }

//* $Title .= ' - '; *//

        if ($teg == 'title')
            return $title;
    }
	static public function main2 ($str,$genre_href)
    {
        $str = stripslashes($str);

        $a = '';

        $wt_query_t = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtnames WHERE type='genre' ORDER BY in_count DESC");
		while ($row = WebTomat_Data::wt_getrow($wt_query_t)){
			$a .= Wt::wt_menu2($row['en_name'],$row['rus_name'],$genre_href,$str);
		}
		
        return $a;

    }
	static public function wt_menu2($genreEn,$genreRus,$genre_href, $str)
    {
        global $wt_link;
		$replace = array(
                '{wt_href_genre}' => $wt_link.$genre_href.$genreEn,//'&ingenre='.
                '{title_genre}' => $genreRus,
            );
        return strtr($str, $replace);
		
	}
    static public function buildHead2($genre_href)
    {
        $str = file_get_contents( WEBTOMAT_DIR .'/themes/gamebrd/wt_head.tpl');
        if ( WEBTOMAT_DECODE == "utf-8" ) {
            $str = iconv( "UTF-8", "utf-8", $str );
        }
        preg_match( "#\\[cont=genres](.*?)\\[/cont\\]#ies", $str , $matches);
        $genres = wt::main2($matches[1],$genre_href);
        $str = preg_replace ( "#\\[cont=genres](.*?)\\[/cont\\]#ies", '', $str);
        $str = preg_replace ( '/\{wt_genres\}/', $genres, $str);
        global $wt_webid,$wt_link,$wt_theme;
        $str = preg_replace ( '/\{webid\}/', $wt_webid, $str );
		$split = strpos($wt_link,"?") !== false ? "&" : "?";
		$str = preg_replace ( '/\{wt_href_all\}/', $wt_link.$split, $str );
        $str = preg_replace ( '/\{WTTHEME\}/', $wt_theme, $str );

        return $str;
    }
	static public function wt_gameboard ($str,$genre,$game_href,$genre_href)
    {
		$search     = Wt::globper('search');
        $wt_ajax    = Wt::globper('wt_ajax');
        $p = Wt::globper('wtp');
        global $wt_link;

        $str = stripslashes($str);
        preg_match ( '#\\[page=game](.*?)\\[/page\\]#ies' , $str ,$matches3);
        preg_match ( '#\\[c1=more](.*?)\\[/c1\\]#ies' , $str ,$matches);
        $game = $matches3[1];
        $more = $matches[1];
        
        $start = (!isset($p) or empty($p)) ? 0 : $p;
		$b_sort = 'wtg_popular ';

        if ($genre && $genre != 'all')
            $b_ingenres = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_genres LIKE '%{$genre}%' ORDER BY wtg_new limit $start, 20");
        else if (isset($search)) {
            $search = WebTomat_Data::wt_safesql($search);
            $b_sort = Wt::wt_sort('sort');
            $b_ingenres = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_name LIKE '%{$search}%' OR wtg_title LIKE '%{$search}%' OR wtg_desc LIKE '%{$search}%' ORDER BY {$b_sort} limit $start, 20");
        }
        else
            $b_ingenres = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames ORDER BY {$b_sort} limit $start, 20");

        $start = $start + 20;
        $game_ids = '';
        $i = 0;
		if (WebTomat_Data::wt_numrow($b_ingenres) > 0) {
            while ($row = WebTomat_Data::wt_getrow($b_ingenres)) {

				$game_id[$i] = $row['wtg_id'];
                $game_name_en[$i] = $row['wtg_name'];
                $img200[$i] = $row['wtg_apppath'] . '/' . $game_name_en[$i] . '_l.' . $row['wtg_img200'];
                $game_name_rus[$i] = $row['wtg_title'];
                $game_ids .=$game_id[$i].',';
                $i++;
            }
        }
        $game_ids = substr($game_ids,0,count($game_ids)-2);

        $game_block = '';
		for($i=0; $i<count($game_id)-1; $i++){
            $replace = array(
                '{img200}' => $img200[$i],
                '{game_name_rus}' => $game_name_rus[$i],
                '{wt_href_ingame}' => $wt_link.$game_href.$game_id[$i],
                '{game_id}' => $game_id[$i],
                '{data_game_id}' => (isset($wt_ajax)) ? $game_id[$i] : ''
            );
            $game_block .= strtr($game, $replace);
        }
		
        if (count($game_id) < 20) $more = '';
		else $more = preg_replace ( '/\{wt_href_next\}/', $wt_link.$genre_href.$genre.'&wtp='.$start, $more);
        if (! isset($wt_ajax) ) {
			$cont = Wt::buildHead2($genre_href);
			$cont = preg_replace ( '/\{wt_block\}/' , $game_block, $cont );
            $cont = preg_replace ( '/\{wt_more\}/' , $more, $cont );
            $cont = preg_replace ( '/\{params\}/', '&games='.$game_ids.'&genre='.$genre.'&search='.$search, $cont );
        }
        else $cont = $game_block;
        
		return $cont;
	}
    static public function wt_ingame2 ($str, $ingame,$genre_href)
    {
        $str = stripslashes($str);

        $wt_query_t = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtgames WHERE wtg_id='{$ingame}' limit 1");
        $row = WebTomat_Data::wt_getrow($wt_query_t);
        $img200 = $row['wtg_apppath'] . '/' . $row['wtg_name'] . '_l.' . $row['wtg_img200'];
        $game_desc = $row['wtg_desc'];
        $game_name_rus = $row['wtg_title'];
        $wt_game_width = $row['wtg_width'];
        $wt_game_height = $row['wtg_height'];

        $wt_rnum = '';
        for ($i = 0; $i < 5; $i++) {
            $wt_rnum .= rand(0, 9);
        }

        global $wt_webid;
        $wt_game_width = $wt_game_width - 100;
        $replace = array(
            '{game_name_rus}' => $game_name_rus,
            '{img200}' => $img200,
            '{game_desc}' =>$game_desc,
            '{ingame}' => $ingame,
            '{ingame_load}' => $ingame.'&webid='.$wt_webid.'&r='.$wt_rnum,
            '{wt_game_width}' => $wt_game_width,
            '{wt_game_margin}' => -($wt_game_width/2)-12,
            '{wt_share_margin}' => ($wt_game_width/2)+12,
            '{wt_game_height}' => $wt_game_height,
            '{game_id}' => $ingame,
            '{WTPRELOADER}' => 'http://games.apitech.ru/Web/Preloader'
        );
        $cont = wt::buildHead2($genre_href);
        $cont = preg_replace ( '/\{wt_block\}/' , $str, $cont );
        $cont = preg_replace ( '/\{wt_more\}/' , '', $cont );

        $cont = preg_replace ( '/\{params\}/' , '&game='.$ingame, $cont );
        $cont = strtr($cont, $replace);
        return $cont;
    }
    static public function wt_nullboard ($genre_href){
        $cont = wt::buildHead2($genre_href);
        $cont = preg_replace ( '/\{wt_block\}/' , '', $cont );
        $cont = preg_replace ( '/\{wt_more\}/' , '', $cont );
        $cont = preg_replace ( '/\{params\}/' , '&tomat=true', $cont );
        return $cont;
    }

}

?>