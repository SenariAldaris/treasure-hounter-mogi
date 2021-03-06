<?php
session_start();
if ($_SESSION['auth_admin'] == 'yes_auth') {
    if (isset( $_GET['logout'])) {
        unset($_SESSION['auth_admin']);
        header ('Location: login.php');
    }
    $_SESSION['urlpage'] = "<a href='http://catdrop.net/'>Сайт</a> / <a href='index.php'>Главная</a> / <a href='items.php'>Предметы</a> / <a>Добавление предметов</a> ";
    require_once ('connector.php');
    if ($_POST['submit_add']) {
            if (!empty($error)) {
                $_SESSION['message'] = '<p id="form-error">'.implode('<br />', $error).'</p>';
            } else {
                    mysql_query("INSERT INTO items(weapon,name,image,type)
		VALUES (
		'".$_POST["form_weapon"]."',
		'".$_POST["form_name"]."',
		'".$_POST["form_image"]."',
		'".$_POST["form_type"]."'
		)",$bd);
               
             }
        
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Добавить предметов</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="images/icons/favicon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">
    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="styles/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="styles/animate.css">
    <link type="text/css" rel="stylesheet" href="styles/all.css">
    <link type="text/css" rel="stylesheet" href="styles/main.css">
    <link type="text/css" rel="stylesheet" href="styles/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="styles/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="styles/pace.css">
    <link type="text/css" rel="stylesheet" href="styles/jquery.news-ticker.css">
</head>
<body>
    <div>
        <!--BEGIN BACK TO TOP-->
        <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
        <!--END BACK TO TOP-->
        <!--BEGIN TOPBAR-->
        <div id="header-topbar-option-demo" class="page-header-topbar">
            <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                <a id="logo"  class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text">AdminPanel</span><span style="display: none" class="logo-text-icon">µ</span></a></div>
            <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
                
               
                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle"><img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg" alt="" class="img-responsive img-circle"/>&nbsp;<span class="hidden-xs">Admin</span>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="?logout"><i class="fa fa-key"></i>Выход</a></li>
                        </ul>
                    </li>
                                   </ul>
            </div>
        </nav>
        </div>
        <!--END TOPBAR-->
        <div id="wrapper">
            <!--BEGIN SIDEBAR MENU-->
            <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
                data-position="right" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    
                     <div class="clearfix"></div>
                    <li><a href="index.php"><i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Главная</span></a></li>
                    <li><a href="users.php"><i class="fa fa-users fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i><span class="menu-title">Пользователи</span></a>
                       
                    </li>
                    <li><a href="cases.php"><i class="fa fa-suitcase fa-fw">
                        <div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">Кейсы</span></a>
                       
                    </li>

                    <li><a href="faq.php"><i class="fa fa-question fa-fw">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">FAQ</span></a>
                      
                    </li>
                       <li><a href="items.php"><i class="fa fa-check-square-o fa-fw">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">Предметы</span></a>
                      
                    </li>
					<li ><a href="itemserror.php"><i class="fa fa-bomb fa-fw">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">Неотправленные предметы</span></a>
                      
                    </li>
                    </li>
                    <li><a href="add_faq.php"><i class="fa fa-edit fa-fw">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">Добавить FAQ</span></a>
                      
                    </li>
					 <li class="active"><a href="add_items.php"><i class="fa fa-edit fa-fw">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">Добавить предметы</span></a>
                      
                    </li>
                    <li ><a href="add_cases.php"><i class="fa fa-edit fa-fw">
                        <div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">Добавтить кейсы</span></a>
                       
                    </li>
                </ul>
            </div>
        </nav>
            <!--END SIDEBAR MENU-->
          
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left">
                        <div class="page-title">
                           Административная панель</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<?php echo $_SESSION['urlpage']; ?>&nbsp;&nbsp;</li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <!--END TITLE & BREADCRUMB PAGE-->
                        
                        
                <!--BEGIN CONTENT-->
                <div class="page-content">     
            
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
            // вывод сообщений об ошибках
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>

<div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-green">
                                            <div class="panel-heading">
                                                Общее описание</div>
                                            <div class="panel-body pan">
   <form  enctype="multipart/form-data" method="POST">
                                                <div class="form-body pal">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                               <label for="calssWeap" class="control-label">
                                                                    Оружие</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-share"></i>
                                                                    <input id="calssWeap" type="text" placeholder="" class="form-control" name="form_weapon"/></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="itemName" class="control-label">
                                                                   Название</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="itemName" type="text" placeholder="" class="form-control" name="form_name"/></div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="itemImage" class="control-label">
                                                           Картинка</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-pencil"></i>
                                                            <input id="itemImage" type="text" placeholder="" class="form-control" name="form_image"/></div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="itemType" class="control-label">
                                                           Тип</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-credit-card"></i>
                                                            <input id="itemType" type="text" placeholder="" class="form-control" name="form_type"/></div>
                                                    </div>
            <div class="form-group">
         <input id="submit_form" type="submit" name="submit_add" class="btn btn-primary" value="Добавить проект"/>
                </div>
</div>	
                                                </div>
                                            </div>
                                        </div>
                                </div>
</div>

                <!--END CONTENT-->
               
            </div>
            <!--END PAGE WRAPPER-->
        </div>
    </div>
    <script src="script/jquery-1.10.2.min.js"></script>
    <script src="script/jquery-migrate-1.2.1.min.js"></script>
    <script src="script/jquery-ui.js"></script>
    <script src="script/bootstrap.min.js"></script>
    <script src="script/bootstrap-hover-dropdown.js"></script>
    <script src="script/html5shiv.js"></script>
    <script src="script/respond.min.js"></script>
    <script src="script/jquery.metisMenu.js"></script>
    <script src="script/jquery.slimscroll.js"></script>
    <script src="script/jquery.cookie.js"></script>
    <script src="script/icheck.min.js"></script>
    <script src="script/custom.min.js"></script>
    <script src="script/jquery.news-ticker.js"></script>
    <script src="script/jquery.menu.js"></script>
    <script src="script/pace.min.js"></script>
    <script src="script/holder.js"></script>
    <script src="script/responsive-tabs.js"></script>
    <script src="script/jquery.flot.js"></script>
    <script src="script/jquery.flot.categories.js"></script>
    <script src="script/jquery.flot.pie.js"></script>
    <script src="script/jquery.flot.tooltip.js"></script>
    <script src="script/jquery.flot.resize.js"></script>
    <script src="script/jquery.flot.fillbetween.js"></script>
    <script src="script/jquery.flot.stack.js"></script>
    <script src="script/jquery.flot.spline.js"></script>
    <script src="script/zabuto_calendar.min.js"></script>
    <script src="script/index.js"></script>
    <!--LOADING SCRIPTS FOR CHARTS-->
    <script src="script/highcharts.js"></script>
    <script src="script/data.js"></script>
    <script src="script/drilldown.js"></script>
    <script src="script/exporting.js"></script>
    <script src="script/highcharts-more.js"></script>
    <script src="script/charts-highchart-pie.js"></script>
    <script src="script/charts-highchart-more.js"></script>
    <!--CORE JAVASCRIPT-->
    <script src="script/main.js"></script>
    <script>        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-145464-12', 'auto');
        ga('send', 'pageview');


</script>
</body>
</html>
<?php
}else
{
	header ("location: login.php");
}
?>