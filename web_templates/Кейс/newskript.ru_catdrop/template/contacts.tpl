{include file="header.tpl"}
<div class="panel panel-default" style="margin-top: 10px;">
    <div class="panel-body">
<script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>

<script type="text/javascript">
  VK.init({apiId: 5226169, onlyWidgets: true});
</script><section>
		<div class="title">Отзывы покупателей</div>
		<div class="items-index">

		<center>
			<div id="vk_comments"></div>
		</center>

		</div>
	</section>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 15, width: "665", attach: "*"});
</script>	<footer>

    </div>
</div>
{include file="footer.tpl"}