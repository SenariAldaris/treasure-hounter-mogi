<?php
if(!defined('MOZG'))
    die('Hacking attempt!');

echoheader();
include 'system/modules/webtomat/wt_conf.php';
echohtmlstart($wt_lang['info']);


$editwebid 		= $_POST['wt_webid'];
$editmainpage 	= $_POST['wt_mainpage'];
$edittheme 		= $_POST['wt_theme'];
$editload 		= $_POST['wt_load'];
$u 				= $_REQUEST['u'];
$editversion 	= $_POST['wt_version'];
$editwindow = isset($_POST['wt_window'])?$_POST['wt_window']:'';
$editlogo = isset($_POST['wt_logo']) ? $_POST['wt_logo'] : '';
$editcache = isset($_POST['wt_cache']) ? $_POST['wt_cache'] : '';
$editskey = isset($_POST['wt_skey']) ? $_POST['wt_skey'] : '';
$action			= $_POST['action'];

if (isset($_REQUEST['res'])) $res = $_POST['res'];

if ( (isset($u) or isset($res)) and isset($wt_webid) and intval($wt_webid) != 0 ){
    require_once WEBTOMAT_DIR . "/install.php";
    if ( isset($wt_upd_count) ){

        $new_wt_last_update = time();
        $data->wt_mysql("UPDATE " . WEBTOMAT_PREF . "wtmodule set val='{$new_wt_last_update}' where params='wt_last_update'");

        if (isset($u)) {
            if ( $wt_upd_count == 0 )
                $msg = $wt_lang['opt_new_game_not'];
            else
                $msg = $wt_lang['opt_add'].$wt_upd_count.$wt_lang['opt_new_games'];
        } else
            $msg = $wt_lang['opt_full_update'].$wt_upd_count."</b>";
		header("Content-Type: text/html; charset=utf-8");
		if ( $config['charset'] != "utf-8") $wt_cont = iconv( "UTF-8","utf-8", $wt_cont );
    }
    exit('|WT_SPLIT|'.$msg);
}
if( $action == "dosavewtopt" ) {
	require_once WEBTOMAT_DIR."/install.php";

    $editwebid = WebTomat_Data::wt_safesql( $editwebid );
    $editwebid = intval( $editwebid );
    if ( !$editwebid ) $editwebid = "";
    if( empty( $editwebid ) OR strlen( $editwebid ) > 10 ) {
        msg( "error", "Error !!!", "webID not correct", "$PHP_SELF?mod=wtopt" );
    }

    $editmainpage = WebTomat_Data::wt_safesql( $editmainpage );
    if ( !$editmainpage ) $editmainpage = "";

    $editload = WebTomat_Data::wt_safesql( $editload );
    if( empty( $editload ) ) {
        msg( "error", "Error !!!", "'Load type' not correct", "$PHP_SELF?mod=wtopt" );
    }

    $nas_arr = array(
        'wt_webid' => $editwebid,
        'wt_mainpage' => $editmainpage,
        'wt_theme' => $edittheme,
        'wt_load' => $editload,
        'wt_version' => $editversion,
        'wt_skey' => $editskey,
        'wt_window' => $editwindow,
        'wt_logo' => $editlogo,
        'wt_cache' => $editcache,
        'last_update' => time()
    );

    foreach ( $nas_arr as $key => $val ){
        $data->wt_mysql( "SELECT * FROM " . WEBTOMAT_PREF . "wtmodule WHERE params='$key'" );
        if ( $data->wt_numrow() == 0 )
            $sql_update = "INSERT INTO " . WEBTOMAT_PREF . "wtmodule ( params, val ) VALUE ( '{$key}', '{$val}' )";
        else
            $sql_update = "UPDATE " . WEBTOMAT_PREF . "wtmodule set val='$val' where params='{$key}'";
        $data->wt_mysql( $sql_update );
    }

    $data->wt_mysql( "SELECT * FROM " . WEBTOMAT_PREF . "wtmodule" );
    while ( $row = $data->wt_getrow() ) {
        $$row['params'] = $row['val'];
    }

}

