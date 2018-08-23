{include file="header.tpl"}

<div class="items-index">
		<div class="profil widther">
	<div class="userprofil">
					<div class="lcol">
						<img src="{user_avatar}" alt="{user_name}" width="186">
						<div class="otstup"></div>
<span class="addmoneys" style="display: inline-block;">
					<form action="/pay" method="POST">
						<input name="moneys" type="number" min="0" placeholder="Сумма" class="invoiceMoneys" value="100">
						<button class="buttons refill">+</button>
					</form>
					</span><div class="otstup"></div>
						<a href="https://steamcommunity.com/profiles/{user_steam}" target="_blank"  class="profsteam">Профиль STEAM</a>
					</div>
					<div class="rcol">

							<div>
							<div class="lfw"><h2>Ваш инвентарь</h2></div>
						<div class="p-items">	{inventory} </div>
							<div class="opencase-drops nmg"></div>
						</div>
					</div>
					<div class="rcol trade">
					<div class="lfw"><h2>Начальные настройки</h2></div>
												Вы можете поменять свою трейд ссылку в любое время. Узнать ее можно <a href="https://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">здесь</a>
						<form action="/api" method="post">
							  <input type="hidden" name="action" value="updateLink">
							  <input type="url" name="tradelink" class="tradelink" value="{trade_link}" placeholder="https://steamcommunity.com/tradeoffer/new/?partner=YYYYYYYYY&amp;token=XXXXXXXX"> 
							  <input type="submit" class="buttonz"  value="Сохранить">
							</form>
					</div>
				</div>
			</div>
		</div></div></div>
{include file="footer.tpl"}