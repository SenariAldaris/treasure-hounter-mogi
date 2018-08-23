<?php if ($log_threshold == 0) : ?>
<div class="alert alert-warning fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <?php echo lang('logs_not_enabled'); ?>
</div>
<?php endif; ?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					<a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/logs/settings"><?php echo lang('logs_settings'); ?></a>
					<a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/logs"><?php echo lang('logs_logs');?></a>
				</div>
			</div>	
		</div><!-- /.box-header -->
		
		
		<?php echo form_open(site_url(SITE_AREA . '/settings/logs/enable'), 'class="form-horizontal"'); ?>
			<div class="box-body">
				<div class="form-group">
					<label for="log_threshold" class="control-label col-sm-2"><?php echo lang('logs_the_following'); ?></label>
					<div class="col-sm-6">
						<select name="log_threshold" class="form-control" id="log_threshold">
							<option value="0" <?php echo set_select('log_threshold', 0, $log_threshold == 0); ?>><?php echo lang('logs_what_0'); ?></option>
							<option value="1" <?php echo set_select('log_threshold', 1, $log_threshold == 1); ?>><?php echo lang('logs_what_1'); ?></option>
							<option value="2" <?php echo set_select('log_threshold', 2, $log_threshold == 2); ?>><?php echo lang('logs_what_2'); ?></option>
							<option value="3" <?php echo set_select('log_threshold', 3, $log_threshold == 3); ?>><?php echo lang('logs_what_3'); ?></option>
							<option value="4" <?php echo set_select('log_threshold', 4, $log_threshold == 4); ?>><?php echo lang('logs_what_4'); ?></option>
						</select>
						<p class="help-block"><?php echo lang('logs_what_note'); ?></p>
					</div>
				</div>
			

				<div class="alert alert-info fade in">
					<a class="close" data-dismiss="alert">&times;</a>
					<?php echo lang('logs_big_file_note'); ?>
				</div>
			</div>	
			<div class="box-footer">
				<input type="submit" name="save" class="btn btn-blue" value="<?php echo lang('logs_save_button'); ?>" />
			</div>
		<?php echo form_close(); ?>
	</div>