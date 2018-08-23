<?php

$databaseUrl = site_url(SITE_AREA . '/settings/database');
$numColumns = 4;

?>

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
		
		
		<?php if (empty($backups) || ! is_array($backups)) : ?>
		<div class="alert alert-info">
			<p><?php echo lang('database_no_backups'); ?></p>
		</div>
		<?php else : echo form_open($this->uri->uri_string());?>
			
			<div class="box-body">	
				<table id="db_table" class="table table-striped">
					<thead>
						<tr>
							<th class="column-check"><input class="check-all" type="checkbox" /></th>
							<th><?php echo lang('bf_action_download'); ?></th>
							<th><?php echo lang('database_restore'); ?></th>
							<th id='db_size_column'><?php echo lang('bf_size'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($backups as $file => $atts) :
							// If the index.html file is present, don't display it.
							if ($file == 'index.html') {
								continue;
							}
						?>
						<tr class="hover-toggle">
							<td class="column-check"><input type="checkbox" value="<?php e($file); ?>" name="checked[]" /></td>
							<td><a href='<?php echo "{$databaseUrl}/get_backup/{$file}"; ?>'><?php e(sprintf(lang('database_link_title_download'), $file)); ?></a></td>
							<td><a href='<?php echo "{$databaseUrl}/restore/{$file}"; ?>'><?php e(sprintf(lang('database_link_title_restore'), $file)); ?></a></td>
							<td><?php echo byte_format($atts['size']); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>	
			<div class="box-footer">

				<?php echo lang('bf_with_selected'); ?>
				<button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('<?php e(js_escape(lang('database_backup_delete_confirm'))); ?>')"><?php echo lang('bf_action_delete'); ?></button>

			</div>			
			
		<?php echo form_close();
		endif; ?>
	</div>
	
<script type="text/javascript">
    //Check and uncheck all functionality
	$(".check-all").click(function () {
        $('#db_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });	
</script>	