
<div class="box">
	<div class="box-body">
		<span class="text-center mb20"><?php echo lang('in_db_test'); ?></span>
		<?php $DBconfigFile = (APPPATH . 'config/database.php');
	
			if($_POST){
				$host = $_POST["db_host"];
				$username = $_POST["db_user"];
				$password = $_POST["db_pass"];
				$dbname = $_POST["db_name"];
				$link = @mysql_connect($host, $username, $password);
				// Check connection


				if (!$link) {
					echo "<div class='alert alert-error'>Could not connect to MYSQL! Check your settings.</div>";
				}else{
				echo '<div class="alert alert-success">Connection to MYSQL successful!</div>';
				
				$db_selected = @mysql_select_db($dbname, $link);
				if (!$db_selected) {
					if(!mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname` /*!40100 CHARACTER SET utf8 COLLATE 'utf8_general_ci' */")){
						echo "<div class='alert alert-error'>Database ".$dbname." does not exist and could not be created. Please create the Database manually and retry this step.</div>";
						return FALSE;
					}else{ echo "<div class='alert alert-success'>Database ".$dbname." created</div>";}
				}
					mysql_select_db($dbname);
					
			
			function write_dbconfig($host, $username, $password,$dbname,$DBconfigFile){

				$newcontent = '<?php  if ( !defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
								/*
								| -------------------------------------------------------------------
								| DATABASE CONNECTIVITY SETTINGS
								| -------------------------------------------------------------------
								| This file will contain the settings needed to access your database.
								|
								| For complete instructions please consult the \'Database Connection\'
								| page of the User Guide.
								|
								*/

								
										$active_group = \'default\';

										if (defined(\'CI_VERSION\') && substr(CI_VERSION, 0, 1) != 2) {
											// CodeIgniter 3 configuration
											
											$query_builder = true;
											
											$db[\'default\'][\'dsn\']      = \'\';
											$db[\'default\'][\'hostname\'] = \''.$host.'\';
											$db[\'default\'][\'username\'] = \''.$username.'\';
											$db[\'default\'][\'password\'] = \''.$password.'\';
											$db[\'default\'][\'database\'] = \''.$dbname.'\';
											$db[\'default\'][\'dbdriver\'] = \'mysqli\';
											$db[\'default\'][\'dbprefix\'] = \'\';
											$db[\'default\'][\'pconnect\'] = FALSE; // not supported with the database session driver
											$db[\'default\'][\'db_debug\'] = TRUE;
											$db[\'default\'][\'cache_on\'] = FALSE;
											$db[\'default\'][\'cachedir\'] = \'\';
											$db[\'default\'][\'char_set\'] = \'utf8\';
											$db[\'default\'][\'dbcollat\'] = \'utf8_general_ci\';
											$db[\'default\'][\'swap_pre\'] = \'\';
											$db[\'default\'][\'encrypt\']  = FALSE;
											$db[\'default\'][\'compress\'] = FALSE;
											$db[\'default\'][\'stricton\'] = FALSE;
											$db[\'default\'][\'failover\'] = array();
											$db[\'default\'][\'save_queries\'] = TRUE;
											$db[\'default\'][\'autoinit\'] = TRUE;
											$db[\'default\'][\'stricton\'] = FALSE;
											
										} else {
											// CodeIgniter 2 configuration
											$active_record = TRUE;
												
											$db[\'default\'][\'hostname\'] = \''.$host.'\';
											$db[\'default\'][\'username\'] = \''.$username.'\';
											$db[\'default\'][\'password\'] = \''.$password.'\';
											$db[\'default\'][\'database\'] = \''.$dbname.'\';
											$db[\'default\'][\'dbdriver\'] = \'mysqli\';
											$db[\'default\'][\'dbprefix\'] = \'\';
											$db[\'default\'][\'pconnect\'] = TRUE;
											$db[\'default\'][\'db_debug\'] = TRUE;
											$db[\'default\'][\'cache_on\'] = FALSE;
											$db[\'default\'][\'cachedir\'] = \'\';
											$db[\'default\'][\'char_set\'] = \'utf8\';
											$db[\'default\'][\'dbcollat\'] = \'utf8_general_ci\';
											$db[\'default\'][\'swap_pre\'] = \'\';
											$db[\'default\'][\'autoinit\'] = TRUE;
											$db[\'default\'][\'stricton\'] = FALSE;
										}


								/* End of file database.php */
								/* Location: ./application/config/database.php */
								';


				$file_contents = file_get_contents($DBconfigFile);
				$fh = fopen($DBconfigFile, "w");
				$file_contents = $newcontent;
				if(fwrite($fh, $file_contents)){
					return true;
				}
				fclose($fh);

			}
			if(!write_dbconfig($host,$username,$password,$dbname,$DBconfigFile)){
					echo "<div class='alert alert-error'>Failed to write config to ".$DBconfigFile."</div>";
			}else{ echo "<div class='alert alert-success'>Database config written to the database file.</div>"; }
			}
			}else{echo "<div class='alert alert-success'>Nothing to do...</div>";}
			?>
			<?php if (!$link) {?>
			<a href="dbsetup" class="btn btn-blue fr"><?php echo lang('in_go_back'); ?></a>
			<?php } else { ?>
			<a href="install/dbinstall" class="btn btn-blue fr"><?php echo lang('in_install_btn'); ?></a>
			<?php }?>
			
	</div>
</div>				