$arr_themes = array("0","1","2","3","4","5","6");
$arr_loads = array("AJAX","HTML");
$arr_version = array("","2");
$HTMLthemes = '';
$HTMLloads = '';
$HTMLversion1 = '';
$HTMLversion2 = '';
for ($i=0; $i<count($arr_themes); $i++){
    $th = $arr_themes[$i];
    if ( $wt_theme == $th ) {
        $sel = 'checked="checked"';
    } else {
        $sel = '';
    }
    $HTMLthemes .='<div class="cwt_theme" style="background-image: url('.WEBTOMAT_DIR.'/images/'.$th.'.png)"><input type="radio" name="wt_theme" value="'.$th.'" '.$sel.'></div>';
}

//* Window *//

$popup = '';
if ($wt_window) $popup='checked="checked"';
$nologo='';
if ($wt_logo) $nologo='checked="checked"';
$nocache='';
if ($wt_cache) $nocache='checked="checked"';

//* Mainpage *//

$arr_page = array("","arkady", "logicheskie", "priklyucheniya", "brodilki", "kvesty", "dlya_devochek", "ekshn", "strelyalki", "fizicheskie_igry", "sportivnye", "gonki", "multiki", "voennye", "tryuki", "strategii", "poisk_predmetov", "draki", "anime", "kartochnye", "ekonomicheskie", "podbor_odezhdy");
for ($i=0; $i<count($arr_page); $i++){
    $ld = $arr_page[$i];
    if ( $wt_mainpage == $ld ) {
        $sel = ' selected';
    } else {
        $sel = '';
    }
    if ($i == 0 & !$wt_mainpage) $sel = ' selected';
    $HTMLpage .= '<option value="'.$ld.'"'.$sel.'>'.$wt_lang['opt_name_page'][$i].'</option>';
}
$HTMLpage='<select class="edit bk" style="width:155px" name="wt_mainpage" value="'.$wt_mainpage.'">'.$HTMLpage.'</select>';
//
for ($i=0; $i<count($arr_loads); $i++){
    $ld = $arr_loads[$i];
    if ( $wt_load == $ld ) {
        $sel = ' selected';
    } else {
        $sel = '';
    }
    $HTMLloads .= '<option value="'.$ld.'"'.$sel.'>'.$ld.'</option>';
}

for ($i=0; $i<count($arr_version); $i++){
    $ver = $arr_version[$i];
    if ( $wt_version == $ver ) {
        $sel = 'checked="checked"';
    } else {
        $sel = '';
    }
    if ($i == 0)
        $HTMLversion1 = '<tr>
				<td style="padding:2px;width:200px;">
                <p style="width:150px;float:left;">
                    <input id="wt_version1" type="radio" name="wt_version" value="" '.$sel.' onchange="wt_selectVersion1(1000)"> '.$wt_lang['opt_wt_v1'].' </p>
				</td>

				<td>
                <img src="'.WEBTOMAT_DIR.'/images/cat1.png" style="box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.5);"/>
                </td>
			</tr>';
    if ($i == 1)
        $HTMLversion2 = '<tr>
                <td style="padding:2px;width:200px;-webkit-transition: 1s;-moz-transition: 1s;opacity:1">
				<div id="wt_gambrd1">
					<p style="width:150px;float:left;">
						<input type="radio" name="wt_version" value="2" '.$sel.' onchange="wt_selectVersion2(1000)">
							'.$wt_lang['opt_wt_v2'].'
					</p>
				</div>
				</td>
				<td><div id="wt_gambrd2">
                <img src="'.WEBTOMAT_DIR.'/images/cat2.png" style="margin-top:10px;box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.5);"/></div>
                </td>
            </tr>';
}

