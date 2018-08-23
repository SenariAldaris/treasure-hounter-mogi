    
	<?php echo theme_view('header'); ?>

		<div class="col-md-3">
			<?php Template::block('sidebar_left'); ?>
		</div>

		<div class="col-md-9">
			<?php echo Template::message();
				echo isset($content) ? $content : Template::content();
			?>
		</div>	

    <?php echo theme_view('footer'); ?>