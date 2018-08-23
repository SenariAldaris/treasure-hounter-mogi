<script type="text/javascript">
$(document).ready(function(){
	vii_interval = setInterval('im.updateDialogs()', 2000);
	pHate = location.hash.replace('#', '');
	if(pHate)
		im.open(pHate);
});
</script>
<style type="text/css" media="all">

.flwsss_lef {
    float: left;
    margin-left: 0;
    margin-top: 2px;
    min-height: 500px;
    padding-left: 0;
    width: 580px;
}
#footer {
    background: url("/templates/Old/images/head.png") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
    bottom: 0;
    box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.52) inset;
    color: #FFFFFF;
    display: none;
    height: 30px;
    margin-bottom: 0;
    margin-left: 222px;
    padding-left: 10px;
    padding-top: 12px;
    position: relative;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
    width: 567px;
}
.ava {
    float: left;
    margin-left: -8px;
    margin-right: 3px;
    margin-top: -10px;
    padding: 6px;
    position: fixed;
    width: 200px;
    z-index: 100;
}
.go-up, .go-down {
    background: rgba(0, 0, 0, 0.26);
    color: #FFFFFF;
    cursor: pointer;
    display: none;
    height: 100%;
    margin-bottom: 5px;
    margin-left: -106px;
    opacity: 0.5;
    padding: 3px;
    position: fixed;
    text-align: center;
    text-shadow: 0 1px 2px #000000;
    width: 87px;
    z-index: 9999;
}
.public_wall_all_comm {
    background: none repeat scroll 0 0 #F4F7FA;
    border-bottom: 2px solid rgba(0, 39, 59, 0.08);
    color: #6A7989;
    cursor: pointer;
    margin-bottom: 6px;
    margin-top: -7px;
    opacity: 0.5;
    padding: 9px;
    text-align: center;
    width: 559px;
}
.public_wall_all_comm:hover {
    opacity: 1;
}

.active2 {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}

</style>

<div class="im_flblock">
<div class="mess_dialogs">Диалоги</div>

<div class="clear"></div><span id="updateDialogs"></span>{dialogs}<div class="clear"></div></div><div class="im_head fl_l" id="imViewMsg"><div class="info_center"><div style="padding-top:122px"><center><div class="mess_imgsw"></div></center>Вы можете выбрать собеседника из левой колоны и начать с ним общение в онлайн режиме, без обновления страницы.</div></div></div>