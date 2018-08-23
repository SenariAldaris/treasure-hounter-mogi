<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#form1').change(function(){
		XHRsendForm(this);
	});
	$('#form2').change(function(){
		XHRsendForm2(this);
	});
	myhtml.checked(['{background_repeat}']);	
});
function XHRsendForm(form){
	var data_f = new FormData(form), xhr = new XMLHttpRequest();
	$('#prces').show();
	$('#uploadfile').hide();
	xhr.open('POST', form.action);
	xhr.onload = function(e){
		if(e.currentTarget.responseText == 1){
			addAllErr('Файл превышает 5 МБ.', 3000);
			$('#uploadfile').show();
			$('#uploadfile').parent().html($('#uploadfile').parent().html());
			$('#prces').hide();
		} else {
			$('#uploadproc').css('width', '198px');
			$('#prctex').text('Фон успешно обновлён!');
			setTimeout(function(){
				$('#uploadfile').show();
				$('#uploadfile').parent().html($('#uploadfile').parent().html());
				$('#prces').hide();
			}, 2500);
		}
	}
	xhr.upload.onprogress = function(e){
		var percent = parseInt(e.loaded / e.total * 100);
		var percent2 = parseInt(e.loaded / e.total * 198);
		$('#uploadproc').css('width', percent2+'px');
		$('#prctex').text(percent+'%');
	}
	xhr.send(data_f);
	return false;
}
function XHRsendForm2(form){
	var data = new FormData(form), xhr = new XMLHttpRequest();
	$('#prces2').show();
	$('#uploadfile2').hide();
	xhr.open('POST', form.action);
	xhr.onload = function(e){
		if(e.currentTarget.responseText == 1){
			addAllErr('Файл превышает 5 МБ.', 3000);
			$('#uploadfile2').show();
			$('#uploadfile2').parent().html($('#uploadfile2').parent().html());
			$('#prces2').hide();
		} else {
			$('#uploadproc2').css('width', '198px');
			$('#prctex2').text('Логотип успешно обновлён!');
			setTimeout(function(){
				$('#uploadfile2').show();
				$('#uploadfile2').parent().html($('#uploadfile2').parent().html());
				$('#prces2').hide();
			}, 2500);
		}
	}
	xhr.upload.onprogress = function(e){
		var percent = parseInt(e.loaded / e.total * 100);
		var percent2 = parseInt(e.loaded / e.total * 198);
		$('#uploadproc2').css('width', percent2+'px');
		$('#prctex2').text(percent+'%');
	}
	xhr.send(data);
	return false;
}
</script>
<div class="search_form_tab" style="margin-top:-9px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:22px">
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <div class="buttonsprofileSec"><a href="/settings/design"><div><b>Дизайн страницы</b></div></a></div>
 </div>
</div>
<div class="margin_top_10"></div><div class="allbar_title">Фон страницы</div>
<form id="form1" action="/index.php?go=settings&act=upload" method="post" enctype="multipart/form-data">
 <div id="prces" class="no_display" style="height:8px">
  <div style="position:absolute;background:#fff;border:1px solid #cccccc;width:198px;height:18px;margin-bottom:10px"></div>
  <div style="background:url('/templates/Old/images/progress_grad.gif?1');border:1px solid #45688e;height:18px;position:absolute;" id="uploadproc"></div>
  <div style="position:absolute;width:198px;height:18px;margin-bottom:10px;font-weight:bold;text-align:center;padding-top:3px;color:#d0e7f7;" id="prctex">0%</div>
 </div>
 <input type="file" name="uploadfile" id="uploadfile" class="inpst" accept="image/*" style="width:200px" /><br />
 <small>Файл не должен превышать 5 Mб. Если у Вас возникают проблемы с загрузкой, попробуйте использовать фотографию меньшего размера.</small>
 <div class="html_checkbox" id="background_repeat" onClick="myhtml.checkbox(this.id)" style="margin-top:10px;color:#777">Растянуть фон на весь экран</div>
</form>
<div class="clear"></div>

<div class="margin_top_10"></div><div class="allbar_title">Размер и стиль шрифта</div>
<select class="inpst" id="family">
 <option value="1" [instSelect-family-Tahoma]>Tahoma</option>
 <option value="2" [instSelect-family-Arial]>Arial</option>
 <option value="3" [instSelect-family-Verdana]>Verdana</option>
 <option value="4" [instSelect-family-Times]>Times</option>
 <option value="5" [instSelect-family-Times New Roman]>Times New Roman</option>
 <option value="6" [instSelect-family-Georgia]>Georgia</option>
 <option value="7" [instSelect-family-Trebuchet MS]>Trebuchet MS</option>
 <option value="8" [instSelect-family-Sans]>Sans</option>
 <option value="9" [instSelect-family-Comic Sans MS]>Comic Sans MS</option>
 <option value="10" [instSelect-family-Courier New]>Courier New</option>
 <option value="11" [instSelect-family-Webdings]>Webdings</option>
 <option value="12" [instSelect-family-Garamond]>Garamond</option>
 <option value="13" [instSelect-family-Helvetica]>Helvetica</option>
 <option value="14" [instSelect-family-Impact]>Impact</option>
 <option value="15" [instSelect-family-Century Gothic]>Century Gothic</option>
 <option value="16" [instSelect-family-Arial Narrow]>Arial Narrow</option>
</select>
<select class="inpst" id="size">
 <option value="1" [instSelect-size-11]>11 px</option>
 <option value="2" [instSelect-size-12]>12 px</option>
 <option value="3" [instSelect-size-13]>13 px</option>
 <option value="4" [instSelect-size-14]>14 px</option>
 <option value="5" [instSelect-size-15]>15 px</option>
</select>

<div class="margin_top_10"></div><div class="allbar_title">Прозрачность</div>
<select class="inpst" id="opacity">
 <option value="1" [instSelect-opacity-100]>100%</option>
 <option value="2" [instSelect-opacity-95]>95%</option>
 <option value="3" [instSelect-opacity-90]>90%</option>
 <option value="4" [instSelect-opacity-80]>80%</option>
 <option value="5" [instSelect-opacity-70]>70%</option>
 <option value="6" [instSelect-opacity-60]>60%</option>
 <option value="8" [instSelect-opacity-50]>50%</option>
 <option value="8" [instSelect-opacity-40]>40%</option>
 <option value="9" [instSelect-opacity-30]>30%</option>
</select>
<div class="clear"></div>

