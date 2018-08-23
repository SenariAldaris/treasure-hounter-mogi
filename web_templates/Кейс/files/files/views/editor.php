<?php
/* File:	BitDrop - editor.php - v1.4
 * Date:	June 17, 2013
 * Copyright (C) 2013 by http://codeeverywhere.ca
 */
session_start();

include('../bitdrop.class.php');

//If password is good, then authenticate
if(isset($_POST['submit']) and isset($_POST['password']) and $_POST['password'] == editorPass){ $_SESSION['auth'] = true; }

//If logout is set, destroy the session
if( isset($_GET['logout']) ){ $_SESSION['auth'] = false; session_destroy(); }

//If authenticated show the editor else show login form
if(!isset($_GET['logout']) and $_SESSION['auth'] == true):
?>
<!DOCTYPE html>
<html>
	<head>
		<title>editor dashboard - <?=serviceName?></title>
		
		<link rel="stylesheet" type="text/css" href="css/bitdrop.css" />
		<link rel="stylesheet" type="text/css" href="css/ui.css" />
		
		<script type="text/javascript" src="js/numericalize.js"></script>
		<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
	</head>
	
	<script type="text/javascript">
	$(function()
	{
		var html;
		$.each($.parseJSON('<?=$bitdrop->getData('admin')?>'), function(i, file)
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
			<td>\
			<a href="#" title="show shortURL history" class="showHistory">?</a>\
			<a href="#" title="reset the upload date" class="reset">&plus;</a>\
			<a href="#" title="delete this file" class="delete">&times;</a>\
			</td>\
			</tr>';
		$('#admin > tbody').append(html);
		});
		
		var json = $.parseJSON('<?=$bitdrop->getData('total')?>');
		$('#admin-files').text(json[0].count + ' files');		
		$('#admin-size').text(json[0].sum);
		
		//--
		$('.delete').click(function(e)
		{
			e.preventDefault();
			var row = $(this).parent().parent();
			row.css('background', '#efc223');
			$.ajax({
				type: "POST",
				url: 'controller.php?method=delete',
				data: 'shortURL=' + $('td:nth-child(3)', row).text(),
				success: function(response)
				{
					console.log( response );
					row.css('background', '#FF6666');
					row.fadeOut(250, function(){ $(this).remove() });
				}
			});
		});
		//--
		
		//--
		$('.deleteAllExpired').click(function(e)
		{
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: 'controller.php?method=deleteAllExpired',
				success: function(response)
				{
					console.log( response );
					location.reload();
				}
			});
		});
		//--
		
		//--
		$('.reset').click(function(e)
		{
			e.preventDefault();
			var row = $(this).parent().parent();
			row.css('background', '#efc223');
			$.ajax({
				type: "POST",
				url: 'controller.php?method=reset',
				data: 'shortURL=' + $('td:nth-child(3)', row).text(),
				success: function(response)
				{
					console.log( response );
					row.css('background', 'none');
					$('td:nth-child(4)', row).html('<span class="ui-label-green">Reset</span>');
				}
			});
		});
		//--
		
		
		//--
		$('.history').hide();
		$('.showHistory').click(function(e)
		{
			$('.history tbody').empty();
			e.preventDefault();
			var row = $(this).parent().parent();
			$.ajax({
				type: "POST",
				dataType: "json",
				url: 'controller.php?method=history',
				data: 'shortURL=' + $('td:nth-child(3)', row).text(),
				success: function(res)
				{
					var html, temp;
					$.each(res, function(i, k)
					{
						html += '<tr>';
						$.each(k, function(x, e)
						{
							if(typeof e === 'object')
							{
								temp = '';
								$.each(e, function(i){ temp += i +' : '+ e[i] + '<br/>' ; });
								e = temp;
							}
							html += '<td>' + e + '</td>';
						});
						html += '<tr>';
					});
					$('.history tbody').append(html);
					$('.history').slideDown(500);
				}
			});
		});
		//--
		
		
		//--
		$('.logs').hide();
		$('.showLogs').click(function(e)
		{
			$('.logs tbody').empty();
			e.preventDefault();
			$.ajax({
				dataType: "json",
				url: 'controller.php?method=logs',
				success: function(res)
				{
					var html, temp;
					$.each(res, function(i, k)
					{
						html += '<tr>';
						$.each(k, function(x, e)
						{
							if(typeof e === 'object')
							{
								temp = '';
								$.each(e, function(i){ temp += i +' : '+ e[i] + '<br/>' ; });
								e = temp;
							}
							html += '<td>' + e + '</td>';
						});
						html += '<tr>';
					});
					$('.logs tbody').append(html);
					$('.logs').slideDown(500);
				}
			});
		});
		//--
		
	});
	</script>
	<body>
	<noscript><h1>Please Enable JavaScript</h1></noscript>
	<div class="header">
		<div class="wrapper">
			<div class="left logo">
				<a href="<?=URLPrefix?>://<?=yourURL?>"><?=serviceName?></a>
			</div>
			<div class="right" style="font-size: 14px;">
				<a href="editor" class="ui-button-blue">Refresh</a>
				<a href="#" class="ui-button-blue showLogs">Show Log</a>
				<a href="#" class="ui-button-red deleteAllExpired">Delete All Expired</a>
				<a href="?logout" class="ui-button-black">Log Out</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	
	<div class="wrapper">
		<h1><?=serviceName?> is currently holding <span id="admin-files">X Files</span> totalling <span id="admin-size" class="data">0</span>.</h1>
	</div>
	


	<div class="wrapper box">
		<h3>Recent</h3>
			<table id="admin" class="ui-min" style="width: 100%;">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Size</th>
					<th>Link</th>
					<th>Expires</th>
					<th>
						<a href="#" class="showHistory">?</a>
						<a href="#" class="reset">&plus;</a>
						<a href="#" class="delete">&times;</a>
					</th>
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
		<hr/>
		<p class="ver verpush">You are currently running BitDrop v1.4 -- a <a href="http://codeeverywhere.ca">codeeverywhere</a> project</p>
	</div>
	
	
	<div class="history wrapper box">
		<h3>ShortURL History</h3>
		<table class="ui-min">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Action</th>
					<th>IP</th>
					<th>Data</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	
	
	<div class="logs wrapper box">
		<h3>Recent Logs (Last 25)</h3>
		<table class="ui-min">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Action</th>
					<th>IP</th>
					<th>Data</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	
	
	<div class="wrapper">
		<div class="footer"><?=bitdropFooter?></div>
	</div>
	
	</body>
