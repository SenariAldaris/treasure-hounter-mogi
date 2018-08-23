	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/database"><?php echo lang('database_maintenance'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/database/backups"><?php echo lang('database_backups'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<div class="box-body">
		
			<?php if (empty($results)) : ?>
			<h3><?php echo sprintf(lang('database_restore_file'), $filename); ?></h3>
			<div class="alert alert-warning">
				<?php echo lang('database_restore_attention'); ?>
			</div>
			<?php echo form_open($this->uri->uri_string()); ?>
				<input type="hidden" name="filename" value="<?php echo $filename; ?>" />
				<fieldset class="form-actions">
					<input type="submit" name="restore" class="btn btn-primary" value="<?php echo lang('database_restore'); ?>" />
					<?php echo anchor(SITE_AREA . '/settings/database/backups', lang('bf_action_cancel'), 'class="btn btn-warning"'); ?>
				</fieldset>
			<?php
				echo form_close();
			else :
			?>
			<h3><?php echo lang('database_restore_results'); ?></h3>
			<div class='backups-link'>
				<?php echo anchor(SITE_AREA . '/settings/database/backups', lang('database_back_to_tools')); ?>
					</div>
			<div class="content-box">
				<p><?php echo $results; ?></p>
				</div>
			<div class='backups-link'>
				<?php echo anchor(SITE_AREA . '/settings/database/backups', lang('database_back_to_tools')); ?>
				</div>
			<?php endif; ?>
		</div>	
	</div>