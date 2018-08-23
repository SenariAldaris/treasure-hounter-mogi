 <!-- Логин -->
 <div id="wt_login">
	<div id="wtl_load" style="display:block">
		<img src="{WTDIR}images/load.gif" width="32" height="32" />
	</div>
    <div id="wtl_off" style="display:none">
        <div id="wt_invite">
            <span style="display:block;">Войди,</span>
            <span style="display:block;font-weight:bold">и играй с друзьями!</span>
        </div>
    <script src="http://ulogin.ru/js/ulogin.js?stop"></script>
        <div id="uLogin" x-ulogin-params="display=small;fields=first_name,last_name,photo;providers=google,vkontakte,odnoklassniki,mailru,facebook;hidden=twitter,yandex,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam;redirect_uri={WTURLCALL};callback=webTomatAuth"></div>
        <script>if (typeof uLogin != 'undefined') uLogin.initWidget('uLogin');</script>
    </div>
    <div id="wtl_on" style="display:none">
        <div class="wtl_name"></div>
            <span class="wt_s_nor wt_logout" onclick="wt_logout()"> Выход</span>
                <div class="wtl_foto">
                <span class="wtl_net"></span>
                <img class="wtl_foto_img" src="" width="50" height="50" alt="ava">
	     		</div>
    </div>
</div>