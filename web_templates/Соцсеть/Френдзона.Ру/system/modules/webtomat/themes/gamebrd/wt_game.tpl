<div id="wtGame" class="row-fluid">
    <div class="">
        <div id="wt_cont" class="single item2 span6" style="width:{wt_game_width}px;margin-left:{wt_game_margin}px;">
            <ul class="share" style="margin-left:{wt_share_margin}px;"><li><a class="vk" title="Поделиться ссылкой в Вконтакте" onclick="ds.OpenVK(location.href, {ingame}, \'mini\', \'vk\'); return false;" href=""></a></li><li><a class="ok" title="Поделиться ссылкой в Однокласниках" onclick="ds.OpenOK(location.href, {ingame}, \'mini\', \'ok\');return false;" href="#gameids={ingame}"></a></li><li><a href="" class="mail" title="Поделиться ссылкой в Mail.Ru" onclick="ds.OpenMM(location.href, {ingame}, \'mini\', \'mm\'); return false;" href=""></a></li><li><a class="fb"  title="Поделиться ссылкой в Facebook" onclick="ds.OpenFB(location.href, {ingame}, \'mini\', \'fb\'); return false;" href=""></a></li><li><a class="tw" title="Поделиться ссылкой в Twitter" onclick="ds.OpenTW(location.href, {ingame}, \'mini\', \'vk\'); return false;" href="" ></a></li><li><a class="gp" onclick="ds.OpenGP(location.href, {ingame}, \'mini\', \'gp\');return false;" title="Поделиться ссылкой в Google+" href=""></a></li></ul>
            <div class="wt_titleblock">
                <div class="row-fluid">
                    <img src="{img200}" class="wt_title" alt=""/>
                    <div class="wt_info wt_game">
                        <h1><a>{game_name_rus}</a></h1>
                        <p>{game_desc}</p></div>
                </div>
                <ul id="counters{game_id}" class="counters">
                </ul>
                <div class="wttooltip"></div>
			</div>
			<div class="row-fluid wt_screen">
            <iframe id="wt_game_iframe" width="{wt_game_width}" frameborder="0" scrolling="no" height="{wt_game_height}" src="{WTPRELOADER}?appid={ingame_load}"></iframe></div>
            <div class="buttons"><a id="like_{game_id}" class="like"><div class="wt_l"></div>&nbsp;нравится<div class="wt_r"></div></a>
                <a id="save_{game_id}" class="save"><div class="wt_l"></div>&nbsp;сохранить<div class="wt_r"></div></a><div class="wt_close"><div></div>
                    <span>Закрыть игру</span></div><div class="wt_right_close wt_close"><div>

                    </div></div>
                <div class="wt_open">
                    <div></div>
                    <span>Развернуть</span></div>
            </div>
			
		<div style="display: none;" class="like-list">
                <span class="wt_title">
                    <img src="{WTDIR}images/big-like.png" alt="" />Нравится
                </span>
                <ul></ul>
        </div>
			
		<div style="display: none;" class="save-list">
            <span class="wt_title">
                <img src="{WTDIR}images/big-pin.png" alt="" />сохранили</span>
            <ul></ul>
        </div>
		
        <div style="display: none;" class="simm-list">
                <span class="wt_title">Похожие игры</span>
                <ul></ul>
        </div>
		
            <ul class="wt_comments" id="wt_comments_{game_id}">
                <li class="send">
                    <div class="commentimg"><img src="" /></div>
                    <div class="text">
                        <textarea class="send-text" id="your_comment{game_id}" style="color:rgb(179, 179, 179)" onblur="this.style.color=\'#b3b3b3\'" maxlength="70" >Оставить комментарий</textarea>
                        <span type="button" name value onclick="tomatAPI.addComment({game_id})">
                            <div class="wt_l"></div>отправить<div class="wt_r">

                            </div>
						</span>
					</div>
				</li>
							

			</ul>
        </div>
    </div>
</div><script>var ds = new DShare(location.href,"{game_name_rus}","{game_desc}","{img200}?{wt_rnum}");</script>