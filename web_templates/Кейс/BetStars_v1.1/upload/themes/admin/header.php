<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
		<?php echo isset($page_title) ? "{$page_title} : " : ''; e(class_exists('Settings_lib') ? settings_item('site.title') : 'Bett Stars');?>
	</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo site_url()?>assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url()?>assets/css/admin.css">
	 <!-- Load module custom css -->
	<?php echo Assets::css(); ?>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico">
	
	<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo site_url()?>assets/js/bootstrap.min.js"></script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
  <!-- the fixed layout is not compatible with sidebar-mini -->
  <body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo site_url()?>admin/dashboard" class="logo">
          <span class="logo-mini"><b>C</b>P</span>
          <span class="logo-lg">
		  <b>
			<?php echo isset($page_title) ? "{$page_title} : " : ''; e(class_exists('Settings_lib') ? settings_item('site.title') : 'Bett Stars');?>
		  </b>
		  Cpanel</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </a>
			<div class="navbar-custom-menu mr15">
				<ul class="nav navbar-nav">
						<li>
							<div class="lang-holder">
							  <a href="#" class="topbar-menu-toggle" data-toggle="button">

								 <img src="<?php echo base_url() ?>assets/img/lang/<?php if ($this->input->cookie('language') != '') 
								{
								   echo $this->input->cookie('language');
								} 
								else 
								{
								echo $language;
								} ?>.png">
							  </a>
							</div>
						</li>		   
				  <!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <!-- The user image in the navbar-->
						  <img src="<?php echo base_url();?>uploads/tipsters/<?php echo $current_user->avatar;?>" class="user-image" alt="User Image">
						  <!-- hidden-xs hides the username on small devices so only the image appears. -->
						  <span class="hidden-xs"><?php echo $current_user->display_name;?></span>
						</a>
					   <ul class="dropdown-menu animated animated-short flipInX " role="menu">
						<li><a href="<?php echo site_url('admin/settings/users/edit'); ?>"><?php e(lang('bf_edit_profile')); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('bf_action_logout')); ?></a></li>
					  </ul>
					</li>
					<li class="hidden-xs"><a href="<?php echo site_url(); ?>" class="bg-lgrey text-lblue"><?php e(lang('bf_view_site')); ?></a></li>
				</ul>
			</div>
        </nav>
      </header>

      <!-- =============================================== -->
	  
	          <!-- Start: Topbar-Dropdown -->
        <div id="topbar-dropmenu" class="animated animated-short slideInDown">
          <div class="topbar-menu row">

                <?php if ($handle = opendir('application/language/')) 
                  {

                    while (false !== ($entry = readdir($handle))) 
                    {
                      if ($entry != "." && $entry != "..") 
                      { ;?>

                        <div class="col-xs-2 col-sm-1">
                          <a href="<?php echo base_url() ?>home/language/<?php echo $entry; ?>">
                            <img class="h30" src="<?php echo base_url();?>assets/img/lang/<?php echo $entry; ?>.png">
                            <span class="fs14 hidden-xs"><?php echo ucfirst($entry); ?></span>
                          </a>
                        </div>
                        <?php
                      }
                    }

                    closedir($handle);
                  } ?>


           
          </div>
        </div>
        <!-- End: Topbar-Dropdown -->