<?php

echo theme_view('header');
echo theme_view('navigation');
?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

			<?php
				echo Template::message();
				echo isset($content) ? $content : Template::content();
			?>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  
<?php echo theme_view('footer'); ?>