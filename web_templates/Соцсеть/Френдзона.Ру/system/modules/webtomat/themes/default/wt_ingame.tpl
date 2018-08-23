  [cont=wt_menu]
            <div class="box_right_owne_tomat" style="position: absolute;margin-top: -8px; background: none repeat scroll 0 0 rgba(0, 0, 0, 0); border-left: 5px solid rgba(0, 0, 0, 0);">
			  <!-- Поиск -->
            <div id="wt_search">
                 <input id="wt_input_search" class="seasr_game" name="search" type="text" onFocus="this.value=''; this.style.color='#000'" onBlur="if (this.value==''){this.value='Поиск игры'; this.style.color='#b3b3b3'}" value="Поиск игры">
            </div>
			<script type="text/javascript">
			document.getElementById("wt_input_search").onkeydown = function(event){
                event = event || window.event;
				if(event.keyCode==13){
					var url = '{WTURLMAIN}'+'search='+this.value;
					document.location = url;
				}
			}
			</script>
			 <div class="bs_categirs">Категории</div>
                <div {wt_menu_sel_new}><a href="{WTURLMAIN}{wt_href_mn}" onClick="Page.Go(this.href); return false;">Новое</a></div>
                [cont2=genre]
                <div {wt_menu_sel_ingenre}><a  href="{WTURLMAIN}{wt_href_mg}" onClick="Page.Go(this.href); return false;">{genre_rus}</a></div>
                [/cont2]
				
            </div>
            [/cont]
<div id="wt_cont">
    <!-- ingame -->
    <link href="{WTDIR}css/style.css" rel="stylesheet" type="text/css">
    <script src="{WTDIR}js/style.js" type="text/javascript"></script>
    <script src="{WTDIR}js/ds.js" type="text/javascript"></script>
    <script src="{WTDIR}js/swfobject.js" type="text/javascript"></script>
    <script type="text/javascript">
        var wt_show_all = ["Показать все","Скрыть"];
    </script>
    <script> wt_dir = "{WTDIR}"; </script>
    <div id="wt_wrapper">
        <div id="wt_header">
            <div style="width:100%">
                {WT_LOGIN}
            </div>
        </div>
        <!-- Контент -->
        <div id="wt_content" onclick="wt_st(document.getElementById('wt_menu_kn'),1)">
            <!-- Хлебные крошки -->
            [cont=wt_kroshki]<div id="breedclumbs" class="bt_geasd"><a href="{WTMAIN}" onClick="Page.Go(this.href); return false;">Главная</a>[cont2=krosh] <span></span> <a href="{WTURLMAIN}{wt_href_krosh}" title="{krosh_text}" onClick="Page.Go(this.href); return false;"> {krosh_text}  </a>[/cont2] <span></span> {krosh_rus}</div>[/cont]
            <div id="ingame">
                <div class="img"><img src="{img200}"></div>
                <div class="disk">
                    <div class="wt_title">
                        {game_name_rus}
                        [cont2=new_img]<span class="wt_s_nor wt_top_new"></span>[/cont2]
                        [cont2=top_img]<span class="wt_s_nor wt_top_pop"></span>[/cont2]
                    </div><br /><br />
                    [cont=wt_reating]
                        <div class="wt_reating">
                            [var=src]
                                <script type="text/javascript">
                                    var wt_uv = {wt_uv};
                                    var wt_reatWidth = parseFloat({rate_percent});
                                    var ds = new DShare(location.href,
                                            "{game_name_rus}",
                                            "{game_desc}",
                                            "{img200}?{wt_rnum}"
                                    );
                                </script>
                            [/var]
                            [cont2=reating_str]
                                <span class="wt_s_nor wt_rate_star inl" style="left:{star_pos}px" onmouseover="wt_rt_start(this)" onmouseout="wt_rt_end(this)" onclick="if (!wt_uv) wt_rt_vote(this)"><input type="hidden" value="{n}" name="rate_val" /></span>
                            [/cont2]
                            <div id="wt_rate_color" style="width:{rate_percent}%"></div>
                            <div id="wt_rate_color_ser"></div>
                            <div class="wt_load" style="display:none"><img src="{WTDIR}images/load.gif" width="15" height="15" /></div>
                        </div>
                    [/cont]
                    <div class="anons">{game_desc}</div>
                    <div class="wt_s_nor tag">
                        [cont2=tagname_rus] <a href="{WTURLMAIN}{wt_href_tag}" onClick="Page.Go(this.href); return false;">{tgr}</a>,[/cont2]
                    </div>
                </div>
   
            </div>

            <div id="wt_game">
				<div id="affCaller"></div>
				<script type="text/javascript">
				swfobject.embedSWF("http://static.apitech.ru/lib/web/c/caller.swf?{wt_rnum}", "affCaller", 1, 1, "4.0.0.0", '', {gId : {ingame}, pId : {webid}}, { "wmode": "transparent", "allowscriptaccess": "always", "allownetwork": "all" });
				function getRedirectURI(gameId) {
					var link = location.href.split('ingame=');
					var url = link[0]+"ingame="+gameId;
					document.location = url;
				}
				</script>
                <iframe id="wt_game_iframe" width="577" frameborder="0" scrolling="no" height="{wt_game_height}" src="http://games.apitech.ru/Web/Preloader?appid={ingame}&webid={webid}">
                </iframe>
            </div>


        </div>
    </div>
</div>
