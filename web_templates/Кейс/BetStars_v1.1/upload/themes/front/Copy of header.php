
<!DOCTYPE html>
<html>

<head>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<title>
	<?php echo isset($page_title) ? "{$page_title} : " : ''; e(class_exists('Settings_lib') ? settings_item('site.title') : 'Bett Stars');?>
	</title>
	<meta name="description" content="<?php e(isset($meta_description) ? $meta_description : ''); ?>">
	<meta name="author" content="<?php e(isset($meta_author) ? $meta_author : ''); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
	<!-- Font  Awesome --> 
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
	<!-- Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
	<!-- Load styles from modules-->
	<?php echo Assets::css(); ?>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico">

	<!--[if gte IE 8]>
	<style type="text/css">
	#file, #file2{ display:block !important; width:470px;}
	.dummyfile{ display: none !important;}
	</style>
	<![endif]-->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

</head>

<body>
<!-- Site wrapper -->
<div class="wrapper">

	<header class="main-header">
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container-fluid">
			<div class="head-content">
				<div class="navbar-header">
				  <a href="<?php echo base_url();?>" class="navbar-brand">
				  <span><?php e(class_exists('Settings_lib') ? settings_item('site.title') : 'Betting Stars');?></span></a>

				  
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="navbar-collapse pull-left collapse" id="navbar-collapse" aria-expanded="false" style="height: 1px;">
					<ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
						<li <?php echo check_class('home'); ?>><a href="<?php echo base_url();?>"><?php echo lang('bf_menu_home');?></a></li>
						<li <?php echo check_class('tips'); ?>><a href="<?php echo base_url();?>tips"><?php echo lang('bf_menu_tips');?></a></li>
						<li <?php echo check_class('tipsters'); ?>><a href="<?php echo base_url();?>tipsters"><?php echo lang('bf_menu_tipsters');?></a></li>
						<li <?php echo check_class('competitions'); ?>><a href="<?php echo base_url();?>competitions"><?php echo lang('bf_menu_competitions');?></a></li>
						<li <?php echo check_class('bookmakers'); ?>><a href="<?php echo base_url();?>bookmakers"><?php echo lang('bf_menu_bookmakers');?></a></li>
						<li <?php echo check_class('bet_events'); ?>><a href="<?php echo base_url();?>events"><?php echo lang('bf_menu_events');?></a></li>
						<li <?php echo check_class('scores'); ?>><a href="<?php echo base_url();?>scores"><?php echo lang('bf_menu_scores');?></a></li>
						<li <?php echo check_class('news'); ?>><a href="<?php echo base_url();?>news"><?php echo lang('bf_menu_news');?></a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			
			

				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav navbar-right">

					  <?php if(!empty($current_user)):?>
					  <!-- User Account Menu -->
					  <li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <!-- The user image in the navbar-->
						  <img src="<?php echo base_url();?>uploads/tipsters/<?php echo $current_user->avatar;?>" class="user-image" alt="User Image">
						  <!-- hidden-xs hides the username on small devices so only the image appears. -->
						  <span class="hidden-xs"><?php echo $current_user->display_name;?></span>
						</a>
					   <ul class="dropdown-menu animated animated-short flipInX " role="menu">
						<?php if($current_user->role_id == 1) :?>
						
						<li><a href="<?php echo site_url('tipsters/edit_profile'); ?>"><?php e(lang('bf_edit_profile')); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('admin/dashboard'); ?>"><?php e(lang('bf_admin_dashboard')); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('bf_action_logout')); ?></a></li>	

						<?php else :?>
						<li><a href="<?php echo site_url('tipsters/profile/'. $current_user->id); ?>"><?php e(lang('bf_view_profile')); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('tipsters/edit_profile'); ?>"><?php e(lang('bf_edit_profile')); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('tips/create'); ?>"><?php e(lang('bf_post_tip')); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('bf_action_logout')); ?></a></li>
						<?php endif;?>
						
						
					  </ul>
					  </li>
					  <?php endif;?>
						
						<li>
							<div class="lang-holder">
							  <a href="#" class="topbar-menu-toggle" data-toggle="button">

								 <img src="<?php echo base_url() ?>assets/img/lang/<?php if ($this->input->cookie('language') != '') 
								{
								   echo $this->input->cookie('language');
								} 
								else 
								{
								$language = $this->settings_lib->item('default.language');
								echo $language;
								} ?>.png">
							  </a>
							</div>
						</li>					  
					  
					</ul>
				</div><!-- /.navbar-custom-menu --> 
			</div><!-- /.container-fluid -->
			</div>
        </nav>
    </header>

	
	
	
	
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		
					
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
  

		<div class="container-fluid hidden-md hidden-lg">
			<div class="col-sm-12">
				<div class="box box-widget  widget-user mt20">
					<ul class="nav nav-stacked text-center text-uppercase">
						<li class="text-center"><a href="<?php echo site_url('tips/create'); ?>" class="text-lblue">+ <?php e(lang('bf_new_tip')); ?></a></li>
						<li <?php echo check_class('home'); ?>><a href="<?php echo base_url();?>"><?php echo lang('bf_menu_home');?></a></li>
						<li <?php echo check_class('tips'); ?>><a href="<?php echo base_url();?>tips"><?php echo lang('bf_menu_tips');?></a></li>
						<li <?php echo check_class('tipsters'); ?>><a href="<?php echo base_url();?>tipsters"><?php echo lang('bf_menu_tipsters');?></a></li>
						<li <?php echo check_class('competitions'); ?>><a href="<?php echo base_url();?>competitions"><?php echo lang('bf_menu_competitions');?></a></li>
						<li <?php echo check_class('bookmakers'); ?>><a href="<?php echo base_url();?>bookmakers"><?php echo lang('bf_menu_bookmakers');?></a></li>
						<li <?php echo check_class('events'); ?>><a href="<?php echo base_url();?>events"><?php echo lang('bf_menu_events');?></a></li>
						<li <?php echo check_class('scores'); ?>><a href="<?php echo base_url();?>scores"><?php echo lang('bf_menu_scores');?></a></li>
						<li <?php echo check_class('news'); ?>><a href="<?php echo base_url();?>news"><?php echo lang('bf_menu_news');?></a></li>
					</ul>	
				</div>	
			</div>	
		</div>	  
  
 
        <div class="container-fluid">
		
			<!-- Content Header (Page header) -->
			<section class="content-header">

			  <ol class="breadcrumb">
				<li class="crumb-icon">
				  <a href="<?php echo base_url() ?>">
					<span class="glyphicon glyphicon-home"></span>
				  </a>
				</li>
				
				<?php if($this->uri->segment(1)):?>
				<li class="">
				  <a href="<?php echo base_url($this->uri->segment(1)) ?>"><?php echo ucfirst($this->uri->segment(1)); ?></a>
				</li>
				<?php else:?>
				<li class=""><?php echo lang('bf_home');?></li>
				<?php endif;?>
				
				<li class=""><?php echo str_replace("_", " ", ucfirst($this->uri->segment(2))); ?></li>
				<a href="<?php echo site_url('tips/create'); ?>" class="hidden-xs fr btn btn-clean">+ <?php e(lang('bf_new_tip')); ?></a>
			  </ol>
			  
			  
			</section>
			
			
        </div>

        <!-- Main content -->
        <section class="content">
		
		<div class="container-fluid">
		<div class="alert alert-info p10">There are no active events at the moment</div>
		</div>