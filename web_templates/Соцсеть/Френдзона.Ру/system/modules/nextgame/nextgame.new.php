<?
/*
=====================================================
 DataLife Engine
-----------------------------------------------------
 http://dle.in.ua/
-----------------------------------------------------
 Copyright (c) 2011 Dimka
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: nexgame/nextgame.recomend.php
-----------------------------------------------------
 Назначение: Блок рекомендуемых игр.
=====================================================
*/
if( ! defined( 'MOZG' )) {
	die( "Hacking attempt!" );
}
define ( 'NEXT_DIR', dirname ( __FILE__ ) );
include (ENGINE_DIR . '/data/nextgame.config.php');
require_once NEXT_DIR.'/nextgame.functions.php';
require_once ENGINE_DIR.'/modules/functions.php';
$tpl->load_template("nextgame/block_new_game.tpl");
$cache_time=(intval($nextgame['cache_time'])!=0)?intval($nextgame['cache_time'])*60:3600;
$num_new=(intval($nextgame['num_new'])!=0)?intval($nextgame['num_new']):5;
$new_apps=game_from_cache('nextgame_new.json',$cache_time);
if(!$new_apps)
{
    $new_apps=@file_get_contents($nextgame['api_url'].'api/?method=apps.getNew&show_update_time=1&site_id='.$nextgame['site_id'].'&format=json');
    game_to_cache('nextgame_new.json',$new_apps);
       
}
$new_apps=json_decode($new_apps,true);
$new_game=array();
foreach($new_apps['data'] as $game)
{
    $new_game[]=$game;
}
$logo=($nextgame['logo_type']=='medium')?'logo_medium':'logo';
//print_r($new_game);
$total_games=count($new_game); //32 
$start=rand(0,$total_games-$nextgame['num_new']-1); //26
for($i = $start; $i < $start+$nextgame['num_new']; $i++)
{
$tpl->set("{logo}",$new_game[$i][$logo]);
$tpl->set("{title}",convert_unicode($new_game[$i]['title'],$config['charset']));
$game_link=$config['home_url']."game/".$new_game[$i]['id'];
$tpl->set("[game_link]","<a href=\"".$game_link."\">");
$tpl->set("[/game_link]","</a>");
$tpl->compile('new_game'); 
}


?>