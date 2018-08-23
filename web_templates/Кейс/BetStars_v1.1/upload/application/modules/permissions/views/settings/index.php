<?php

$num_columns = 5;

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/permissions/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/permissions" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		
		
		
		<?php if (isset($results) && is_array($results) && count($results)) :
				echo form_open($this->uri->uri_string()); ?>
				
		<div class="box-body">		
		
			<div class="alert alert-info"><?php e(lang('permissions_intro')); ?></div>
			<div class="table-responsive">
				<table id="perm_table" class="table table-striped">
					<thead>
						<tr>
							<th class="column-check"><input id="check-all" type="checkbox" /></th>
							<th><?php echo lang('permissions_id'); ?></th>
							<th><?php echo lang('permissions_name'); ?></th>
							<th><?php echo lang('permissions_description'); ?></th>
							<th><?php echo lang('permissions_status'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($results as $record) : ?>
						<tr>
							<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->permission_id; ?>" /></td>
							<td><?php echo $record->permission_id; ?></td>
							<td><a href='<?php echo site_url(SITE_AREA . "/settings/permissions/edit/{$record->permission_id}"); ?>'><?php e($record->name); ?></a></td>
							<td><?php e($record->description); ?></td>
							<td><?php e(ucfirst($record->status)); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>	
		</div>

		<div class="box-footer">
			<tr>
				<td colspan="<?php echo $num_columns; ?>">
					<?php echo lang('bf_with_selected') ?>
					<input type="submit" name="delete" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php e(js_escape(lang('permissions_delete_confirm'))); ?>')">
					<?php echo $this->pagination->create_links();?>
				</td>
			</tr>
		</div>		
		<?php echo form_close();
			else :?>
			
			<p><?php echo lang('permissions_no_records'); ?></p>
			
			<?php endif; ?>
	</div>
	
<script type="text/javascript">
	//Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#perm_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
</script>	