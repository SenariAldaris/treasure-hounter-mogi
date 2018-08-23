
<!DOCTYPE html>
<html>

<head>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Theme CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dist/css/style.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.ico">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

</head>

<body>

  <!-- Start: Main -->
  <div id="main">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">


      <!-- Begin: Content -->
      <section id="content" class="pn animated animated-longer flipInX">

        <div class="center-block">
          <h1 class="error-title"> Offline! </h1>
          <h2 class="error-subtitle">The site is currently offline for maintenance.</br>
		  Please check back in a little while.</h2>

        </div>
        <div class="mid-section">
          <div class="mid-content clearfix">
		  
			<?php if ($offlineReason) : 

			 e($offlineReason); 

			endif; ?>
			<h2 class="error-subtitle">Thanks for your understanding.</h2>

          </div>
        </div>

      </section>
      <!-- End: Content -->

    </section>


  </div>
  <!-- End: Main -->

</body>

</html>
