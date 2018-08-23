<?
if( ! defined( 'MOZG' )) {
	die( "Hacking attempt!" );
}
define ( 'NEXT_DIR', dirname ( __FILE__ ) );
include (ENGINE_DIR . '/data/nextgame.config.php');
include_once 'nextgame.php';
require_once NEXT_DIR.'/nextgame.functions.php';
require_once ENGINE_DIR.'/modules/functions.php';
$tpl->load_template("nextgame/my_game.tpl");
$app_id=intval($_REQUEST['about_app']);
$cache_time=(intval($nextgame['cache_time'])!=0)?intval($nextgame['cache_time'])*60:3600;
$num_my=(intval($nextgame['num_my'])!=0)?intval($nextgame['num_my']):5;
$my_apps=game_from_cache('nextgame_my.json',$cache_time);
$user_id = $user_info['user_id'];
 $sig = md5("site_id=".$nextgame['site_id']."user_id=".$user_id.$nextgame['api_key']."");




if(!$my_apps)
{
    $my_apps=@file_get_contents($nextgame['api_url'].'api/?method=apps.getUserApps&site_id='.$nextgame['site_id'].'&user_id='.$user_id.'&format=xml');
    game_to_cache('nextgame_my.json',$my_apps);
       
}
$my_apps=json_decode($my_apps,true);
$my_game=array();
foreach($my_apps['data'] as $game)
{
    $my_game[]=$game;
}
$logo=($nextgame['logo_type']=='medium')?'logo_medium':'logo';
//print_r($new_game);
$total_games=count($my_game); //32 
$start=rand(0,$total_games-$nextgame['num_my']-1); //26
for($i = $start; $i < $start+$nextgame['num_my']; $i++)
{
$tpl->set("{logo}",$my_game[$i][$logo]);
$tpl->set("{title}",convert_unicode($my_game[$i]['title'],$config['charset']));
$game_link=$config['home_url']."game/".$my_game[$i]['id'];
$tpl->set("[game_link]","<a href=\"".$game_link."\">");
$tpl->set("[/game_link]","</a>");
$tpl->compile('my_game'); 
}


?>