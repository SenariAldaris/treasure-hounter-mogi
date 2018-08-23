     <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <span class="mr10">Powered By</span><a href="http://codeigniter.com">Codeigniter</a> <b><?php echo CI_VERSION;?></b>
        </div>
        <span class="mr10">Copyright &copy; <?php echo date('Y');?> </span>
		<a href="http://almsaeedstudio.com">
			<?php echo isset($page_title) ? "{$page_title} : " : ''; e(class_exists('Settings_lib') ? settings_item('site.title') : 'Bett Stars');?>
		</a> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <script src="<?php echo site_url()?>assets/js/app.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- Load Assets From Modules -->
    <?php echo Assets::js(); ?>
  </body>
</html>