
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

    <!-- Main -->
    <link href="{WTDIR}css/style.css" rel="stylesheet" type="text/css">
    <script src="{WTDIR}js/style.js" type="text/javascript"></script>
    <script>
        wt_dir = "{WTDIR}";
        wt_show_all = ["Показать все","Скрыть"];
    </script>
    <div id="wt_wrapper">
	                [cont=wt_slider]
                <div id="wt_slid" class="wt_s_nor" style="opacity: 1; width: 551px;">
                    <div id="wt_slider">
                        <div id="wt_slider_content">
                            [cont2=slider]<a title="{wtg_title}" href="{WTURLMAIN}{wt_href_slid}"><div class="wt_s_nor slid_img_mask"></div><img src="{wt_href_slidimg}" width="120" height="60" alt="1"></a>[/cont2]
                        </div>
                    </div>
                    <span id="wt-slider-go-next" class="offsel wt_s_nor" onclick="wt_nextSlid(123,80)">&nbsp;</span>
                </div>
                [/cont]
        <div id="wt_header">
            <div style="width:100%">
			<!-- Логин -->
                {WT_LOGIN}
            </div>
          
        </div>
        <!-- Контент -->
        <div id="wt_content" onclick="wt_st(document.getElementById('wt_menu_kn'),1)">
            [cont=wt_kroshki]<div id="breedclumbs"><a href="{WTMAIN}" onClick="Page.Go(this.href); return false;">Главная</a>[cont2=krosh] <span></span> <a href="{WTURLMAIN}{wt_href_krosh}" onClick="Page.Go(this.href); return false;" title="{krosh_text}"> {krosh_text}  </a>[/cont2] <span></span> {krosh_rus}</div>[/cont]
            [page=main]
                <!-- Блок -->
                <div class="block">
                    <div class="wt_title_games">
                        <a onClick="Page.Go(this.href); return false;" href="{WTURLMAIN}{wt_href_genre}">{genrename_rus}</a>
                        <span>(всего {count})</span><a href="{WTURLMAIN}{wt_href_genre}" onClick="Page.Go(this.href); return false;"><span class="flww_gjww">Показать все {count}</a></span></div>
                    <div class="disk">
                        <div class="img"><a onClick="Page.Go(this.href); return false;" href="{WTURLMAIN}{wt_href_gbingame}"><img src="{top_game_img}" width="100" height="100" alt="{game_name_en}"></a></div>
                        <div class="wt_title">
                            <div class="wt_game_titl">
                                <div class="wt_game_titl_in">
                                {top_game_name}
                                    [cont2=new_img]<span class="wt_s_nor wt_top_new"></span>[/cont2]
                                    [cont2=pop_img]<span class="wt_s_nor wt_top_pop"></span>[/cont2]
                                </div>
                            </div>
                            <div class="trans"></div>
                        </div>
                        <div class="anons">{top_game_desc}<div class="trans"></div></div>
												<span class="boxswrr">                    <div class="best">Лучшее в разделе</div>
                    <div class="wt_game">
                        [cont2=most_popular]
                            <a{wtg_mp_class} href="{WTURLMAIN}{wt_href_gbmostp}">
								<div class="wt_game_icon inl" style="background-image:url({wtg_img16});">&nbsp;</div>
                                <div class="wt_game_name">{game_name}</div>
                                <div class="trans inl">&nbsp;</div>
                            </a>
                        [/cont2]
                    </div>
					</span>
                        <div class="wt_s_nor tag">
                            [cont2=tagname_rus] <a onClick="Page.Go(this.href); return false;" href="{WTURLMAIN}{wt_href_tag}">{tgr}</a>,[/cont2]
                        </div>
                        <a class="wt_s_nor ingame" onClick="Page.Go(this.href); return false;" href="{WTURLMAIN}{wt_href_gbingame}">&nbsp;</a>

                    </div>

                </div>
            [/page]
            [page=tags]
                <table class="wt_tbl_tags"><tr><td>
                {wt_SPLIT}
                </td><td>
                {wt_SPLIT}
                    <div class="wt_s_nor wt_tags_title">{wt_simbols_n}</div>
                {wt_SPLIT}
                    <a onClick="Page.Go(this.href); return false;" href="{WTURLMAIN}{wt_href_tags}">{wt_tag_rus}</a>
                {wt_SPLIT}
                </td></tr></table>
            [/page]
        </div>
    </div>
</div>