<?php
function wt_xmlToBase($xml){
	$is_tags = array();
    $genres_inCount = array();
    $count = 0;
    $ins_query = '';

	function getImgRash($imgput){
		$wtg_apppath_temp = explode("/",$imgput);
		$imgsize = explode('.', $wtg_apppath_temp[count($wtg_apppath_temp)-1]);
		$imgsize = mb_substr($imgsize[1], 0, mb_strpos($imgsize[1], '?'), 'UTF-8');
		return $imgsize;
	}

	foreach($xml->games->game as $game) {
		$max_rate = ( !isset($max_rate) or $max_rate < $game['popular'] ) ? $game['popular'] : $max_rate;
	}

	foreach($xml->games->game as $game) {

		$wtg_id = (integer) $game['id'];

		WebTomat_Data::wt_mysql("SELECT id FROM " . WEBTOMAT_PREF . "wtgames WHERE `wtg_id`='{$wtg_id}'");
		if ( !isset($wt_utest) or WebTomat_Data::wt_numrow() == 0 ) {

			$wtg_title = (string) $game['title'];
			$wtg_name = (string) $game['name'];
			$wtg_desc =  WebTomat_Data::wt_safesql($game->description);
			$wtg_height = (integer) $game['height'];
			$wtg_width = (integer) $game['width'];
			$wtg_popular = round($game['popular'] / ($max_rate / 5), 2);
            if ($wtg_popular >= 5) $wtg_popular = 4.99;
            $wtg_popular = str_replace(',','.',(5 - $wtg_popular));
			$wtg_new = (integer) $game['new'];
			$wtg_created =  ( isset($game['created']) and !empty($game['created']) ) ? (string) $game['created'] : date("Y-m-d", time());
			if ( $wtg_created > 0 ) {
				$arrdate = explode('-',$wtg_created);
				$wtg_created = mktime(0, 0, 0, $arrdate[1],  $arrdate[2],  $arrdate[0]);
			}

			$wtg_tags = '';
			foreach($game->tags->tag as $tag) {
				$id = (string) $tag['id'];
				$wtg_tags .= $id.',';
				if (!in_array($id,$is_tags))
					$is_tags[] = $id;
			}
			$wtg_tags = mb_substr($wtg_tags, 0, mb_strlen($wtg_tags, 'UTF-8')-1, 'UTF-8');

            $wtg_genres = '';
            foreach($game->genres->genre as $genre) {
                $id = (string) $genre['id'];
                !isset($genres_inCount[$id]) ? $genres_inCount[$id] = 1 : $genres_inCount[$id]++;
                $wtg_genres .= $id.',';
            }
            $wtg_genres = mb_substr($wtg_genres, 0, mb_strlen($wtg_genres, 'UTF-8')-1, 'UTF-8');

			$wtg_apppath_temp = explode("/",$game->image16x16);
			$posl = count($wtg_apppath_temp)-1;
			$img_rash16 = explode('.', $wtg_apppath_temp[$posl]);
			$img_rash16 = mb_substr($img_rash16[1], 0, mb_strpos($img_rash16[1], '?'), 'UTF-8');
			unset($wtg_apppath_temp[$posl]);
			$wtg_apppath = implode('/',$wtg_apppath_temp);


			$img_rash50 = getImgRash($game->image50x50);
			$img_rash75 = getImgRash($game->image75x75);
			$img_rash100 = getImgRash($game->image100x100);
			$img_rash120 = getImgRash($game->image120x60);
			$img_rash200 = getImgRash($game->image200x200);

            $ins_query .= "( '$wtg_id','$wtg_title','$wtg_name','$wtg_desc','$wtg_height','$wtg_width','$wtg_tags','$wtg_genres','$wtg_apppath','$wtg_popular','$wtg_new','$wtg_created','$img_rash16','$img_rash50','$img_rash75','$img_rash100','$img_rash120','$img_rash200' ),";
            if ( ($count > 0 and ($count % 100) == 0) or $count == count($xml->games->game) - 1 ) {
                $ins_query = mb_substr($ins_query, 0, mb_strlen($ins_query, 'UTF-8')-1, 'UTF-8');
				$wt_query = "INSERT INTO " . WEBTOMAT_PREF . "wtgames ( wtg_id, wtg_title, wtg_name, wtg_desc, wtg_height, wtg_width, wtg_tags, wtg_genres, wtg_apppath, wtg_popular, wtg_new, wtg_created, wtg_img16, wtg_img50, wtg_img75, wtg_img100, wtg_img120, wtg_img200 )
													VALUES $ins_query";
				if ( WEBTOMAT_DECODE == "utf-8" ) {
					$wt_query = iconv('UTF-8','utf-8',$wt_query);
				}
                WebTomat_Data::wt_mysql( $wt_query );

                $ins_query = '';
            }
			$count++;
		}
	}

    $ins_query = '';
	foreach($xml->tags->tag as $tag) {
		if (!empty($is_tags) and in_array($tag['id'],$is_tags)) {
			$wtt_type = 'tag';
			$en_name = (string) $tag['id'];
			$rus_name = $tag;

			if ( isset($u) )
				$wt_utest = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtnames WHERE `en_name`='{$en_name}' and `type`='{$wtt_type}' limit 1");
			if ( !isset($u) or ( isset($wt_utest) && WebTomat_Data::wt_numrow($wt_utest) == 0 ) )
                $ins_query .= "( '$en_name','$rus_name','$wtt_type' ),";
		}
	}
    if ( !empty($ins_query) ) {
        $ins_query = mb_substr($ins_query, 0, mb_strlen($ins_query, 'UTF-8')-1, 'UTF-8');
		$wt_query = "INSERT INTO " . WEBTOMAT_PREF . "wtnames ( en_name, rus_name, type ) VALUES {$ins_query}";
		if ( WEBTOMAT_DECODE == "windows-1251" ) {
			$wt_query = iconv('UTF-8','windows-1251',$wt_query);
		}
        WebTomat_Data::wt_mysql( $wt_query );
    }

    $ins_query = '';
	foreach($xml->genres->genre as $genre) {
		$wtt_type = 'genre';
		$en_name = (string) $genre['id'];
		$rus_name = $genre;

		if ( isset($u) )
			$wt_utest = WebTomat_Data::wt_mysql("SELECT * FROM " . WEBTOMAT_PREF . "wtnames WHERE `en_name`='{$en_name}' and `type`='{$wtt_type}' limit 1");
        if ( !isset($u) or ( isset($wt_utest) && WebTomat_Data::wt_numrow($wt_utest) == 0 ) ){
            $gt = (!isset($genres_inCount[$en_name]) or empty($genres_inCount[$en_name])) ? 0 : $genres_inCount[$en_name];
            $ins_query .= "( '$en_name','$rus_name','$wtt_type','$gt' ),";
        }
	}
    if ( !empty($ins_query) ) {
        $ins_query = mb_substr($ins_query, 0, mb_strlen($ins_query, 'UTF-8')-1, 'UTF-8');
		$wt_query = "INSERT INTO " . WEBTOMAT_PREF . "wtnames ( en_name, rus_name, type, in_count ) VALUES {$ins_query}";
		if ( WEBTOMAT_DECODE == "windows-1251" ) {
			$wt_query = iconv('UTF-8','windows-1251',$wt_query);
		}
        WebTomat_Data::wt_mysql( $wt_query );
    }

	return $count;
}

