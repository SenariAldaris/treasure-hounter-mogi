<?php if ($log_threshold == 0) : ?>
<div class="alert alert-warning fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <?php e(lang('logs_not_enabled')); ?>
</div>

<?php endif;?>

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


<?php

if (empty($logs) || ! is_array($logs)) :
?>







<div class="alert alert-info fade in notification">
    <a class="close" data-dismiss="alert">&times;</a>
    <p><?php echo lang('logs_no_logs'); ?></p>
</div>
<?php else : ?>


		
		<?php echo form_open(); ?>
	
			<div class="box-body">
				<div class="table-responsive">
					<table id="logs_table" class="table table-striped logs">
						<thead>
							<tr>
								<th class="column-check"><input class="check-all" type="checkbox" /></th>
								<th class='date'><?php e(lang('logs_date')); ?></th>
								<th><?php e(lang('logs_file')); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
							foreach ($logs as $log) :
								// Skip the index.html file.
								if ($log == 'index.html') {
									continue;
								}
							?>
							<tr>
								<td class="column-check">
									<input type="checkbox" value="<?php e($log); ?>" name="checked[]" />
								</td>
								<td class='date'>
									<a href='<?php e(site_url(SITE_AREA . "/settings/logs/view/{$log}")); ?>'>
										<?php e(date('F j, Y', strtotime(str_replace('.php', '', str_replace('log-', '', $log))))); ?>
									</a>
								</td>
								<td><?php e($log); ?></td>
							</tr>
							<?php
							endforeach;
							?>
						</tbody>
					</table>
				</div>	
			</div>	
			<div class="box-footer">
				<tr>
					<td colspan="3">
						<?php echo lang('bf_with_selected'); ?>:
						<input type="submit" name="delete" id="delete-me" class="btn btn-red" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('logs_delete_confirm'))); ?>')" />
					</td>
				</tr>
			</div>
		<?php echo form_close();
        echo $this->pagination->create_links();?>
		
	<!-- Purge? -->
		<div class="box-body">
			<h3 class="box-title fs16 m20"><?php echo lang('logs_delete_button'); ?></h3>
			<?php echo form_open(); ?>
			<div class="alert alert-warning fade in">
				<a class="close" data-dismiss="alert">&times;</a>
				<?php echo lang('logs_delete_note'); ?>
			</div>
			<div class="box-footer">
				<button type="submit" name="delete_all" class="btn btn-red" onclick="return confirm('<?php e(js_escape(lang('logs_delete_all_confirm'))); ?>')">
					<span class="icon-white icon-trash"></span>&nbsp;<?php echo lang('logs_delete_button'); ?>
				</button>
			</div>
			<?php echo form_close(); ?>
		</div>	
	</div>
<?php endif;?>

<script type="text/javascript">
    //Check and uncheck all functionality
	$(".check-all").click(function () {
        $('#logs_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });	
</script>	