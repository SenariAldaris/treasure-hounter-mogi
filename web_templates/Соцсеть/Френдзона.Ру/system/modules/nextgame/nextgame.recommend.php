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
include_once 'nextgame.new.php';
require_once NEXT_DIR.'/nextgame.functions.php';
require_once ENGINE_DIR.'/modules/functions.php';
$tpl->load_template("nextgame/block_recomend_game.tpl");
$mask=(intval($nextgame['mask_recomend'])!=0)?intval($nextgame['mask_recomend']):7;
$num_recomend=(intval($nextgame['num_recomend'])!=0)?intval($nextgame['num_recomend']):5;
$cache_time=(intval($nextgame['cache_time'])!=0)?intval($nextgame['cache_time'])*60:3600;
$recommend_apps=game_from_cache('nextgame_recommend'.$mask.'.json',$cache_time);
if(!$recommend_apps)
{
    $recommend_apps=@file_get_contents($nextgame['api_url'].'api/?method=apps.getRecommend&mask='.$mask.'&site_id='.$nextgame['site_id'].'&format=json');
    game_to_cache('nextgame_recommend'.$mask.'.json',$new_apps);
    
}
$recommend_apps=json_decode($recommend_apps,true);
$recommend_game=array();
foreach($recommend_apps['data'] as $game)
{
    $recommend_game[]=$game;
}
$logo=($nextgame['logo_type']=='medium')?'logo_medium':'logo';
$total_games=count($recommend_game); //32 
$start=rand(0,$total_games-$nextgame['num_recomend']-1); //26
for($i = $start; $i < $start+$nextgame['num_recomend']; $i++)
{
$tpl->set("{logo}",$recommend_game[$i][$logo]);
$tpl->set("{title}",convert_unicode($recommend_game[$i]['title'],$config['charset']));
$game_link=$config['home_url']."game/".$recommend_game[$i]['id'];
$tpl->set("[game_link]","<a href=\"".$game_link."\">");
$tpl->set("[/game_link]","</a>");
$tpl->compile('rec_game'); 
}
$tpl->load_template("nextgame/head2.tpl");
$tpl->set('{new_game}', $tpl->result['new_game']);
$tpl->set('{rec_game}', $tpl->result['rec_game']);
$tpl->compile('content');

?>