$webid = (isset($wt_webid) && intval($wt_webid) !=0) ? $wt_webid : (isset($_POST['wt_webid']) ? $_POST['wt_webid'] : '' );

if ( !isset($u) and !isset($res) ) {

//* Проверка заполненности таблиц с играми и тегами. Если хотя бы одна из них пустая - очищаем обе и заполняем новыми данными *//
	
	$test_wtgames = WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtgames limit 1");
	$row_wtgames = WebTomat_Data::wt_getrow($test_wtgames);
	$test_wtnames = WebTomat_Data::wt_mysql("SELECT COUNT(*) as count FROM " . WEBTOMAT_PREF . "wtnames limit 1");
	$row_wtnames = WebTomat_Data::wt_getrow($test_wtnames);

	if ( !isset($row_wtgames['count']) or empty($row_wtgames['count']) or !isset($row_wtnames['count']) or empty($row_wtnames['count']) ) {

		@WebTomat_Data::wt_mysql("TRUNCATE TABLE " . WEBTOMAT_PREF . "wtgames");
		@WebTomat_Data::wt_mysql("TRUNCATE TABLE " . WEBTOMAT_PREF . "wtnames");

		$wt_url = 'http://games.apitech.ru/Web/XMLCatalog?webid='.$webid;

        $popytok = 0;
        do {
            $popytok++;
			if (function_exists('file_get_contents')) {
				$xmlContent = file_get_contents($wt_url);
			}
			else {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $wt_url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 5);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$xmlContent = curl_exec($ch);
				curl_close($ch);
			}
        } while ( $xmlContent === false and $popytok < 6 );

        $xmlString = &$xmlContent;

        if ( empty($xmlString) or $xmlString === false )
			$wt_ins_msg = 'Указанный Вами webID не подтвержден на сервере games.apitech.ru ('.$wt_url.'), или сервер недоступен.';
		else {
			$xml = new SimpleXMLElement($xmlString);
			$wt_ins_msg = wt_xmlToBase($xml);
		}

	}

} else {

    $last_update = ( isset($wt_last_update) && !empty($wt_last_update) ) ? date("Y-m-d",$wt_last_update) : date("Y-m-d",time());

    if (isset($u)){
        $wt_url = 'http://games.apitech.ru/Web/XMLCatalog?webid='.$webid.'&last_update='.$last_update;
    } else {
        @WebTomat_Data::wt_mysql("TRUNCATE TABLE " . WEBTOMAT_PREF . "wtgames");
        @WebTomat_Data::wt_mysql("TRUNCATE TABLE " . WEBTOMAT_PREF . "wtnames");
        $wt_url = 'http://games.apitech.ru/Web/XMLCatalog?webid='.$webid;
    }

    $popytok = 0;
    do {
        $popytok++;
		if (function_exists('file_get_contents')) {
				$xmlContent = file_get_contents($wt_url);
		}
		else {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $wt_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$xmlContent = curl_exec($ch);
			curl_close($ch);
		}
    } while ( $xmlContent === false and $popytok < 6 );

    $xmlString = &$xmlContent;

    if ( empty($xmlString) or $xmlString === false )
		exit('Указанный Вами webID не подтвержден на сервере games.apitech.ru ('.$wt_url.'), или сервер недоступен.');
	else {
		$xml = new SimpleXMLElement($xmlString);
		$wt_upd_count = wt_xmlToBase($xml);
	}
}

?>