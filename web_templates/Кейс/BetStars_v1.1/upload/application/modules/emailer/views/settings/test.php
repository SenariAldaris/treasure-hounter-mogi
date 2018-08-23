
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					<a class="btn btn-xs btn-default" href="<?php echo site_url();?>admin/settings/emailer"><?php echo lang('bf_context_settings'); ?></a>
					<a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/emailer/template"><?php echo lang('emailer_email_template') ?></a>
					<a class="btn btn-xs btn-default" href="<?php echo site_url();?>admin/settings/emailer/queue"><?php echo lang('emailer_emailer_queue') ?></a>
					<a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/emailer/create"><?php echo lang('emailer_create_email'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
				
		<div class="box-body">

			<h4 class="head pl20 text-left"><?php echo lang('emailer_test_result_header'); ?></h4>

			<?php if ($success !== false) : ?>
			<div class="alert alert-info fade in">
				<?php echo lang('emailer_test_success'); ?>
			</div>
			<?php else : ?>
			<div class="alert alert-warning fade in">
				<?php echo lang('emailer_test_error'); ?>
			</div>
			<?php endif; ?>

			<h4 class="head pl20 text-left"><?php echo lang('emailer_test_debug_header'); ?></h4>
			<div style="padding:10px;"><?php echo $debug; ?></div>

		</div>
	</div>	