</html>

<?php else: ?>

<!DOCTYPE html>
<html>
	<head>
		<title>editor dashboard - <?=serviceName?></title>
		
		<link rel="stylesheet" type="text/css" href="css/bitdrop.css" />
		<link rel="stylesheet" type="text/css" href="css/ui.css" />
	</head>
	<body>
	
	<div class="header">
		<div class="wrapper">
			<div class="left logo">
				<a href="<?=URLPrefix?>://<?=yourURL?>"><?=serviceName?></a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	
	<div class="wrapper">
		<h1>Welcome to the <?=serviceName?> editor dashboard, please log in.</h1>
	</div>
	
	<div class="wrapper box full">
		<?php 
			if( isset($_GET['logout']) ) { echo '<div class="ui-message-green">you have successfully logged out</div><hr/>'; }
			if( isset($_POST['submit']) ) { echo '<div class="ui-message-red">the password you entered is incorrect</div><hr/>'; }
		?>
		
		<form action="editor" method="post">
			Enter your editor password: 
			<input type="password" name="password" />
			<input type="submit" name="submit" value="Log In" style="font-size:14px;" class="ui-button-green" />
		</form>
		<hr/>
		<p class="ver">You are currently running BitDrop v1.4 -- a <a href="http://codeeverywhere.ca">codeeverywhere</a> project</p>
	</div>
	
	
	<div class="wrapper">
		<div class="footer"><?=bitdropFooter?></div>
	</div>
	
	</body>
</html>

<?php endif; ?>