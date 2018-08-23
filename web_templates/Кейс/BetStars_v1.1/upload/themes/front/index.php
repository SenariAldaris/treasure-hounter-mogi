    <?php echo theme_view('header'); ?>
    
	<!-- Start: Content-Wrapper -->
    <section id="content_wrapper" class="animated fadeIn">


      <!-- Start: Topbar-Dropdown -->
      <div id="topbar-dropmenu" class="alt mb20">
        <div class="topbar-menu row">

              <?php if ($handle = opendir('application/language/')) 
                {

                  while (false !== ($entry = readdir($handle))) 
                  {
                    if ($entry != "." && $entry != "..") 
                    { ;?>

                      <div class="col-xs-4 col-sm-1">
                        <a href="<?= base_url() ?>home/language/<?= $entry; ?>">
                          <img src="<?= base_url() ?>assets/img/lang/<?= $entry; ?>.png">
                          <span><?php echo ucfirst($entry); ?></span>
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
		<div class="col-md-12">

			<?php echo Template::message();
				echo isset($content) ? $content : Template::content();
			?>
		</div>	
	 </section>
    <!-- End: Content-Wrapper -->
		
    <?php echo theme_view('footer'); ?>