    
	<?php echo theme_view('header'); ?>

		<div class="col-md-4">
			<?php Template::block('sidebar_left'); ?>
		</div>

		<div class="col-md-8">
			<?php echo Template::message();
				Template::block('topbar'); 
				echo isset($content) ? $content : Template::content();
			?>
		</div>	

    <?php echo theme_view('footer'); ?>