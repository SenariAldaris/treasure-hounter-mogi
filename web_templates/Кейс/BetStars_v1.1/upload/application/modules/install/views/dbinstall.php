	<?php
				$this->load->database();
				#read default db sql file , parse all queries and run them
				$this->load->helper('file');
				$schema = read_file('./sql/betstars.sql');
				
				$schema = str_replace('db_tabprefix',$this->input->post('db_prefix'),$schema);
				$schema = str_replace('BASE_URL',base_url(),$schema);

				$query = rtrim( trim($schema), "\n;");
				$query_list = explode(";", $query);
							
				foreach($query_list as $query)
				{
				 	$this->db->query($query);
				}
				
				$filename = APPPATH . 'config/installed.txt';
				$msg = 'Installed On: ' . date('r') . "\n";
				write_file($filename, $msg);

				$config_array = array(
					'bs.installed' => true,
				);
				write_config('application', $config_array, '', APPPATH);
				
				redirect(site_url('install/success'));
				
				
?>	