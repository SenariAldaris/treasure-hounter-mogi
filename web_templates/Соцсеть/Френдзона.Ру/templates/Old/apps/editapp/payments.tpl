
<div id="page_tabs_bar_blue">

<a href="/editapp/info_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Информация</b>

</div>

</a>

<a href="/editapp/options_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Настройки</b>

</div>

</a>

<div class="page_tabs_active">

<a href="/editapp/payments_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Платежи</b>

</div>

</a>

</div>

<a href="/editapp/admins_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Администраторы</b>

</div>

</a>

<div class="fl_r">

<a href="/app{id}" onclick="return nav.go(this, event, {noback: true})">К приложению</a>

</div>

</div>

<div id="app_edit_error_wrap">

<div id="app_edit_error"></div>

</div>

<div id="app_edit_cont">

<div class="app_stat_head no_padd no_lpadd">История платежей - На балансе: {balance} Монеток</div>

<div id="app_payments_settings_err" class="error" style="display: none; margin: 0 0 15px 0;"></div>

<div id="app_user_cont" style="margin-bottom: 20px;">

<table id="app_payments_table" cellspacing="0" cellpadding="0" class="wk_table">

<tbody>

<tr>

<th style="width:300px;padding: 1px 5px 2px;">

<div class="app_time_label">Пользователь</div>

</th>

<th style="padding: 1px 5px 2px;">

<div class="app_time_label">Монеток</div>

</th>

<th style="width:155px; padding: 1px 5px 2px;">

<div class="app_time_label">Время</div>

</th>

</tr>{payments}</tbody>

</table>

</div>

<br class="clear">

</div>
