<script type="text/javascript">
$(document).ready(function(){
	if($('#query_full').val() == 'Начните вводить любое слово или имя')
		$('#query_full').val('');
});
</script>
<div class="pcont search">
<div class="panel">
<form class="oneline" action="/search">
<table>
<tbody>
<tr>
<td width="100%">
<div class="iwrap">
<input class="text" type="text"  value="Начните вводить любое слово или имя" id="query_full">
</div>
</td>
<td class="last">
<input class="btn al_tab" type="submit" value="Искать" onClick="gSearch.go(); return false">
</td>
</tr>
</tbody>
</table>
<input type="hidden" value="1" id="se_type_full" />
</form>


<ul class="tabs">
<li class="{activetab-1}">
<a class="al_tab" href="/?{query-people}" onclick="Page.Go(this.href); return false;">Люди</a>
</li>
<li class="{activetab-4}">
<a class="al_tab" href="/?go=search{query-groups}" onclick="Page.Go(this.href); return false;">Сообщества</a>
</li>
</ul>
</div>
<input type="hidden" value="{type}" id="se_type_full" />
<div class="clr"></div>
[yes]
<a id="filter_selector" class="summary" onclick="toggleClass('opened', 'filter_selector'); toggleClass('opened', 'filter_panel'); return false;" href="/?{query-people}">
<span>Найдено {count}</span>
</a>
[/yes]