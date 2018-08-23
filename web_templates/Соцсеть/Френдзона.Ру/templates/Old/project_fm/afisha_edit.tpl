
<script>

$('#ads_no_remove').hide();

</script>

<div id="vallery_row_edit">

<div class="err_yellow no_display" id="result"></div> 

<table class="vallery_table_edit">

<tbody>

<tr>

<td align="center" class="label ta_r">Название:</td>

<td><input type="text" id="title" class="text" value="{title_}" style="width:239px" /></td>

</tr>

<tr>

<td align="center" class="label ta_r">Место провидения:</td>

<td><input type="text" id="place" class="text" value="{place_}" style="width:239px" /></td>

</tr>

<tr>

<td align="center" class="label ta_r">Время проведения:</td>

<td><input type="text" id="date" class="text" value="{date_}" style="width:239px" /></td>

</tr>

<tr>

<td align="center" class="label ta_r">Организатор:</td>

<td><input type="text" id="sponsor" class="text" value="{sponsor_}" style="width:239px" /></td>

</tr>

<tr>

<td align="center" class="label ta_r">Ссылка на изображение:</td>

<td><input type="text" id="photos" class="text" value="{photos_}" style="width:239px" /></td>

</tr>

<tr>

<td align="center" class="label ta_r">Описание:</td>

<td><textarea class="text" id="description" style="width:239px">{description_}</textarea></td>

</tr>

<tr>

<td align="center" class="label ta_r"></td>

<td><div class="button_div fl_l"><button onClick="projectfm.afisha_edit('{id_}')" id="sending">Сохранить афишу</button></div></td>

</tr>

</tbody>

</table>

</div>
