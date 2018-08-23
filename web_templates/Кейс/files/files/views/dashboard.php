<?php


include('../bitdrop.class.php');
$uid = $bitdrop->createUniqueID();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Аккаунт - <?=serviceName?></title>
		
		<link rel="stylesheet" type="text/css" href="css/bitdrop.css" />
		<link rel="stylesheet" type="text/css" href="css/ui.css" />
		
		<script type="text/javascript" src="js/uploader.js"></script>
		<script type="text/javascript" src="js/numericalize.js"></script>
		<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	
	<script type="text/javascript">
	$(function()
	{
		var html;
		var json = $.parseJSON('<?=$bitdrop->getData('dash', $uid)?>');
		if( json.length > 0 )
		{
			$.each(json, function(i, file)
			{
				html = '<tr><td>';
			if(file.flag == 1) html += ' <img src="images/flag.png" alt="flag" width="14" height="14">';
			html += ' '+decodeURIComponent(file.name);
			html += ' <span class="icon-views">'+file.views+'</span>';
			if(file.public == 1) html += ' <span class="green">&bull;</span>';
			if(file.password == 1) html += ' <span class="yellow">&bull;</span>';
			html += '</td>\
			<td><span class="data">'+file.size+'</span></td>\
			<td><a href="'+file.link+'" class="link">'+file.link+'</a></td>\
			<td><span class="time-min">'+file.date+'</span></td>\
			</tr>';
			$('#dash > tbody').append(html);
			});
		}
		else
		{
			$('#dash > tbody').append('<tr><td colspan="4" class="empty">Your BitDrop is currently empty :(</td></tr>');
		}
		
	});
	</script>
	<body>
	<noscript><h1>Please Enable JavaScript</h1></noscript>
	<div class="header">
		<div class="wrapper">
			<div class="left logo">
				<a href="<?=URLPrefix?>://<?=yourURL?>"><?=serviceName?></a>
			</div>
			<div class="right dash">
				<a href="dashboard" >Аккаунт</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	
	<div class="wrapper">
		<h1>Здесь ваши последние добавленые файлы</h1>
	</div>
	
	
	<!--
<div class="wrapper box">
		<h3>Tags</h3>
		<table id="tags" class="ui-min" style="width: 100%;">
			<thead>
				<tr>
					<th>Название файла</th>
					<th>Размер</th>
					<th>Ссылка</th>
					<th>Хранение</th>
					<th><a href="#" class="delete">&minus;</a></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
-->


	<div class="wrapper box">
		<h3>Recent</h3>
			<table id="dash" class="ui-min" style="width: 100%;">
			<thead>
				<tr>
					<th>Название файла</th>
					<th>Размер</th>
					<th>Ссылка</th>
					<th>Хранение</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<p class="legend">Legend: 
			<span class="green">&bull;</span> Public | 
			<span class="yellow">&bull;</span> Password | 
			<img src="images/flag.png" alt="flag" width="14" height="14"> Flagged
		</p>
	</div>
	
	
	<div class="wrapper">
		<div class="id">Your unique identifier is <?=$uid?> </span> [<a title="The unique identifier is used to keep your upload history. If you clear your browsers cache you may loose your file history." href="#">?</a>]</div>
	</div>
	
	
	<div class="wrapper">
		<div class="footer">wm-scripts.ru</div>
	</div>
	
	
	</body>
</html>