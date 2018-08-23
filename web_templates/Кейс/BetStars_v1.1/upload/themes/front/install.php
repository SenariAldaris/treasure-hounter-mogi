    
	<?php echo theme_view('install_header'); ?>


		<div class="col-md-8 col-md-push-2">
			<?php echo Template::message();
				echo isset($content) ? $content : Template::content();
			?>
		</div>

    <?php echo theme_view('footer'); ?>