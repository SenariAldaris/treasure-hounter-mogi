<?php
if(!defined('MOZG'))
	die('Hacking attempt!');

define ( 'NEXT_DIR', dirname ( __FILE__ ) );
include_once (ENGINE_DIR . '/data/nextgame.config.php');
include_once 'my.php';
require_once NEXT_DIR.'/nextgame.functions.php';
require_once ENGINE_DIR.'/modules/functions.php';
$app_id=intval($_REQUEST['about_app']);

if($app_id!=0)$method="apps.getInfo&app_id={$app_id}";else $method="apps.getInfo";
$cache_time=(intval($nextgame['cache_time'])!=0)?intval($nextgame['cache_time'])*60:3600;
$get_apps=game_from_cache('nextgame_'.$app_id,$cache_time);
if(!$get_apps)
{
    $get_apps=get_games($method);
    game_to_cache('nextgame_'.$app_id,$get_apps);    
}

$apps=json_decode($get_apps,true);
if(!$apps['result'])
{
    $tpl->result['game_list']="Возникла ошибка!<br />".$apps['errdescr']."<br />Please try again later!";
    @unlink(ENGINE_DIR."/cache/nextgame_".$app_id.".tmp");
    
}
if($logged AND $nextgame['site_player']=="yes")$player="&user_id=".$user_info['user_id']."&usr_nickname=".$user_info['user_name']."&t=".time();else $player="";
$name_game=array();
foreach($apps['data'] as $data)     
{
    $arrs[]=$data;
    $name_game[$data['id']]=$data['title'];
    
}
//navigate
$page=(intval($_GET['page']))?intval($_GET['page']):1;
$total = count($arrs);
$pnumber = (intval($nextgame['per_page'])<5)?24:intval($nextgame['per_page']);
$number = (int)($total/$pnumber);
if((float)($total/$pnumber) - $number != 0) $number++;
$start = (($page - 1)*$pnumber);
$end = $page*$pnumber;
if($end > $total) $end = $total;
if($this_page < 1 || $this_page > $allpage)$this_page = 1;  
$prev_page = $page-1;  
$next_page = $page+1;  
////
if($app_id==0 and $apps['result']){
$tpl->load_template("nav.tpl");
$link="game/page/";
$pages_prev=($prev_page<1)?"":"<a href=\"".$config['home_url'].$link.$prev_page."\">{$prev_page}</a>";
$pages_curr="<b>{$page}</b>";
$pages_next=($next_page>$number)?"":"<a href=\"".$config['home_url'].$link.$next_page."\">{$next_page}</a>";
$tpl->set("{pages}",$pages_prev.$pages_curr.$pages_next);
$tpl->set_block( "'\\[next-link].*?\\[/next-link]'si", "" );    
$tpl->set_block( "'\\[prev-link].*?\\[/prev-link]'si", "" );
$tpl->compile('nav');
}
if($app_id!=0)
{
    $tpl->load_template("nextgame/screens.tpl");
    foreach($arrs[0]['screenshots'] as $screen)
    {
    $tpl->set("{screen-link}",$screen['url']);
    $tpl->compile('screenshot');
}
  
$tpl->load_template("nextgame/game_info.tpl");
}else 
{
    $tpl->load_template("nextgame/game.tpl");
}

if(intval($_GET['ref_id'])!=0)$ref_id="&ref_id=".intval($_GET['ref_id']);else $ref_id="";

for($i = $start; $i < $end; $i++)
{
     
    $tpl->set("{title}",convert_unicode($arrs[$i]['title'],$config['charset']));
    $tpl->set("{description}",convert_unicode($arrs[$i]['description'],$config['charset']));
    $tpl->set("{logo}",$arrs[$i]['logo']);
 $tpl->set("{about-link}",$config['home_url']."game/".$arrs[$i]['id']);
  
    $open_type=($nextgame['open_type']=="link")?"link/":"";
    $play_link=$nextgame['api_url']."iframe/js/{$open_type}?app_id={$data['id']}&site_id=".intval($nextgame['site_id']).$player.$ref_id;
    $sig=($player)?"&sig=".gensign($play_link):"";
    $tpl->set("{screenshots}",$tpl->result['screenshot']);
    if($app_id)
    {
        $metatags['title']=convert_unicode($arrs[$i]['title'],$config['charset']);  
        $tpl->set("{play-link}","<script type='text/javascript' src='{$play_link}{$sig}'></script>");
            
    } else $tpl->set("{play-link}",$config['home_url']."game/".$arrs[$i]['id']);
    $tpl->compile('game_list');
}
if(!$app_id){

 $tpl->load_template("nextgame/head.tpl");
 $tpl->set('{game}', "<div class=\"wgame\">".$tpl->result['game_list']."</div><div class=\"clear\"></div>".$tpl->result['nav']);
  $tpl->set('{my_game}', $tpl->result['my_game']);   
    $tpl->compile('content');   
}else 
{

 $tpl->load_template("nextgame/head.tpl");   
 $tpl->set('{game}', "<div class=\"wgame\">".$tpl->result['game_list']."</div><div class=\"clear\"></div>");
  $tpl->set('{my_game}', $tpl->result['my_game']);  
     $tpl->compile('content');
}

$tpl->clear();
?>