<div class="margin_top_10"></div><div class="allbar_title">Цвет шапки</div>
<select class="inpst" id="color_head" style="width:150px">
 <option value="1" [instSelect-color_head-1]>Красный</option>
 <option value="2" [instSelect-color_head-2]>Оранжевый</option>
 <option value="3" [instSelect-color_head-3]>Желтый</option>
 <option value="4" [instSelect-color_head-4]>Зеленый</option>
 <option value="5" [instSelect-color_head-5]>Голубой</option>
 <option value="6" [instSelect-color_head-6]>Синий</option>
 <option value="7" [instSelect-color_head-7]>Фиолетовый</option>
 [ver]<option value="8" [instSelect-color_head-8]>Черный</option>[/ver]
</select>
<div class="clear"></div>

<div class="margin_top_10"></div><div class="allbar_title">Расположение блоков</div>
<select class="inpst" id="pos">
 <option value="1" [instSelect-pos-1]>Cлева</option>
 <option value="2" [instSelect-pos-2]>Справа</option>
</select>
<div class="clear"></div>

<div class="margin_top_10"></div><div class="allbar_title">Цвет текста</div>
<SELECT id="color" class="inpst" name=r size=10 style="width:150px;font-size:13px">
<OPTION style="background-color: #000000;color:#fff" value=000000>#000000</OPTION>
<OPTION style="background-color: #FFFAFA" value=FFFAFA>#FFFAFA</OPTION>
<OPTION style="background-color: #F8F8FF" value=F8F8FF>#F8F8FF</OPTION>
<OPTION style="background-color: #F5F5F5" value=F5F5F5>#F5F5F5</OPTION>
<OPTION style="background-color: #DCDCDC" value=DCDCDC>#DCDCDC</OPTION>
<OPTION style="background-color: #FFFAF0" value=FFFAF0>#FFFAF0</OPTION>
<OPTION style="background-color: #FDF5E6" value=FDF5E6>#FDF5E6</OPTION>
<OPTION style="background-color: #FAF0E6" value=FAF0E6>#FAF0E6</OPTION>
<OPTION style="background-color: #FAEBD7" value=FAEBD7>#FAEBD7</OPTION>
<OPTION style="background-color: #FFEFD5" value=FFEFD5>#FFEFD5</OPTION>
<OPTION style="background-color: #FFEBCD" value=FFEBCD>#FFEBCD</OPTION>
<OPTION style="background-color: #FFE4C4" value=FFE4C4>#FFE4C4</OPTION>
<OPTION style="background-color: #FFDAB9" value=FFDAB9>#FFDAB9</OPTION>
<OPTION style="background-color: #FFDEAD" value=FFDEAD>#FFDEAD</OPTION>
<OPTION style="background-color: #FFE4B5" value=FFE4B5>#FFE4B5</OPTION>
<OPTION style="background-color: #FFF8DC" value=FFF8DC>#FFF8DC</OPTION>
<OPTION style="background-color: #FFFFF0" value=FFFFF0>#FFFFF0</OPTION>
<OPTION style="background-color: #FFFACD" value=FFFACD>#FFFACD</OPTION>
<OPTION style="background-color: #FFF5EE" value=FFF5EE>#FFF5EE</OPTION>
<OPTION style="background-color: #F0FFF0" value=F0FFF0>#F0FFF0</OPTION>
<OPTION style="background-color: #F5FFFA" value=F5FFFA>#F5FFFA</OPTION>
<OPTION style="background-color: #F0FFFF" value=F0FFFF>#F0FFFF</OPTION>
<OPTION style="background-color: #F0F8FF" value=F0F8FF>#F0F8FF</OPTION>
<OPTION style="background-color: #E6E6FA" value=E6E6FA>#E6E6FA</OPTION>
<OPTION style="background-color: #FFF0F5" value=FFF0F5>#FFF0F5</OPTION>
<OPTION style="background-color: #FFE4E1" value=FFE4E1>#FFE4E1</OPTION>
<OPTION style="background-color: #FFFFFF" value=FFFFFF>#FFFFFF</OPTION>
<OPTION style="background-color: #000000" value=000000>#000000</OPTION>
<OPTION style="background-color: #2F4F4F" value=2F4F4F>#2F4F4F</OPTION>
<OPTION style="background-color: #696969" value=696969>#696969</OPTION>
<OPTION style="background-color: #708090" value=708090>#708090</OPTION>
<OPTION style="background-color: #778899" value=778899>#778899</OPTION>
<OPTION style="background-color: #BEBEBE" value=BEBEBE>#BEBEBE</OPTION>
<OPTION style="background-color: #D3D3D3" value=D3D3D3>#D3D3D3</OPTION>
<OPTION style="background-color: #191970" value=191970>#191970</OPTION>
<OPTION style="background-color: #000080" value=000080>#000080</OPTION>
<OPTION style="background-color: #6495ED" value=6495ED>#6495ED</OPTION>
<OPTION style="background-color: #483D8B" value=483D8B>#483D8B</OPTION>
<OPTION style="background-color: #6A5ACD" value=6A5ACD>#6A5ACD</OPTION>
<OPTION style="background-color: #7B68EE" value=7B68EE>#7B68EE</OPTION>
<OPTION style="background-color: #8470FF" value=8470FF>#8470FF</OPTION>
<OPTION style="background-color: #0000CD" value=0000CD>#0000CD</OPTION>
<OPTION style="background-color: #4169E1" value=4169E1>#4169E1</OPTION>
<OPTION style="background-color: #0000FF" value=0000FF>#0000FF</OPTION>
<OPTION style="background-color: #1E90FF" value=1E90FF>#1E90FF</OPTION>
<OPTION style="background-color: #00BFFF" value=00BFFF>#00BFFF</OPTION>
<OPTION style="background-color: #87CEEB" value=87CEEB>#87CEEB</OPTION>
<OPTION style="background-color: #87CEFA" value=87CEFA>#87CEFA</OPTION>
<OPTION style="background-color: #4682B4" value=4682B4>#4682B4</OPTION>
<OPTION style="background-color: #B0C4DE" value=B0C4DE>#B0C4DE</OPTION>
<OPTION style="background-color: #ADD8E6" value=ADD8E6>#ADD8E6</OPTION>
<OPTION style="background-color: #B0E0E6" value=B0E0E6>#B0E0E6</OPTION>
<OPTION style="background-color: #AFEEEE" value=AFEEEE>#AFEEEE</OPTION>
<OPTION style="background-color: #00CED1" value=00CED1>#00CED1</OPTION>
<OPTION style="background-color: #48D1CC" value=48D1CC>#48D1CC</OPTION>
<OPTION style="background-color: #40E0D0" value=40E0D0>#40E0D0</OPTION>
<OPTION style="background-color: #00FFFF" value=00FFFF>#00FFFF</OPTION>
<OPTION style="background-color: #E0FFFF" value=E0FFFF>#E0FFFF</OPTION>
<OPTION style="background-color: #5F9EA0" value=5F9EA0>#5F9EA0</OPTION>
<OPTION style="background-color: #66CDAA" value=66CDAA>#66CDAA</OPTION>
<OPTION style="background-color: #7FFFD4" value=7FFFD4>#7FFFD4</OPTION>
<OPTION style="background-color: #006400" value=006400>#006400</OPTION>
<OPTION style="background-color: #556B2F" value=556B2F>#556B2F</OPTION>
<OPTION style="background-color: #8FBC8F" value=8FBC8F>#8FBC8F</OPTION>
<OPTION style="background-color: #2E8B57" value=2E8B57>#2E8B57</OPTION>
<OPTION style="background-color: #3CB371" value=3CB371>#3CB371</OPTION>
<OPTION style="background-color: #20B2AA" value=20B2AA>#20B2AA</OPTION>
<OPTION style="background-color: #98FB98" value=98FB98>#98FB98</OPTION>
<OPTION style="background-color: #00FF7F" value=00FF7F>#00FF7F</OPTION>
<OPTION style="background-color: #7CFC00" value=7CFC00>#7CFC00</OPTION>
<OPTION style="background-color: #00FF00" value=00FF00>#00FF00</OPTION>
<OPTION style="background-color: #7FFF00" value=7FFF00>#7FFF00</OPTION>
<OPTION style="background-color: #00FA9A" value=00FA9A>#00FA9A</OPTION>
<OPTION style="background-color: #ADFF2F" value=ADFF2F>#ADFF2F</OPTION>
<OPTION style="background-color: #32CD32" value=32CD32>#32CD32</OPTION>
<OPTION style="background-color: #9ACD32" value=9ACD32>#9ACD32</OPTION>
<OPTION style="background-color: #228B22" value=228B22>#228B22</OPTION>
<OPTION style="background-color: #6B8E23" value=6B8E23>#6B8E23</OPTION>
<OPTION style="background-color: #BDB76B" value=BDB76B>#BDB76B</OPTION>
<OPTION style="background-color: #EEE8AA" value=EEE8AA>#EEE8AA</OPTION>
<OPTION style="background-color: #FAFAD2" value=FAFAD2>#FAFAD2</OPTION>
<OPTION style="background-color: #FFFFE0" value=FFFFE0>#FFFFE0</OPTION>
<OPTION style="background-color: #FFFF00" value=FFFF00>#FFFF00</OPTION>
<OPTION style="background-color: #FFD700" value=FFD700>#FFD700</OPTION>
<OPTION style="background-color: #EEDD82" value=EEDD82>#EEDD82</OPTION>
<OPTION style="background-color: #DAA520" value=DAA520>#DAA520</OPTION>
<OPTION style="background-color: #B8860B" value=B8860B>#B8860B</OPTION>
<OPTION style="background-color: #BC8F8F" value=BC8F8F>#BC8F8F</OPTION>
<OPTION style="background-color: #CD5C5C" value=CD5C5C>#CD5C5C</OPTION>
<OPTION style="background-color: #8B4513" value=8B4513>#8B4513</OPTION>
<OPTION style="background-color: #A0522D" value=A0522D>#A0522D</OPTION>
<OPTION style="background-color: #CD853F" value=CD853F>#CD853F</OPTION>
<OPTION style="background-color: #DEB887" value=DEB887>#DEB887</OPTION>
<OPTION style="background-color: #F5F5DC" value=F5F5DC>#F5F5DC</OPTION>
<OPTION style="background-color: #F5DEB3" value=F5DEB3>#F5DEB3</OPTION>
<OPTION style="background-color: #F4A460" value=F4A460>#F4A460</OPTION>
<OPTION style="background-color: #D2B48C" value=D2B48C>#D2B48C</OPTION>
<OPTION style="background-color: #D2691E" value=D2691E>#D2691E</OPTION>
<OPTION style="background-color: #B22222" value=B22222>#B22222</OPTION>
<OPTION style="background-color: #A52A2A" value=A52A2A>#A52A2A</OPTION>
<OPTION style="background-color: #E9967A" value=E9967A>#E9967A</OPTION>
<OPTION style="background-color: #FA8072" value=FA8072>#FA8072</OPTION>
<OPTION style="background-color: #FFA07A" value=FFA07A>#FFA07A</OPTION>
<OPTION style="background-color: #FFA500" value=FFA500>#FFA500</OPTION>
<OPTION style="background-color: #FF8C00" value=FF8C00>#FF8C00</OPTION>
<OPTION style="background-color: #FF7F50" value=FF7F50>#FF7F50</OPTION>
<OPTION style="background-color: #F08080" value=F08080>#F08080</OPTION>
<OPTION style="background-color: #FF6347" value=FF6347>#FF6347</OPTION>
<OPTION style="background-color: #FF4500" value=FF4500>#FF4500</OPTION>
<OPTION style="background-color: #FF0000" value=FF0000>#FF0000</OPTION>
<OPTION style="background-color: #FF69B4" value=FF69B4>#FF69B4</OPTION>
<OPTION style="background-color: #FF1493" value=FF1493>#FF1493</OPTION>
<OPTION style="background-color: #FFC0CB" value=FFC0CB>#FFC0CB</OPTION>
<OPTION style="background-color: #FFB6C1" value=FFB6C1>#FFB6C1</OPTION>
<OPTION style="background-color: #DB7093" value=DB7093>#DB7093</OPTION>
<OPTION style="background-color: #B03060" value=B03060>#B03060</OPTION>
<OPTION style="background-color: #C71585" value=C71585>#C71585</OPTION>
<OPTION style="background-color: #D02090" value=D02090>#D02090</OPTION>
<OPTION style="background-color: #FF00FF" value=FF00FF>#FF00FF</OPTION>
<OPTION style="background-color: #EE82EE" value=EE82EE>#EE82EE</OPTION>
<OPTION style="background-color: #DDA0DD" value=DDA0DD>#DDA0DD</OPTION>
<OPTION style="background-color: #DA70D6" value=DA70D6>#DA70D6</OPTION>
<OPTION style="background-color: #BA55D3" value=BA55D3>#BA55D3</OPTION>
<OPTION style="background-color: #9932CC" value=9932CC>#9932CC</OPTION>
<OPTION style="background-color: #9400D3" value=9400D3>#9400D3</OPTION>
<OPTION style="background-color: #8A2BE2" value=8A2BE2>#8A2BE2</OPTION>
<OPTION style="background-color: #A020F0" value=A020F0>#A020F0</OPTION>
<OPTION style="background-color: #9370DB" value=9370DB>#9370DB</OPTION>
<OPTION style="background-color: #D8BFD8" value=D8BFD8>#D8BFD8</OPTION>
<OPTION style="background-color: #FFFAFA" value=FFFAFA>#FFFAFA</OPTION>
<OPTION style="background-color: #EEE9E9" value=EEE9E9>#EEE9E9</OPTION>
<OPTION style="background-color: #CDC9C9" value=CDC9C9>#CDC9C9</OPTION>
<OPTION style="background-color: #8B8989" value=8B8989>#8B8989</OPTION>
<OPTION style="background-color: #FFF5EE" value=FFF5EE>#FFF5EE</OPTION>
<OPTION style="background-color: #EEE5DE" value=EEE5DE>#EEE5DE</OPTION>
<OPTION style="background-color: #CDC5BF" value=CDC5BF>#CDC5BF</OPTION>
<OPTION style="background-color: #8B8682" value=8B8682>#8B8682</OPTION>
<OPTION style="background-color: #FFEFDB" value=FFEFDB>#FFEFDB</OPTION>
<OPTION style="background-color: #EEDFCC" value=EEDFCC>#EEDFCC</OPTION>
<OPTION style="background-color: #CDC0B0" value=CDC0B0>#CDC0B0</OPTION>
<OPTION style="background-color: #8B8378" value=8B8378>#8B8378</OPTION>
<OPTION style="background-color: #FFE4C4" value=FFE4C4>#FFE4C4</OPTION>
<OPTION style="background-color: #EED5B7" value=EED5B7>#EED5B7</OPTION>
<OPTION style="background-color: #CDB79E" value=CDB79E>#CDB79E</OPTION>
<OPTION style="background-color: #8B7D6B" value=8B7D6B>#8B7D6B</OPTION>
<OPTION style="background-color: #FFDAB9" value=FFDAB9>#FFDAB9</OPTION>
<OPTION style="background-color: #EECBAD" value=EECBAD>#EECBAD</OPTION>
<OPTION style="background-color: #CDAF95" value=CDAF95>#CDAF95</OPTION>
<OPTION style="background-color: #8B7765" value=8B7765>#8B7765</OPTION>
<OPTION style="background-color: #FFDEAD" value=FFDEAD>#FFDEAD</OPTION>
<OPTION style="background-color: #EECFA1" value=EECFA1>#EECFA1</OPTION>
<OPTION style="background-color: #CDB38B" value=CDB38B>#CDB38B</OPTION>
<OPTION style="background-color: #8B795E" value=8B795E>#8B795E</OPTION>
<OPTION style="background-color: #FFFACD" value=FFFACD>#FFFACD</OPTION>
<OPTION style="background-color: #EEE9BF" value=EEE9BF>#EEE9BF</OPTION>
<OPTION style="background-color: #CDC9A5" value=CDC9A5>#CDC9A5</OPTION>
<OPTION style="background-color: #8B8970" value=8B8970>#8B8970</OPTION>
<OPTION style="background-color: #FFF8DC" value=FFF8DC>#FFF8DC</OPTION>
<OPTION style="background-color: #EEE8CD" value=EEE8CD>#EEE8CD</OPTION>
<OPTION style="background-color: #CDC8B1" value=CDC8B1>#CDC8B1</OPTION>
<OPTION style="background-color: #8B8878" value=8B8878>#8B8878</OPTION>
<OPTION style="background-color: #FFFFF0" value=FFFFF0>#FFFFF0</OPTION>
<OPTION style="background-color: #EEEEE0" value=EEEEE0>#EEEEE0</OPTION>
<OPTION style="background-color: #CDCDC1" value=CDCDC1>#CDCDC1</OPTION>
<OPTION style="background-color: #8B8B83" value=8B8B83>#8B8B83</OPTION>
<OPTION style="background-color: #F0FFF0" value=F0FFF0>#F0FFF0</OPTION>
<OPTION style="background-color: #E0EEE0" value=E0EEE0>#E0EEE0</OPTION>
<OPTION style="background-color: #C1CDC1" value=C1CDC1>#C1CDC1</OPTION>
<OPTION style="background-color: #838B83" value=838B83>#838B83</OPTION>
<OPTION style="background-color: #FFF0F5" value=FFF0F5>#FFF0F5</OPTION>
<OPTION style="background-color: #EEE0E5" value=EEE0E5>#EEE0E5</OPTION>
<OPTION style="background-color: #CDC1C5" value=CDC1C5>#CDC1C5</OPTION>
<OPTION style="background-color: #8B8386" value=8B8386>#8B8386</OPTION>
<OPTION style="background-color: #FFE4E1" value=FFE4E1>#FFE4E1</OPTION>
<OPTION style="background-color: #EED5D2" value=EED5D2>#EED5D2</OPTION>
<OPTION style="background-color: #CDB7B5" value=CDB7B5>#CDB7B5</OPTION>
<OPTION style="background-color: #8B7D7B" value=8B7D7B>#8B7D7B</OPTION>
<OPTION style="background-color: #F0FFFF" value=F0FFFF>#F0FFFF</OPTION>
<OPTION style="background-color: #E0EEEE" value=E0EEEE>#E0EEEE</OPTION>
<OPTION style="background-color: #C1CDCD" value=C1CDCD>#C1CDCD</OPTION>
<OPTION style="background-color: #838B8B" value=838B8B>#838B8B</OPTION>
<OPTION style="background-color: #836FFF" value=836FFF>#836FFF</OPTION>
<OPTION style="background-color: #7A67EE" value=7A67EE>#7A67EE</OPTION>
<OPTION style="background-color: #6959CD" value=6959CD>#6959CD</OPTION>
<OPTION style="background-color: #473C8B" value=473C8B>#473C8B</OPTION>
<OPTION style="background-color: #4876FF" value=4876FF>#4876FF</OPTION>
<OPTION style="background-color: #436EEE" value=436EEE>#436EEE</OPTION>
<OPTION style="background-color: #3A5FCD" value=3A5FCD>#3A5FCD</OPTION>
<OPTION style="background-color: #27408B" value=27408B>#27408B</OPTION>
<OPTION style="background-color: #0000FF" value=0000FF>#0000FF</OPTION>
<OPTION style="background-color: #0000EE" value=0000EE>#0000EE</OPTION>
<OPTION style="background-color: #0000CD" value=0000CD>#0000CD</OPTION>
<OPTION style="background-color: #00008B" value=00008B>#00008B</OPTION>
<OPTION style="background-color: #1E90FF" value=1E90FF>#1E90FF</OPTION>
<OPTION style="background-color: #1C86EE" value=1C86EE>#1C86EE</OPTION>
<OPTION style="background-color: #1874CD" value=1874CD>#1874CD</OPTION>
<OPTION style="background-color: #104E8B" value=104E8B>#104E8B</OPTION>
<OPTION style="background-color: #63B8FF" value=63B8FF>#63B8FF</OPTION>
<OPTION style="background-color: #5CACEE" value=5CACEE>#5CACEE</OPTION>
<OPTION style="background-color: #4F94CD" value=4F94CD>#4F94CD</OPTION>
<OPTION style="background-color: #36648B" value=36648B>#36648B</OPTION>
<OPTION style="background-color: #00BFFF" value=00BFFF>#00BFFF</OPTION>
<OPTION style="background-color: #00B2EE" value=00B2EE>#00B2EE</OPTION>
<OPTION style="background-color: #009ACD" value=009ACD>#009ACD</OPTION>
<OPTION style="background-color: #00688B" value=00688B>#00688B</OPTION>
<OPTION style="background-color: #87CEFF" value=87CEFF>#87CEFF</OPTION>
<OPTION style="background-color: #7EC0EE" value=7EC0EE>#7EC0EE</OPTION>
<OPTION style="background-color: #6CA6CD" value=6CA6CD>#6CA6CD</OPTION>
<OPTION style="background-color: #4A708B" value=4A708B>#4A708B</OPTION>
<OPTION style="background-color: #B0E2FF" value=B0E2FF>#B0E2FF</OPTION>
<OPTION style="background-color: #A4D3EE" value=A4D3EE>#A4D3EE</OPTION>
<OPTION style="background-color: #8DB6CD" value=8DB6CD>#8DB6CD</OPTION>
<OPTION style="background-color: #607B8B" value=607B8B>#607B8B</OPTION>
<OPTION style="background-color: #C6E2FF" value=C6E2FF>#C6E2FF</OPTION>
<OPTION style="background-color: #B9D3EE" value=B9D3EE>#B9D3EE</OPTION>
<OPTION style="background-color: #9FB6CD" value=9FB6CD>#9FB6CD</OPTION>
<OPTION style="background-color: #6C7B8B" value=6C7B8B>#6C7B8B</OPTION>
<OPTION style="background-color: #CAE1FF" value=CAE1FF>#CAE1FF</OPTION>
<OPTION style="background-color: #BCD2EE" value=BCD2EE>#BCD2EE</OPTION>
<OPTION style="background-color: #A2B5CD" value=A2B5CD>#A2B5CD</OPTION>
<OPTION style="background-color: #6E7B8B" value=6E7B8B>#6E7B8B</OPTION>
<OPTION style="background-color: #BFEFFF" value=BFEFFF>#BFEFFF</OPTION>
<OPTION style="background-color: #B2DFEE" value=B2DFEE>#B2DFEE</OPTION>
<OPTION style="background-color: #9AC0CD" value=9AC0CD>#9AC0CD</OPTION>
<OPTION style="background-color: #68838B" value=68838B>#68838B</OPTION>
<OPTION style="background-color: #E0FFFF" value=E0FFFF>#E0FFFF</OPTION>
<OPTION style="background-color: #D1EEEE" value=D1EEEE>#D1EEEE</OPTION>
<OPTION style="background-color: #B4CDCD" value=B4CDCD>#B4CDCD</OPTION>
<OPTION style="background-color: #7A8B8B" value=7A8B8B>#7A8B8B</OPTION>
<OPTION style="background-color: #BBFFFF" value=BBFFFF>#BBFFFF</OPTION>
<OPTION style="background-color: #AEEEEE" value=AEEEEE>#AEEEEE</OPTION>
<OPTION style="background-color: #96CDCD" value=96CDCD>#96CDCD</OPTION>
<OPTION style="background-color: #668B8B" value=668B8B>#668B8B</OPTION>
<OPTION style="background-color: #98F5FF" value=98F5FF>#98F5FF</OPTION>
<OPTION style="background-color: #8EE5EE" value=8EE5EE>#8EE5EE</OPTION>
<OPTION style="background-color: #7AC5CD" value=7AC5CD>#7AC5CD</OPTION>
<OPTION style="background-color: #53868B" value=53868B>#53868B</OPTION>
<OPTION style="background-color: #00F5FF" value=00F5FF>#00F5FF</OPTION>
<OPTION style="background-color: #00E5EE" value=00E5EE>#00E5EE</OPTION>
<OPTION style="background-color: #00C5CD" value=00C5CD>00C5CD</OPTION>
<OPTION style="background-color: #00868B" value=00868B>#00868B</OPTION>
<OPTION style="background-color: #00FFFF" value=00FFFF>#00FFFF</OPTION>
<OPTION style="background-color: #00EEEE" value=00EEEE>#00EEEE</OPTION>
<OPTION style="background-color: #00CDCD" value=00CDCD>#00CDCD</OPTION>
<OPTION style="background-color: #008B8B" value=008B8B>#008B8B</OPTION>
<OPTION style="background-color: #97FFFF" value=97FFFF>#97FFFF</OPTION>
<OPTION style="background-color: #8DEEEE" value=8DEEEE>#8DEEEE</OPTION>
<OPTION style="background-color: #79CDCD" value=79CDCD>#79CDCD</OPTION>
<OPTION style="background-color: #528B8B" value=528B8B>528B8B</OPTION>
<OPTION style="background-color: #7FFFD4" value=7FFFD4>7FFFD4</OPTION>
<OPTION style="background-color: #76EEC6" value=76EEC6>76EEC6</OPTION>
<OPTION style="background-color: #66CDAA" value=66CDAA>66CDAA</OPTION>
<OPTION style="background-color: #458B74" value=458B74>458B74</OPTION>
<OPTION style="background-color: #C1FFC1" value=C1FFC1>C1FFC1</OPTION>
<OPTION style="background-color: #B4EEB4" value=B4EEB4>B4EEB4</OPTION>
<OPTION style="background-color: #9BCD9B" value=9BCD9B>9BCD9B</OPTION>
<OPTION style="background-color: #698B69" value=698B69>698B69</OPTION>
<OPTION style="background-color: #54FF9F" value=54FF9F>54FF9F</OPTION>
<OPTION style="background-color: #4EEE94" value=4EEE94>4EEE94</OPTION>
<OPTION style="background-color: #43CD80" value=43CD80>43CD80</OPTION>
<OPTION style="background-color: #2E8B57" value=2E8B57>2E8B57</OPTION>
<OPTION style="background-color: #9AFF9A" value=9AFF9A>9AFF9A</OPTION>
<OPTION style="background-color: #90EE90" value=90EE90>90EE90</OPTION>
<OPTION style="background-color: #7CCD7C" value=7CCD7C>7CCD7C</OPTION>
<OPTION style="background-color: #548B54" value=548B54>548B54</OPTION>
<OPTION style="background-color: #00FF7F" value=00FF7F>00FF7F</OPTION>
<OPTION style="background-color: #00EE76" value=00EE76>00EE76</OPTION>
<OPTION style="background-color: #00CD66" value=00CD66>00CD66</OPTION>
<OPTION style="background-color: #008B45" value=008B45>008B45</OPTION>
<OPTION style="background-color: #00FF00" value=00FF00>00FF00</OPTION>
<OPTION style="background-color: #00EE00" value=00EE00>00EE00</OPTION>
<OPTION style="background-color: #00CD00" value=00CD00>00CD00</OPTION>
<OPTION style="background-color: #008B00" value=008B00>008B00</OPTION>
<OPTION style="background-color: #7FFF00" value=7FFF00>7FFF00</OPTION>
<OPTION style="background-color: #76EE00" value=76EE00>76EE00</OPTION>
<OPTION style="background-color: #66CD00" value=66CD00>66CD00</OPTION>
<OPTION style="background-color: #458B00" value=458B00>458B00</OPTION>
<OPTION style="background-color: #C0FF3E" value=C0FF3E>C0FF3E</OPTION>
<OPTION style="background-color: #B3EE3A" value=B3EE3A>B3EE3A</OPTION>
<OPTION style="background-color: #9ACD32" value=9ACD32>9ACD32</OPTION>
<OPTION style="background-color: #698B22" value=698B22>#698B22</OPTION>
<OPTION style="background-color: #CAFF70" value=CAFF70>#CAFF70</OPTION>
<OPTION style="background-color: #BCEE68" value=BCEE68>#BCEE68</OPTION>
<OPTION style="background-color: #A2CD5A" value=A2CD5A>#A2CD5A</OPTION>
<OPTION style="background-color: #6E8B3D" value=6E8B3D>#6E8B3D</OPTION>
<OPTION style="background-color: #FFF68F" value=FFF68F>#FFF68F</OPTION>
<OPTION style="background-color: #EEE685" value=EEE685>#EEE685</OPTION>
<OPTION style="background-color: #CDC673" value=CDC673>#CDC673</OPTION>
<OPTION style="background-color: #8B864E" value=8B864E>#8B864E</OPTION>
<OPTION style="background-color: #FFEC8B" value=FFEC8B>#FFEC8B</OPTION>
<OPTION style="background-color: #EEDC82" value=EEDC82>#EEDC82</OPTION>
<OPTION style="background-color: #CDBE70" value=CDBE70>#CDBE70</OPTION>
<OPTION style="background-color: #8B814C" value=8B814C>#8B814C</OPTION>
<OPTION style="background-color: #FFFFE0" value=FFFFE0>#FFFFE0</OPTION>
<OPTION style="background-color: #EEEED1" value=EEEED1>#EEEED1</OPTION>
<OPTION style="background-color: #CDCDB4" value=CDCDB4>#CDCDB4</OPTION>
<OPTION style="background-color: #8B8B7A" value=8B8B7A>#8B8B7A</OPTION>
<OPTION style="background-color: #FFFF00" value=FFFF00>#FFFF00</OPTION>
<OPTION style="background-color: #EEEE00" value=EEEE00>#EEEE00</OPTION>
<OPTION style="background-color: #CDCD00" value=CDCD00>#CDCD00</OPTION>
<OPTION style="background-color: #8B8B00" value=8B8B00>#8B8B00</OPTION>
<OPTION style="background-color: #FFD700" value=FFD700>#FFD700</OPTION>
<OPTION style="background-color: #EEC900" value=EEC900>#EEC900</OPTION>
<OPTION style="background-color: #CDAD00" value=CDAD00>#CDAD00</OPTION>
<OPTION style="background-color: #8B7500" value=8B7500>#8B7500</OPTION>
<OPTION style="background-color: #FFC125" value=FFC125>#FFC125</OPTION>
<OPTION style="background-color: #EEB422" value=EEB422>#EEB422</OPTION>
<OPTION style="background-color: #CD9B1D" value=CD9B1D>#CD9B1D</OPTION>
<OPTION style="background-color: #8B6914" value=8B6914>#8B6914</OPTION>
<OPTION style="background-color: #FFB90F" value=FFB90F>#FFB90F</OPTION>
<OPTION style="background-color: #EEAD0E" value=EEAD0E>#EEAD0E</OPTION>
<OPTION style="background-color: #CD950C" value=CD950C>#CD950C</OPTION>
<OPTION style="background-color: #8B658B" value=8B658B>#8B658B</OPTION>
<OPTION style="background-color: #FFC1C1" value=FFC1C1>#FFC1C1</OPTION>
<OPTION style="background-color: #EEB4B4" value=EEB4B4>#EEB4B4</OPTION>
<OPTION style="background-color: #CD9B9B" value=CD9B9B>#CD9B9B</OPTION>
<OPTION style="background-color: #8B6969" value=8B6969>#8B6969</OPTION>
<OPTION style="background-color: #FF6A6A" value=FF6A6A>#FF6A6A</OPTION>
<OPTION style="background-color: #EE6363" value=EE6363>#EE6363</OPTION>
<OPTION style="background-color: #CD5555" value=CD5555>#CD5555</OPTION>
<OPTION style="background-color: #8B3A3A" value=8B3A3A>#8B3A3A</OPTION>
<OPTION style="background-color: #FF8247" value=FF8247>#FF8247</OPTION>
<OPTION style="background-color: #EE7942" value=EE7942>#EE7942</OPTION>
<OPTION style="background-color: #CD6839" value=CD6839>#CD6839</OPTION>
<OPTION style="background-color: #8B4726" value=8B4726>#8B4726</OPTION>
<OPTION style="background-color: #FFD39B" value=FFD39B>#FFD39B</OPTION>
<OPTION style="background-color: #EEC591" value=EEC591>#EEC591</OPTION>
<OPTION style="background-color: #CDAA7D" value=CDAA7D>#CDAA7D</OPTION>
<OPTION style="background-color: #8B7355" value=8B7355>#8B7355</OPTION>
<OPTION style="background-color: #FFE7BA" value=FFE7BA>#FFE7BA</OPTION>
<OPTION style="background-color: #EED8AE" value=EED8AE>#EED8AE</OPTION>
<OPTION style="background-color: #CDBA96" value=CDBA96>#CDBA96</OPTION>
<OPTION style="background-color: #8B7E66" value=8B7E66>#8B7E66</OPTION>
<OPTION style="background-color: #FFA54F" value=FFA54F>#FFA54F</OPTION>
<OPTION style="background-color: #EE9A49" value=EE9A49>#EE9A49</OPTION>
<OPTION style="background-color: #CD853F" value=CD853F>#CD853F</OPTION>
<OPTION style="background-color: #8B5A2B" value=8B5A2B>#8B5A2B</OPTION>
<OPTION style="background-color: #FF7F24" value=FF7F24>#FF7F24</OPTION>
<OPTION style="background-color: #EE7621" value=EE7621>#EE7621</OPTION>
<OPTION style="background-color: #CD661D" value=CD661D>#CD661D</OPTION>
<OPTION style="background-color: #8B4513" value=8B4513>#8B4513</OPTION>
<OPTION style="background-color: #FF3030" value=FF3030>#FF3030</OPTION>
<OPTION style="background-color: #EE2C2C" value=EE2C2C>#EE2C2C</OPTION>
<OPTION style="background-color: #CD2626" value=CD2626>#CD2626</OPTION>
<OPTION style="background-color: #8B1A1A" value=8B1A1A>#8B1A1A</OPTION>
<OPTION style="background-color: #FF4040" value=FF4040>#FF4040</OPTION>
<OPTION style="background-color: #EE3B3B" value=EE3B3B>#EE3B3B</OPTION>
<OPTION style="background-color: #CD3333" value=CD3333>#CD3333</OPTION>
<OPTION style="background-color: #8B2323" value=8B2323>#8B2323</OPTION>
<OPTION style="background-color: #FF8C69" value=FF8C69>#FF8C69</OPTION>
<OPTION style="background-color: #EE8262" value=EE8262>#EE8262</OPTION>
<OPTION style="background-color: #CD7054" value=CD7054>#CD7054</OPTION>
<OPTION style="background-color: #8B4C39" value=8B4C39>#8B4C39</OPTION>
<OPTION style="background-color: #FFA07A" value=FFA07A>#FFA07A</OPTION>
<OPTION style="background-color: #EE9572" value=EE9572>#EE9572</OPTION>
<OPTION style="background-color: #CD8162" value=CD8162>#CD8162</OPTION>
<OPTION style="background-color: #8B5742" value=8B5742>#8B5742</OPTION>
<OPTION style="background-color: #FFA500" value=FFA500>#FFA500</OPTION>
<OPTION style="background-color: #EE9A00" value=EE9A00>#EE9A00</OPTION>
<OPTION style="background-color: #CD8500" value=CD8500>#CD8500</OPTION>
<OPTION style="background-color: #8B5A00" value=8B5A00>#8B5A00</OPTION>
<OPTION style="background-color: #FF7F00" value=FF7F00>#FF7F00</OPTION>
<OPTION style="background-color: #EE7600" value=EE7600>#EE7600</OPTION>
<OPTION style="background-color: #CD6600" value=CD6600>#CD6600</OPTION>
<OPTION style="background-color: #8B4500" value=8B4500>#8B4500</OPTION>
<OPTION style="background-color: #FF7256" value=FF7256>#FF7256</OPTION>
<OPTION style="background-color: #EE6A50" value=EE6A50>#EE6A50</OPTION>
<OPTION style="background-color: #CD5B45" value=CD5B45>#CD5B45</OPTION>
<OPTION style="background-color: #8B3E2F" value=8B3E2F>#8B3E2F</OPTION>
<OPTION style="background-color: #FF6347" value=FF6347>#FF6347</OPTION>
<OPTION style="background-color: #EE5C42" value=EE5C42>#EE5C42</OPTION>
<OPTION style="background-color: #CD4F39" value=CD4F39>#CD4F39</OPTION>
<OPTION style="background-color: #8B3626" value=8B3626>#8B3626</OPTION>
<OPTION style="background-color: #FF4500" value=FF4500>#FF4500</OPTION>
<OPTION style="background-color: #EE4000" value=EE4000>#EE4000</OPTION>
<OPTION style="background-color: #CD3700" value=CD3700>#CD3700</OPTION>
<OPTION style="background-color: #8B2500" value=8B2500>#8B2500</OPTION>
<OPTION style="background-color: #FF0000" value=FF0000>#FF0000</OPTION>
<OPTION style="background-color: #EE0000" value=EE0000>#EE0000</OPTION>
<OPTION style="background-color: #CD0000" value=CD0000>#CD0000</OPTION>
<OPTION style="background-color: #8B0000" value=8B0000>#8B0000</OPTION>
<OPTION style="background-color: #FF1493" value=FF1493>#FF1493</OPTION>
<OPTION style="background-color: #EE1289" value=EE1289>#EE1289</OPTION>
<OPTION style="background-color: #CD1076" value=CD1076>#CD1076</OPTION>
<OPTION style="background-color: #8B0A50" value=8B0A50>#8B0A50</OPTION>
<OPTION style="background-color: #FF6EB4" value=FF6EB4>#FF6EB4</OPTION>
<OPTION style="background-color: #EE6AA7" value=EE6AA7>#EE6AA7</OPTION>
<OPTION style="background-color: #CD6090" value=CD6090>#CD6090</OPTION>
<OPTION style="background-color: #8B3A62" value=8B3A62>#8B3A62</OPTION>
<OPTION style="background-color: #FFB5C5" value=FFB5C5>#FFB5C5</OPTION>
<OPTION style="background-color: #EEA9B8" value=EEA9B8>#EEA9B8</OPTION>
<OPTION style="background-color: #CD919E" value=CD919E>#CD919E</OPTION>
<OPTION style="background-color: #8B636C" value=8B636C>#8B636C</OPTION>
<OPTION style="background-color: #FFAEB9" value=FFAEB9>#FFAEB9</OPTION>
<OPTION style="background-color: #EEA2AD" value=EEA2AD>#EEA2AD</OPTION>
<OPTION style="background-color: #CD8C95" value=CD8C95>#CD8C95</OPTION>
<OPTION style="background-color: #8B5F65" value=8B5F65>#8B5F65</OPTION>
<OPTION style="background-color: #FF82AB" value=FF82AB>#FF82AB</OPTION>
<OPTION style="background-color: #EE799F" value=EE799F>#EE799F</OPTION>
<OPTION style="background-color: #CD6889" value=CD6889>#CD6889</OPTION>
<OPTION style="background-color: #8B475D" value=8B475D>#8B475D</OPTION>
<OPTION style="background-color: #FF34B3" value=FF34B3>#FF34B3</OPTION>
<OPTION style="background-color: #EE30A7" value=EE30A7>#EE30A7</OPTION>
<OPTION style="background-color: #CD2990" value=CD2990>#CD2990</OPTION>
<OPTION style="background-color: #8B1C62" value=8B1C62>#8B1C62</OPTION>
<OPTION style="background-color: #FF3E96" value=FF3E96>#FF3E96</OPTION>
<OPTION style="background-color: #EE3A8C" value=EE3A8C>#EE3A8C</OPTION>
<OPTION style="background-color: #CD3278" value=CD3278>#CD3278</OPTION>
<OPTION style="background-color: #8B2252" value=8B2252>#8B2252</OPTION>
<OPTION style="background-color: #FF00FF" value=FF00FF>#FF00FF</OPTION>
<OPTION style="background-color: #EE00EE" value=EE00EE>#EE00EE</OPTION>
<OPTION style="background-color: #CD00CD" value=CD00CD>#CD00CD</OPTION>
<OPTION style="background-color: #8B008B" value=8B008B>#8B008B</OPTION>
<OPTION style="background-color: #FF83FA" value=FF83FA>#FF83FA</OPTION>
<OPTION style="background-color: #EE7AE9" value=EE7AE9>#EE7AE9</OPTION>
<OPTION style="background-color: #CD69C9" value=CD69C9>#CD69C9</OPTION>
<OPTION style="background-color: #8B4789" value=8B4789>#8B4789</OPTION>
<OPTION style="background-color: #FFBBFF" value=FFBBFF>#FFBBFF</OPTION>
<OPTION style="background-color: #EEAEEE" value=EEAEEE>#EEAEEE</OPTION>
<OPTION style="background-color: #CD96CD" value=CD96CD>#CD96CD</OPTION>
<OPTION style="background-color: #8B668B" value=8B668B>#8B668B</OPTION>
<OPTION style="background-color: #E066FF" value=E066FF>#E066FF</OPTION>
<OPTION style="background-color: #D15FEE" value=D15FEE>#D15FEE</OPTION>
<OPTION style="background-color: #B452CD" value=B452CD>#B452CD</OPTION>
<OPTION style="background-color: #7A378B" value=7A378B>#7A378B</OPTION>
<OPTION style="background-color: #BF3EFF" value=BF3EFF>#BF3EFF</OPTION>
<OPTION style="background-color: #B23AEE" value=B23AEE>#B23AEE</OPTION>
<OPTION style="background-color: #9A32CD" value=9A32CD>#9A32CD</OPTION>
<OPTION style="background-color: #68228B" value=68228B>#68228B</OPTION>
<OPTION style="background-color: #9B30FF" value=9B30FF>#9B30FF</OPTION>
<OPTION style="background-color: #912CEE" value=912CEE>#912CEE</OPTION>
<OPTION style="background-color: #7D26CD" value=7D26CD>#7D26CD</OPTION>
<OPTION style="background-color: #551A8B" value=551A8B>#551A8B</OPTION>
<OPTION style="background-color: #AB82FF" value=AB82FF>#AB82FF</OPTION>
<OPTION style="background-color: #9F79EE" value=9F79EE>#9F79EE</OPTION>
<OPTION style="background-color: #8968CD" value=8968CD>#8968CD</OPTION>
<OPTION style="background-color: #5D478B" value=5D478B>#5D478B</OPTION>
<OPTION style="background-color: #FFE1FF" value=FFE1FF>#FFE1FF</OPTION>
<OPTION style="background-color: #EED2EE" value=EED2EE>#EED2EE</OPTION>
<OPTION style="background-color: #CDB5CD" value=CDB5CD>#CDB5CD</OPTION>
<OPTION style="background-color: #8B7B8B" value=8B7B8B>#8B7B8B</OPTION>
<OPTION style="background-color: #1C1C1C" value=1C1C1C>#1C1C1C</OPTION>
<OPTION style="background-color: #363636" value=363636>#363636</OPTION>
<OPTION style="background-color: #4F4F4F" value=4F4F4F>#4F4F4F</OPTION>
<OPTION style="background-color: #696969" value=696969>#696969</OPTION>
<OPTION style="background-color: #828282" value=828282>#828282</OPTION>
<OPTION style="background-color: #9C9C9C" value=9C9C9C>#9C9C9C</OPTION>
<OPTION style="background-color: #B5B5B5" value=B5B5B5>#B5B5B5</OPTION>
<OPTION style="background-color: #CFCFCF" value=CFCFCF>#CFCFCF</OPTION>
<OPTION style="background-color: #E8E8E8" value=E8E8E8>#E8E8E8</OPTION>
<OPTION style="background-color: #A9A9A9" value=A9A9A9>#A9A9A9</OPTION>
<OPTION style="background-color: #00008B" value=00008B>#00008B</OPTION>
<OPTION style="background-color: #008B8B" value=008B8B>#008B8B</OPTION>
<OPTION style="background-color: #8B008B" value=8B008B>#8B008B</OPTION>
<OPTION style="background-color: #8B0000" value=8B0000>#8B0000</OPTION>
<OPTION style="background-color: #90EE90" value=90EE90>#90EE90</OPTION>
</SELECT>
<div class="clear"></div>

