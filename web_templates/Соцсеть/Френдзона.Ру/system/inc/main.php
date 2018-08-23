<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_report`");
if($row['cnt']) $new_report = '<font color="red">('.$row['cnt'].')</font>';

$row_ver = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_verification` WHERE status = '1'");
if($row_ver['cnt']) $new_verification = '<font color="red">('.$row_ver['cnt'].')</font>';

$row_ver_2 = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_verification_communities`");
if($row_ver_2['cnt']) $new_verification_gr = '<font color="red">('.$row_ver_2['cnt'].')</font>';

$row_gifts = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_gifts_req` WHERE approve = 1");
if($row_gifts['cnt']){
	$new_gifts = '<font color="red">('.$row_gifts['cnt'].')</font>';
	$lnk = '&status=1';
}

$row_banners = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users_banners` WHERE approve = 1");
if($row_banners['cnt']){
	$new_banners = '<font color="red">('.$row_banners['cnt'].')</font>';
}

$row_games_ver = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_games_ver`");
if($row_games_ver['cnt']){
	$new_games_ver = '<font color="red">('.$row_games_ver['cnt'].')</font>';
}

echoheader();
echoblock('Настройка системы', 'Настройка общих параметров скрипта, а также настройка системы безопасности скрипта', 'system', 'settings');
echoblock('Управление БД', 'Резервное копирование и восстановление базы данных', 'db', 'db');
echoblock('Личные настройки', 'Управление и настройка вашего личного профиля пользователя.', 'mysettings', 'mysettings');
echoblock('Пользователи', 'Управление зарегистрированными на сайте пользователями, редактирование их профилей и блокировка аккаунта', 'users', 'users');
echoblock('Доп. поля профилей', 'В данном разделе проводится настройка дополнительных полей профиля пользователей', 'xfields', 'xfields');
echoblock('Игры от WebTomat', 'Редактирование каталога flash-игр от WebTomat', 'webtomat', 'webtomat');
echoblock('Видео', 'Управление видеозаписями, редактирование и удаление', 'videos', 'video');
echoblock('Музыка', 'Управление аудиозаписями, редактирование и удаление', 'musics', 'music');
echoblock('Альбомы', 'Управление альбомами, редактирование и удаление', 'albums', 'photos');
echoblock('Заметки', 'Управления заметками, которые опубликовали пользователи сайта', 'notes', 'notes');
echoblock('Подарки', 'Управление подарками на сайте, добавление, редактирование и удаление', 'gifts', 'gifts');
echoblock('Сообщества', 'Управление сообществами, редактирование и удаление', 'groups', 'groups');
echoblock('Жалобы '.$new_report, 'Список жалоб, поступивших от посетителей сайта на фотографии, записи, видеозаписи или заметки', 'report', 'report');
echoblock('Шаблоны сайта', 'Редактирование шаблонов, которые используются на вашем сайте', 'tpl', 'tpl');
echoblock('Шаблоны сообщений', 'Настройка шаблонов E-Mail сообщений, которые отсылает скрипт с сайта при уведомлении.', 'mail_tpl', 'mail_tpl');
echoblock('Рассылка сообщений', 'Создание и массовая отправка E-Mail сообщений, для зарегистрированных пользователей', 'mail', 'mail');
echoblock('Фильтр по: IP', 'Блокировка доступа на сайт для определенных IP', 'ban', 'ban');
echoblock('Поиск и Замена', 'Быстрый поиск и замена определенного текста по всей базе данных', 'search', 'search');
echoblock('Статические страницы', 'Создание и редактирование страниц, которые как правило редко изменяются и имеют постоянный адрес', 'static', 'static');
echoblock('Антивирус', 'Проверка папок и файлов скрипта на наличие подозрительных файлов', 'antivirus', 'antivirus');
echoblock('Логи посещений', 'Вывод IP и браузера пользователей при последнем входе на сайт', 'logs', 'logs');
echoblock('Страны', 'Добавление, удаление и редактирование стран', 'country', 'country');
echoblock('Города', 'Добавление, удаление и редактирование городов', 'city', 'city');
echoblock('Верификация '.$new_verification, 'Одобрение и отклонение заявок на верификацию', 'verification', 'verification');
echoblock('Верификация групп '.$new_verification_gr, 'Одобрение и отклонение заявок на верификацию', 'verification_gr', 'verification');
echoblock('Игры', 'Добавление, удаление и редактирование игр на сайте', 'apps', 'apps');
echoblock('Игры от пользователей ' . $new_games_ver, 'Одобрение и отклонение игр, присланных пользователями', 'apps_ver', 'apps');
echoblock('Подарки от юзеров '.$new_gifts, 'Модерация подарков, присланных от пользователей сайта', 'gifts_user'.$lnk, 'gifts_user');
echoblock('Отчеты по SMS', 'Просмотр отчетов отправки SMS от пользователей', 'sms', 'sms');
echoblock('Рекламные материалы', 'Добавление и управление рекламными материалами, которые публикуются на сайте', 'banners', 'banners');
echoblock('Реклама от юзеров '.$new_banners, 'Проверка и удаление рекламы от пользователей сайта.', 'users_banners', 'users_banners');
echoblock('Запрещенные сайты', 'Добавление, удаление и редактирование списка запрещенных сайтов.', 'restricted', 'restricted');
echoblock('Игры nextgame', 'Настройка конфигурации', 'nextgame', 'nextgame');
echoblock('Robokassa', 'Отчеты по счетам', 'robokassa', 'sms');
echo <<<HTML
<script type="text/javascript" src="/system/inc/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$.post('/controlpanel.php', {act: 'send'});
});
</script>
HTML;
echohtmlend();
?>
