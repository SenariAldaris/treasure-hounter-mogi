    
	<?php echo theme_view('header'); ?>

		<div class="col-md-8">
			<?php echo Template::message();
				echo isset($content) ? $content : Template::content();
			?>
		</div>	
		
		<div class="col-md-4">
			<?php Template::block('sidebar_right'); ?>
		</div>

    <?php echo theme_view('footer'); ?>