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
		
		<div class="box-body">
			<?php if (empty($log_content)) : ?>
			<div class="alert alert-warning fade in">
				<a class="close" data-dismiss="alert">&times;</a>
				<?php echo lang('logs_not_found'); ?>
			</div>
			<?php else : ?>
			<span class='form-horizontal'>
				<div class='form-group'>
					<label for='filter' class='control-label col-sm-2'><?php echo lang('logs_filter_label'); ?></label>
					<div class='col-sm-4'>
						<select id="filter" class="form-control">
							<option value="all"><?php echo lang('logs_show_all_entries'); ?></option>
							<option value="error"><?php echo lang('logs_show_errors'); ?></option>
						</select>
					</div>
				</div>
			</span>
			<div id="log">
				<?php
				foreach ($log_content as $row) :
					// Log files start with PHP guard header
					if (strpos($row, '<?php') === 0) {
						continue;
					}

					// Log files usually contain an empty row after the guard header,
					// and any whitespace around the entry doesn't need to be output
					$row = trim($row);
					if (empty($row)) {
						continue;
					}

					$class = 'log-entry';
					if (strpos($row, 'ERROR') !== false) {
						$class .= ' alert-error';
					} elseif (strpos($row, 'DEBUG') !== false) {
						$class .= ' alert-warning';
					}
				?>
				<div class="<?php echo $class; ?>"><?php e($row); ?></div>
				<?php endforeach; ?>
			</div>
			
		
		
			<?php if ($canDelete) : ?>


			<h3><?php echo lang('logs_delete1_button') ?></h3>
			<?php echo form_open(site_url(SITE_AREA . '/settings/logs'), array('class' => 'form-horizontal')); ?>
				<div class="alert alert-warning fade in">
					<a class="close" data-dismiss="alert">&times;</a>
					<?php echo lang('logs_delete1_note'); ?>
				</div>
		</div>		
		<div class="box-footer">
			<input type="hidden" name="checked[]" value="<?php e($log_file); ?>" />
			<button type="submit" name="delete" class="btn btn-red" onclick="return confirm('<?php e(js_escape(lang('logs_delete_confirm'))) ?>')"><span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('logs_delete1_button'); ?></button>
		</div>
			<?php echo form_close();
			endif;
		    endif; ?>
	</div>