<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');
								/*
								| -------------------------------------------------------------------
								| DATABASE CONNECTIVITY SETTINGS
								| -------------------------------------------------------------------
								| This file will contain the settings needed to access your database.
								|
								| For complete instructions please consult the 'Database Connection'
								| page of the User Guide.
								|
								*/

								
										$active_group = 'default';

										if (defined('CI_VERSION') && substr(CI_VERSION, 0, 1) != 2) {
											// CodeIgniter 3 configuration
											
											$query_builder = true;
											
											$db['default']['dsn']      = '';
											$db['default']['hostname'] = 'localhost';
											$db['default']['username'] = 'root';
											$db['default']['password'] = '';
											$db['default']['database'] = 'betstars';
											$db['default']['dbdriver'] = 'mysqli';
											$db['default']['dbprefix'] = '';
											$db['default']['pconnect'] = FALSE; // not supported with the database session driver
											$db['default']['db_debug'] = TRUE;
											$db['default']['cache_on'] = FALSE;
											$db['default']['cachedir'] = '';
											$db['default']['char_set'] = 'utf8';
											$db['default']['dbcollat'] = 'utf8_general_ci';
											$db['default']['swap_pre'] = '';
											$db['default']['encrypt']  = FALSE;
											$db['default']['compress'] = FALSE;
											$db['default']['stricton'] = FALSE;
											$db['default']['failover'] = array();
											$db['default']['save_queries'] = TRUE;
											$db['default']['autoinit'] = TRUE;
											$db['default']['stricton'] = FALSE;
											
										} else {
											// CodeIgniter 2 configuration
											$active_record = TRUE;
												
											$db['default']['hostname'] = 'localhost';
											$db['default']['username'] = 'root';
											$db['default']['password'] = '';
											$db['default']['database'] = 'betstars';
											$db['default']['dbdriver'] = 'mysqli';
											$db['default']['dbprefix'] = '';
											$db['default']['pconnect'] = TRUE;
											$db['default']['db_debug'] = TRUE;
											$db['default']['cache_on'] = FALSE;
											$db['default']['cachedir'] = '';
											$db['default']['char_set'] = 'utf8';
											$db['default']['dbcollat'] = 'utf8_general_ci';
											$db['default']['swap_pre'] = '';
											$db['default']['autoinit'] = TRUE;
											$db['default']['stricton'] = FALSE;
										}


								/* End of file database.php */
								/* Location: ./application/config/database.php */
								