$wt_srcs = '
	<script type="text/javascript" src="'.WEBTOMAT_DIR.'/js/wt_adm.js"></script>
	<script> wt_dir = "'.WEBTOMAT_DIR.'"; </script>
	<link href="'.WEBTOMAT_DIR.'/css/style-adm.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" >
	var arr1=[\'wt_theme1\',\'wt_theme2\',\'wt_window1\',\'wt_window2\',\'wt_logo1\',\'wt_logo2\'];
	var arr2=[\'wt_mainpage1\',\'wt_mainpage2\'];
	ElementsShow = function(arr){
		for (var i=0;i<arr.length;i++){
			document.getElementById(arr[i]).style.height=\'auto\';
			document.getElementById(arr[i]).style.opacity=1;
		}
	}
	ElementsHide = function(arr,tout){
		for (var i=0;i<arr.length;i++) document.getElementById(arr[i]).style.opacity=0;
		setTimeout(function(j){
			for (var i=0;i<arr.length;i++) document.getElementById(arr[i]).style.height=0;
		},tout);
	}
	wt_selectVersion1 = function(tout){
		if (document.getElementById("wt_load").value=="AJAX"){
			ElementsShow(arr2);
		}
		ElementsHide(arr1,tout);
	}
	wt_selectVersion2 = function(tout) {
		ElementsHide(arr2,tout);
		ElementsShow(arr1);
		
	}
	wt_checkForLoad = function(tout){
		var arr3=[\'wt_gambrd1\',\'wt_gambrd2\',\'wt_cache1\',\'wt_cache2\'];
		if (document.getElementById("wt_load").value!="AJAX") {
			document.getElementById(\'wt_version1\').checked=\'checked\';
			ElementsHide(arr1,tout);
			ElementsHide(arr2,tout);
			ElementsHide(arr3);
		}
		else {
			ElementsShow(arr3);
			if (document.getElementById("wt_version1").checked){
				ElementsShow(arr2);
			}
			else {
				ElementsShow(arr1);
				
			}
		}
	}
	</script>';

if ( isset($wt_webid) and !empty($wt_webid) )
    $wt_var_upd = '
				<tr>
					<td id="wt_updLabel" style="padding:2px;">'.$wt_lang['opt_wt_upd'].'</td>
					<td style="padding:2px;">
						<span id="wt_updGame" class="wt_adm_upd wt_offsel" onclick="wt_goupd(this,\'upd\')">'.$wt_lang['opt_wt_upd_kn'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span id="wt_updHelp" class="wt_adm_upd wt_offsel" onclick="wt_goupdhelp(\'upd\',120,60)" style="">'.$wt_lang['opt_wt_upd_auto'].'</span>
						<div style="position:relative"><div id="wt_upd_help" style="display:none" onclick="wt_goupdhelp(\'upd\',120,60)">'.$wt_lang['opt_wt_upd_help'].'</div></div>
					</td>
				</tr>
				<tr>
                    <td id="wt_updLabel">'.$wt_lang['opt_wt_res'].'&nbsp;&nbsp;
                        <span id="wt_resHelp" class="wt_adm_upd wt_offsel" onclick="wt_goupdhelp(\'res\',100,50)" style="">[?]</span>
                        </td>
                    <td>
                        <span id="wt_resGame" class="wt_adm_upd wt_offsel" onclick="wt_goupd(this,\'res\')">'.$wt_lang['opt_wt_res_kn'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div style="position:relative"><div id="wt_res_help" style="display:none" onclick="wt_goupdhelp(\'res\',100,50)">'.$wt_lang['opt_wt_res_help'].'</div></div>
                    </td>
                </tr>';
echo <<<HTML
{$wt_srcs}
{$wt_lang['update_info']}
<form method="post" action="" name="wtopt">
<table width="100%">
    <tr>
        <td style="padding:2px;width:200px;">{$wt_lang['opt_wt_webid']}</td>
        <td style="padding:2px;"><input class="edit bk" type="text" name="wt_webid" value="{$wt_webid}">
        <span class="wt_adm_upd wt_offsel" onclick="wt_goupdhelp('webid',70,35)" style="">[?]</span>
        <div style="position:relative"><div id="wt_webid_help" style="display:none;" onclick="wt_goupdhelp('webid',70,35)">{$wt_lang['opt_wt_webid_help']}</div></div>
        </td>
    </tr>
    <tr>
        <td style="padding:2px;">{$wt_lang['opt_wt_load']}</td>
        <td style="padding:2px;">
			<select id="wt_load" class="edit bk" style="width:155px" name="wt_load" value="{$wt_load}" onchange="wt_checkForLoad(1000)">
				<option value="">{$wt_lang['opt_wt_load_no']}</option>
				{$HTMLloads}
			</select>
		</td>
    </tr>
    {$HTMLversion1}
	<tr>
        <td style="padding:2px;width:200px;"><div id="wt_mainpage1">{$wt_lang['opt_wt_mainpage']}</div></td>
        <td style="padding:2px;">
            <div id="wt_mainpage2">
            {$HTMLpage}
		    <span id="wt_mainHelp" class="wt_adm_upd wt_offsel" onclick="wt_goupdhelp('main',150,100)" style="">[?]</span>
		    <div style="position:relative">
		        <div id="wt_main_help" style="display:none;" onclick="wt_goupdhelp('main',150,100)">{$wt_lang['opt_wt_mainpage_help']}</div>
		    </div>
		    </div>
        </td>
    </tr>
    {$HTMLversion2}
	<tr>
		<td>
			<div id="wt_window1">{$wt_lang['opt_wt_window']}</div>
		</td>
		<td>
			<input id="wt_window2" type="checkbox" {$popup} name="wt_window">
		</td>
	</tr>
	<tr>
		<td>
			<div id="wt_logo1">{$wt_lang['opt_wt_logo']}</div>
		</td>
		<td>
			<input id="wt_logo2" type="checkbox" {$nologo} name="wt_logo">
		</td>
	</tr>
    <tr>
        <td style="padding:2px;"><div id="wt_theme1">{$wt_lang['opt_wt_theme']}</div></td>
        <td style="padding:2px;">
            <div id="wt_theme2" style="">
				{$HTMLthemes}
			</div>
		</td>
    </tr>
	<tr>
		<td>
			<div id="wt_cache1">{$wt_lang['opt_wt_cache']}</div>
		</td>
		<td>
			<input id="wt_cache2" type="checkbox" {$nocache} name="wt_cache">
		</td>
	</tr>
	<tr><td style="padding:2px;" colspan=2><hr></td></tr>
		<tr>
            <td style="padding:2px;" colspan=2><b>{$wt_lang['opt_wt_auth']}</b></td>
        </tr>
		<tr>
			<td style="text-decoration:">{$wt_lang['opt_wt_skey']}</td>
			<td>
				<input class="edit bk" style="width:253px" type="text" value="{$wt_skey}" name="wt_skey">
			</td>
		</tr>
		<tr>
			<td><b>{$wt_lang['opt_wt_authURL']}</b></td>
			<td>{$wt_lang['opt_wt_authURL1']}</td>
		</tr>
		<tr>
			<td><b>{$wt_lang['opt_wt_apiURL']}</b></td>
			<td>{$wt_lang['opt_wt_apiURL1']}</td>
		</tr>
		<tr>
				<td style="padding:2px;" colspan=2><i>{$wt_lang['opt_wt_authMARK']}</i></td>
			</tr>
			
	<tr><td style="padding:2px;" colspan=2><hr></td></tr>
	
	{$wt_var_upd}
    <tr>
        <td colspan="2"><div class="hr_line"></div></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-left:5px;"><input type="submit" class="buttons" value="&nbsp;{$wt_lang['opt_wt_save']}&nbsp;">
     <input type="hidden" name="mod" value="wtopt">
	 <input type="hidden" name="user_hash" value="$dle_login_hash" />
     <input type="hidden" name="action" value="dosavewtopt"></td>
    </tr>
</table>

</div><script type="text/javascript" >
			wt_checkForLoad(false);
			if (document.getElementById("wt_version1").checked) wt_selectVersion1(false);
			else wt_selectVersion2(false);

		</script></form>
HTML;

//* Htmlclear(); *//

echohtmlend();
?>