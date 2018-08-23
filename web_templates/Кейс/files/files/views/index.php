<?php
/* File:	BitDrop - index.php - v1.4
 * Date:	June 17, 2013
 * Copyright (C) 2013 by http://codeeverywhere.ca
 */

include('../bitdrop.class.php');
$bitdrop->createUniqueID();
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=serviceName?> - загрузка файлов</title>
		
		<link rel="stylesheet" type="text/css" href="css/bitdrop.css" />
		<link rel="stylesheet" type="text/css" href="css/ui.css" />

		<script type="text/javascript" src="js/uploader.js"></script>
		<script type="text/javascript" src="js/numericalize.js"></script>
		<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
	<script type="text/javascript">
	if ( navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|Android)/i) ){ location.replace("m"); }
	$(function()
	{
		$.each($.parseJSON('<?=$bitdrop->getData('recent')?>'), function(i, file)
		{
			$('#recent > tbody').append('<tr><td><a href="'+file.shortURL+'">'+ decodeURIComponent(file.name) +'</a></td><td><span class="time-min">'+file.date+'</span></td></tr>');
		});
			
		$.each($.parseJSON('<?=$bitdrop->getData('popular')?>'), function(i, file)
		{
			$('#popular > tbody').append('<tr><td><a href="'+file.shortURL+'">'+ decodeURIComponent(file.name) +'</a></td><td><span class="icon-views">'+file.views+'</span></td></tr>');
		});
				
		$('.another').click(function(e)
		{
			e.preventDefault();
			$('.view-progress').fadeOut(500, function()
			{
	        	$('.view-form').fadeIn(300);	
			});
		});
	});
	</script>
	
	
	<div class="header">
		<div class="wrapper">
			<div class="left logo">
				<a href="index"><?=serviceName?></a>
			</div>
			<div class="right dash">
				<a href="dashboard" >Аккаунт</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	
	<div class="wrapper">
		<h1><?=serviceName?> allows you to upload and share files to anyone over the internet by using a simple short URL link</h1>
	</div>
	
	
	<div class="wrapper box">
		<div class="left">
			<div class="step">
				<div class="num">1</div>
				<h2>Загрузи файл размером не более <strong><span class="data-byte"><?=maxFileSize?></span></strong></h2>
			</div>
			<hr/>
			<div class="step">
				<div class="num">2</div>
				<h2>Файл у нас будет храниться не более <strong id="expire_after"><?=expireTime?></strong></h2>
			</div>
		</div>
		
		<div class="right form border">
			<!-- ========== -->
			<form id="form" name="form" action="upload.php" method="post" enctype="multipart/form-data" class="ui">
			
			<div class="view-form">
				<input type="hidden" name="MAX_FILE_SIZE" value="<?=maxFileSize?>" />
				<input name="files" id="files" type="file" class="ui input-file" />
				<input id="submit_btn" type="submit" value="Загрузить файл" class="ui-button-green input-btn" onclick="upload();"/>
				<iframe name="iframe" style="display:none;"></iframe>
				<input type="button" onclick="toggle();" value="Настройки" class="ui push" />
				<div id="bitdrop-options">
					<div>
						<input type="checkbox" name="bitdrop_share" value="share" /> Make file public 
						[<a href="#" title="by checking this box, this file will appear in public searches">?</a>]
					</div>
					<div>
						<label for="bitdrop_password">Добавить пароль:</label>
						<input type="password" name="bitdrop_password" size="17" placeholder="password" class="ui"/>
					</div>
				</div>
			</div>
			
			<div class="view-progress">
				<h4>your file is uploading</h4>
				<div id="progress_outline">
					<div id="progress_bar"><div id="progress_done"><div id="num">0%</div></div></div>
				</div>
				<a href="/" class="another">Загрузить другой файл</a>
			</div>
			
			<div class="view-uploaded">
				<h4>Файл успешно был загружен!</h4>
				<p>Ссылка</p>
			</div>
			
			</form>
			<!-- ========== -->
		</div>
		
		<div class="clear"></div>
	
	</div>
	
	
	<div class="wrapper">
		<div class="left box half">
			<h3>Последние загрузки</h3>
			<table id="recent" class="ui-min half" style="width: 100%;"><tbody></tbody></table>
		</div>
		<div class="right box half">
			<h3>Популярые файлы</h3>
			<table id="popular" class="ui-min half" style="width: 100%;"><tbody></tbody></table>
		</div>
		<div class="clear"></div>
	</div>
	
	
	<div class="wrapper">
		<div class="footer">wm-scripts.ru</div>
	</div>
	
	
	</body>
</html>