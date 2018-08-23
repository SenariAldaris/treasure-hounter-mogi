
<!DOCTYPE html>
<html>
<?php ini_set("allow_url_fopen", "Off");?>
<head>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<title>Bett Stars</title>
	<meta name="description" content="">
	<meta name="author" content="">
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
					  <span>Bett Stars</span></a>

					  
					</div>
				</div><!-- /.container-fluid -->
			</div>
        </nav>
    </header>

	
	
	
	
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

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
				
			  </ol>
			  
			  
			</section>
			
			
        </div>

        <!-- Main content -->
        <section class="content">
		
