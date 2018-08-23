
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

    <!-- item -->
    <link href="{WTDIR}css/style.css" rel="stylesheet" type="text/css">
    <script src="{WTDIR}js/style.js" type="text/javascript"></script>
    <script>
        wt_dir = "{WTDIR}";
        wt_show_all = ["Показать все","Скрыть"];
    </script>
    <div id="wt_wrapper">
	
        <div id="wt_header">
		          
            <div style="width:100%">

                <!-- Логин -->
                {WT_LOGIN}
            </div>
        </div>

        <!-- Контент -->
        <div id="wt_content" onclick="wt_st(document.getElementById('wt_menu_kn'),1)">
            <!-- Хлебные крошки -->
            [cont=wt_kroshki]<div id="breedclumbs" class="bt_geasd"><a href="{WTMAIN}" onClick="Page.Go(this.href); return false;">Главная</a>[cont2=krosh] <span></span> <a href="{WTURLMAIN}{wt_href_krosh}" title="{krosh_text}" onClick="Page.Go(this.href); return false;"> {krosh_text}  </a>[/cont2] <span></span> {krosh_rus}</div>[/cont]
		  <!-- Левая колонка -->

            [cont=wt_blocksort]
                <div id="left-column">
                    <a {wt_sort_new} href="{WTURLMAIN}{wt_href_sortn}" onClick="Page.Go(this.href); return false;">По новизне</a>
                    <a {wt_sort_pop} href="{WTURLMAIN}{wt_href_sortp}" onClick="Page.Go(this.href); return false;">По популярности</a>
                </div>
            [/cont]
            [cont=wt_gameblock]
                <!-- Блок -->
                <div class="wt_item{wt_item_bg}">
                    <div class="img"><a href="{WTURLMAIN}{wt_href_ingame}" onClick="Page.Go(this.href); return false;"><img src="{img100}" width="60" height="60"></a></div>
                    [cont2=top_img]<span class="wt_s_nor wt_top_pop"></span>[/cont2]
                    [cont2=new_img]<span class="wt_s_nor wt_top_new"></span>[/cont2]
                    <div class="wt_title">
						<div {wt_div_intitle}><a href="{WTURLMAIN}{wt_href_ingame}" onClick="Page.Go(this.href); return false;">{game_name_rus}</a></div>
                    </div>
                    <div class="disk"><div class="anons"><a href="{WTURLMAIN}{wt_href_ingame}" onClick="Page.Go(this.href); return false;">{game_desc}</a></div>
                        <div class="wt_s_nor tag">
                            [cont2=tagname_rus] <a href="{WTURLMAIN}{wt_href_tag}" onClick="Page.Go(this.href); return false;">{tgr}</a>,[/cont2]
                        </div>
                    </div>
                    <div style="margin-top: 13px;"><a class="wt_s_nor ingame" href="{WTURLMAIN}{wt_href_ingame}" onClick="Page.Go(this.href); return false;">&nbsp;</a></div>
                </div>
                [var=searchfalse]
                    <span style="font-weight:bold;"><span style="color:red">Ничего не найдено по вашему запросу «{wt_search}».</span><br />Попробуйте изменить запрос.</span>
                [/var]
                [var=gonext]
                    <div class="kn_sh20 offsel" onclick="wt_sn(this)">
                        [cont2=search_all]<span>Всего найдено {count_all} {wt_game_words_all} по запросу «{wt_search}»</span><br />[/cont2]
                        [cont2=count]<span class="wt_bd">Показать еще {count} {wt_game_words}</span>[/cont2]</div>
                [/var]
            [/cont]
        </div>
    </div>
</div>