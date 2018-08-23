<?php
define('MOZG', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/system');
include ENGINE_DIR.'/classes/mysql.php';
include ENGINE_DIR.'/data/db.php';

$restricted_sql = $db->super_query("SELECT * FROM " . PREFIX . "_restricted_sites;", 1);

foreach ($restricted_sql as $item) {
    $restricted[$item['domain']] = $item['text'];
}

//* $Restricted = array('face-world.ru' => 'Ссылка, по которой Вы попытались перейти, может вести на сайт, который был создан с целью обмана пользователей vzex.ru и получения за счет этого прибыли *//

//* Не в коем случае не вводите свои данные от учетной записи vzex.ru на данном сайте.'); *//

function clean_url($url) {
	if( $url == '' ) return;

	$url = str_replace( "http://", "", strtolower( $url ) );
	$url = str_replace( "https://", "", $url );
	if( substr( $url, 0, 4 ) == 'www.' ) $url = substr( $url, 4 );
	$url = explode( '/', $url );
	$url = reset( $url );
	$url = explode( ':', $url );
	$url = reset( $url );

	return $url;
}

if (in_array(clean_url($_GET['url']), array_keys($restricted))) {
    $message = $restricted[clean_url($_GET['url'])];
} else {
    header("Location: {$_GET['url']}");
    die();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <meta name="generator" content="Заболтайка" />
        <title>Переход заблокирован</title>
        <link rel="shortcut icon" href="/templates/Old/images/uic.png" />
        <style>
            body
            {
                background-color: #E0EDFC;
            }

            h1,
            h2,
            p
            {
                text-align: center;
                font-family: Tahoma, serif;
            }

            p
            {
                font-size: 1.3em;
                color: gray;
            }

            h1,
            h2
            {
                color: #E0EDFC;
                text-shadow: 1px 1px 5px black;
            }

            h1
            {
                font-size: 2.5em;
            }

            h2
            {
                font-size: 1.5em;
            }
        </style>
    </head>
    <body>
        <h1>Заболтайка</h1>
        <h2>Переход заблокирован. Сайт был внесен в каталог опасных сайтов</h2>
        <p><?php echo $message; ?></p>
    </body>
</html>