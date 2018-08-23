<?php


	
	$dbname = !isset($_POST['dbname'])? '' : $_POST['dbname'];
	$dbhost = !isset($_POST['dbhost'])? '' : $_POST['dbhost'];
	$dbuser = !isset($_POST['dbuser'])? '' : $_POST['dbuser'];
	$dbpass = !isset($_POST['dbpass'])? '' : $_POST['dbpass'];
	$url 	= isset($_POST['url'])? $_POST['url'] : $_SERVER['HTTP_HOST'] . str_replace('/install.php', '', $_SERVER['REQUEST_URI']);
	$admin = !isset($_POST['admin'])? '' : $_POST['admin'];
?>
<html>
	<head>
		<title>Установка файлового хостинга</title>
		<link href='http://fonts.googleapis.com/css?family=Alef' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/ui.css" />
		<style>
			*{margin: 0; padding: 0;}
			html, body{
				background: #fafafa;
				font-family: 'Alef', sans-serif;
			}
			.wrapper{
				margin: 25px auto;
				width: 750px;
				background: #ffffff;
				border: 1px solid #ededed;
				border-radius: 3px;
			}
			.header{
				padding: 10px;
				border-bottom: 1px solid #ededed;
				background: #f9f9f9;
				position: relative;
			}
			.section{
				padding: 10px;
				border-bottom: 1px solid #ededed;
			}
			ul{
				margin-left: 20px;
			}
			li{
				list-style-type: circle;
			}
			.form-left{
				width: 300px;
				float: left;
				text-align: right;
				margin-right: 10px;
			}
			.form-left p{
				padding: 6px 0 6px 0;
			}
			.form-right{
				width: 350px;
				float: left;
			}
			.clear{ clear: both; }
			hr{
				border: 0;
				height: 1px;
				background: #e9e9e9;
				margin: 15px 10px 15px 10px;
			}
			.big{
				font-size: 18px;
			}
			.center{
				text-align: center;
			}
			h2{
				text-transform: capitalize;
				margin-bottom: 10px;
			}
			.space{
				margin: 8px 0 8px 0;
				text-transform: capitalize;
			}
			.link{
				position: absolute;
				top: 5;
				right: 5;
			}
			.light{
				color: #a5a5a5;
			}
			.footer{
				text-align: center;
				color: #bebebe;
				margin: 10px 0 10px 0;
			}
			.footer a{
				color: #bebebe;
			}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<h1>Установка</h1>
				<a href="http://wm-scripts.ru" class="ui-button-blue big link">Скачать скрипты сайта</a>
			</div>
			<div class="section">
				<h2>Требования</h2>
				<ul>
					<li>PHP 5.2 or later <span class="light">(your current version is <?=phpversion()?>)</span></li>
					<li>MySQL 5</li>
					<li>Apache w/ mod_rewrite</li>
				</ul>
			</div>
			<div class="section">
				<h2>enter your installation details</h2>
				<div class="form-left">
					<p>Database Name</p>
					<p>Database Host Address</p>
					<p>Database Username</p>
					<p>Database Password</p>
					<hr/>
					<p>Your Website URL</p>
					<hr/>
					<p>Create An Admin Password</p>
				</div>
				<div class="form-right">
				<form action="#" method="post">
					<input class="ui" name="dbname" size="45" type="text" placeholder="database name" value="<?=$dbname?>" />
					<input class="ui" name="dbhost" size="45" type="text" placeholder="yourdatabaseurl.host.com" value="<?=$dbhost?>"/>
					<input class="ui" name="dbuser" size="45" type="text" placeholder="username" value="<?=$dbuser?>"/>
					<input class="ui" name="dbpass" size="45" type="password" placeholder="password" value="<?=$dbpass?>" />
					<hr/>
					<input class="ui" name="url" size="45" type="text" value="<?=$url?>" />
					<hr/>
					<input class="ui" name="admin" size="45" type="password" value="<?=$admin?>" placeholder="password" />
				</div>
				<div class="clear"></div>
			</div>
			<?php
			if(isset($_POST['submit']))
			{
				echo '<div class="section">';
				echo "<h2>Installing</h2>";
				
				$errors = array();
				$success = array();
				
				if(empty($_POST['dbname'])) $errors[] = "please enter your database name";
				if(empty($_POST['dbhost'])) $errors[] = "please enter your database host address";
				if(empty($_POST['dbuser'])) $errors[] = "please enter your database username";
				if(empty($_POST['dbpass'])) $errors[] = "please enter your database password";
				if(empty($_POST['url'])) $errors[] = "url";
				if(empty($_POST['admin'])) $errors[] = "please create and administrator password";
				
				//check for .htaccess
				if( !file_exists('.htaccess') ) 
					$errors[] = "the .htaccess file not found";
				else
					$success[] = "the .htaccess file was found";
				
				//test MySQL connection
				try{
					$db = new PDO('mysql:dbname='.$_POST['dbname'].';host='.$_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass']);
					$success[] = "database connection successful";
					
					$db->query("CREATE TABLE `details` (
						  `file_id` int(11) unsigned NOT NULL auto_increment,
						  `date` datetime NOT NULL,
						  `name` varchar(65) NOT NULL,
						  `size` int(11) unsigned NOT NULL,
						  `type` varchar(65) NOT NULL,
						  
						  `public` tinyint(1) NOT NULL default '0',
						  `flag` tinyint(1) NOT NULL default '0',
						  `deleted` tinyint(1) NOT NULL default '0',
						  
						  `last_access_date` datetime NOT NULL,
						  `password` varchar(40) NOT NULL default '0',
						  `views` int(11) unsigned NOT NULL default '0',
						  PRIMARY KEY  (`file_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
						
						
					$db->query("CREATE TABLE `share` (
						  `shortURL` varchar(32) NOT NULL,
						  `file_id` int(11) unsigned NOT NULL,
						  PRIMARY KEY  (`shortURL`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
								
					$db->query("CREATE TABLE `tags` (
						  `tag_id` int(11) unsigned NOT NULL auto_increment,
						  `tag_name` varchar(65) NOT NULL UNIQUE,
						  PRIMARY KEY  (`tag_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
						
					$db->query("CREATE TABLE `fid-tid` (
						  `file_id` int(11) unsigned NOT NULL,
						  `tag_id` int(11) unsigned NOT NULL,
						  PRIMARY KEY  (`file_id`,`tag_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
						
					$db->query("CREATE TABLE `logs` (
						  `id` int(11) unsigned NOT NULL auto_increment,
						  `date` datetime NOT NULL,
						  `action` varchar(25) NOT NULL,
						  `ip` int(11) NOT NULL,
						  `data` varchar(255) NOT NULL,
						  PRIMARY KEY  (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
				
				}catch (PDOException $e){
					$errors[] = 'database connection failed: ' . $e->getMessage();
				}
							
				//create config
				$config = file_get_contents('config.inc.php');
				$find = array(
					'**database_name**',
					'**database_host**',
					'**database_user**',
					'**database_pass**',
					'**your_url**',
					'**admin_password**'
				);
				$replace = array(
					$_POST['dbname'],
					$_POST['dbhost'],
					$_POST['dbuser'],
					$_POST['dbpass'],
					$_POST['url'],
					$_POST['admin']
				);
				$config = str_replace($find, $replace, $config);				
				if( count($errors) == 0 and file_put_contents('config.inc.php', $config) )
					$success[] = "the config.inc.php file was successfully modified";
				else
					$errors[] = 'the config.inc.php file was not modified';
		
				foreach($errors as $message)
					echo '<div class="ui-message-red space">'.$message.'</div>';
				foreach($success as $message)
					echo '<div class="ui-message-green space">'.$message.'</div>';
				
				
				if( count($errors) == 0)
				{
					//check version
					
						
					echo '<div class="ui-message-green space"><strong>Files has been successfully installed</strong></div>';
					echo '<div class="ui-message-green space">Please delete this install.php file!</div>';
					echo '<p>You can now begin using Files at <a href="http://'.$_POST['url'].'">'.$_POST['url'].'</a> or enter the editor dashboard at <a href="http://'.$_POST['url'].'/editor">'.$_POST['url'].'/editor</a>.</p>';
				}
				echo "</div>";
			}
			?>
			<div class="section">
				<p class="center">
					<input type="submit" name="submit" value="Install Script" class="ui-button-green big" />
				</p>
				</form>
			</div>
		</div>
		<div class="footer">
			&copy; 2013 <a href="http://wm-scripts.ru">http://wm-scripts.ru</a>
		</div>
	</body>
</html>