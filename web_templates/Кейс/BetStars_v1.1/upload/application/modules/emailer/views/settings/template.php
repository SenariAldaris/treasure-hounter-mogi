
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
			
			<p class="intro"><?php echo lang('emailer_template_note'); ?></p>
		
			<style scoped='scoped'>
			.admin-box .template {
				width: 99%;
			}
			</style>
	
			<?php echo form_open(SITE_AREA . '/settings/emailer/template'); ?>

				<h4 class="head pl20 text-left"><?php echo lang('emailer_header'); ?></h4>
				<div class="clearfix">
					<div class="input">
						<textarea name="header" rows="15" class="form-control"><?php echo htmlspecialchars_decode($this->load->view('email/_header', null, true)) ;?></textarea>
					</div>
				</div>

				<h4 class="head pl20 text-left"><?php echo lang('emailer_footer'); ?></h4>
				<div class="clearfix">
					<div class="input">
						<textarea name="footer" rows="15" class="form-control"><?php echo htmlspecialchars_decode($this->load->view('email/_footer', null, true)) ;?></textarea>
					</div>
				</div>

				<div class="box-footer">
					<input type="submit" name="save" id="submit" class="btn btn-primary" value="<?php e(lang('emailer_save_template')); ?>" />
					<?php echo anchor(SITE_AREA . '/settings/emailer', lang('bf_action_cancel'),'class="btn btn-warning"'); ?>
				</div>
			<?php echo form_close(); ?>
			
		</div>
	</div>	