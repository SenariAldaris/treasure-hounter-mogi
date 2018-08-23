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
		
		
			<?php if (validation_errors()) : ?>
			<div class="alert alert-block alert-error fade in">
				<a class="close" data-dismiss="alert">&times;</a>
				<h4 class='alert-heading'><?php echo lang('database_validation_errors_heading'); ?></h4>
				<p><?php echo validation_errors(); ?></p>
			</div>
			<?php
			endif;
			if (empty($tables) || ! is_array($tables)) :?>
			<div class="alert alert-error">
				<p><?php echo lang('database_backup_no_tables'); ?></p>
			</div>
			<?php
			else : echo form_open(SITE_AREA . '/settings/database/backup', 'class="form-horizontal"'); ?>

		<div class="box-body">	
			
					<?php foreach ($tables as $table) : ?>
					<input type="hidden" name="tables[]" value="<?php e($table); ?>" />
					<?php endforeach; ?>
					<div class="alert alert-info">
						<p><?php echo lang('database_backup_warning'); ?></p>
					</div>
					<div class="form-group<?php echo form_error('file_name') ? ' error' : ''; ?>">
						<label for="file_name" class="control-label col-sm-4"><?php echo lang('database_filename'); ?></label>
						<div class="col-sm-4">
							<input type="text" name="file_name" id="file_name" value="<?php echo set_value('file_name', empty($file) ? '' : $file); ?>" />
							<span class="help-inline"><?php echo form_error('file_name'); ?></span>
						</div>
					</div>
					<div class="form-group<?php echo form_error('drop_tables') ? ' error' : ''; ?>">
						<label for="drop_tables" class="control-label col-sm-4"><?php echo lang('database_drop_question'); ?></label>
						<div class="col-sm-4">
							<select name="drop_tables" id="drop_tables">
								<option value="0" <?php echo set_select('drop_tables', '0'); ?>><?php echo lang('bf_no'); ?></option>
								<option value="1" <?php echo set_select('drop_tables', '1'); ?>><?php echo lang('bf_yes'); ?></option>
							</select>
							<span class="help-inline"><?php echo form_error('drop_tables'); ?></span>
						</div>
					</div>
					<div class="form-group<?php echo form_error('add_inserts') ? ' error' : ''; ?>">
						<label for="add_inserts" class="control-label col-sm-4"><?php echo lang('database_insert_question'); ?></label>
						<div class="col-sm-4">
							<select name="add_inserts" id="add_inserts">
								<option value="0" <?php echo set_select('add_inserts', '0'); ?>><?php echo lang('bf_no'); ?></option>
								<option value="1" <?php echo set_select('add_inserts', '1', true); ?>><?php echo lang('bf_yes'); ?></option>
							</select>
							<span class="help-inline"><?php echo form_error('add_inserts'); ?></span>
						</div>
					</div>
					<div class="form-group<?php echo form_error('file_type') ? ' error' : ''; ?>">
						<label for="file_type" class="control-label col-sm-4"><?php echo lang('database_compress_question'); ?></label>
						<div class="col-sm-4">
							<select name="file_type" id="file_type">
								<option value="txt" <?php echo set_select('file_type', 'txt', true); ?>><?php echo lang('bf_none'); ?></option>
								<option value="gzip" <?php echo set_select('file_type', 'gzip'); ?>><?php echo lang('database_gzip'); ?></option>
								<option value="zip" <?php echo set_select('file_type', 'zip'); ?>><?php echo lang('database_zip'); ?></option>
							</select>
							<span class="help-inline"><?php echo form_error('file_type'); ?></span>
						</div>
					</div>
					<div class="alert alert-warning">
						<?php echo lang('database_restore_note'); ?>
					</div>
					<div class="small form-group<?php echo form_error('tables') ? ' error' : ''; ?>">
						<label class='control-label col-sm-4' for='table_names'><?php echo lang('database_backup_tables'); ?></label>
						<div id='table_names' class='col-sm-4'>
							<span class='input-block-level uneditable-input'><?php e(implode(', ', $tables)); ?></span>
						</div>
					</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="backup" class="btn btn-primary"><?php echo lang('database_backup'); ?></button>
			<?php echo anchor(SITE_AREA . '/settings/database', lang('bf_action_cancel') , 'class="btn btn-warning"'); ?>
		</div>
			<?php
				echo form_close();
			endif;
			?>
	</div>