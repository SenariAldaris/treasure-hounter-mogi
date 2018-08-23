<?php
/*================================================= 
	Appointment: Вывод формы регистрации на главной
	File: register_main.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
=================================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

	    if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
            $gcount = 6;
            $limit_page =($page-1)*$gcount;
           

                    $sql_query = "SELECT SQL_CALC_FOUND_ROWS user_id, user_search_pref, user_reg_date, user_photo FROM `".PREFIX."_users` WHERE user_search_pref LIKE '%{$query}%' {$sql_sort} ORDER BY `user_reg_date` DESC LIMIT {$limit_page}, {$gcount}";
           
                    if($sql_query)
                    $sql_ = $db->super_query($sql_query, 1);
           
//* Загружаем шаблон на вывод если он есть одного юзера и выводим *//
			
            if($sql_){
           
                            $tpl->load_template('new/new_users.tpl');
                            foreach($sql_ as $row){
                                    $tpl->set('{user-id}', $row['user_id']);
                                    $tpl->set('{name}', $row['user_search_pref']);
                                    if($row['user_photo'])
                                            $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
                                    else
                                            $tpl->set('{ava}', '{theme}/images/100_no_ava.png');
                                           
                                            $tpl->compile('usernew');
                            }

    }
$tpl->load_template('reg.tpl');

//* Загружаем Страны *//

$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
foreach($sql_country as $row_country)
	$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
			
$tpl->set('{country}', $all_country);

$tpl->compile('content');
?>