
    <?php echo theme_view('header'); ?>

		<div class="col-md-3">
			<?php Template::block('sidebar_left'); ?>
		</div>


		<div class="col-md-6">
			
			
			<?php echo Template::message();
			
				Template::block('topbar'); 
				echo isset($content) ? $content : Template::content();
			?>
		</div>	
		
		<div class="col-md-3">
			<?php Template::block('sidebar_right'); ?>
		</div>
	
		
    <?php echo theme_view('footer'); ?>