<div class="margin_top_10"></div><div class="allbar_title">Логотип в шапке 65x47</div>
<form id="form2" action="/index.php?go=settings&act=upload_logo" method="post" enctype="multipart/form-data">
 <div id="prces2" class="no_display" style="height:8px">
  <div style="position:absolute;background:#fff;border:1px solid #cccccc;width:198px;height:18px;margin-bottom:10px"></div>
  <div style="background:url('/templates/Old/images/progress_grad.gif?1');border:1px solid #45688e;height:18px;position:absolute;" id="uploadproc2"></div>
  <div style="position:absolute;width:198px;height:18px;margin-bottom:10px;font-weight:bold;text-align:center;padding-top:3px;color:#d0e7f7;" id="prctex2">0%</div>
 </div>
 <input type="file" name="uploadfile" id="uploadfile2" class="inpst" accept="image/*" style="width:200px" /><br />
 <small>Файл не должен превышать 5 Mб. Если у Вас возникают проблемы с загрузкой, попробуйте использовать фотографию меньшего размера.</small>
</form>
<div class="clear"></div>

<div class="margin_top_10"></div><div class="allbar_title">Действия</div>
<div class="err_yellow no_display" id="ok" style="font-weight:normal;">Настройки сохранены.</div>
<div class="button_div fl_l" style="margin-right:10px"><button onClick="design.save(); return false" id="save">Сохранить</button></div>
<div class="button_div_gray fl_l"><button onClick="design.clear(); return false" id="save">Сбросить настройки дизайна</button></div>
<div class="clear"></div>