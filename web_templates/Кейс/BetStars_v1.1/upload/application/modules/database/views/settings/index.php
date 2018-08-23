
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

		<?php if (empty($tables) || ! is_array($tables)) : ?>
		<div class="notification info">
			<p><?php echo lang('database_no_tables'); ?></p>
		</div>
		<?php else : echo form_open(SITE_AREA . '/settings/database/'); ?>
			
			<div class="box-body">
				<div class="table-responsive">
					<table id="db_table" class="table table-striped">
						<thead>
							<tr>
								<th class="column-check"><input class="check-all" type="checkbox" /></th>
								<th><?php echo lang('database_table_name'); ?></th>
								<th class='records'><?php echo lang('database_num_records'); ?></th>
								<th><?php echo lang('database_data_size'); ?></th>
								<th><?php echo lang('database_index_size'); ?></th>
								<th><?php echo lang('database_data_free'); ?></th>
								<th><?php echo lang('database_engine'); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($tables as $table) : ?>
							<tr>
								<td class="column-check"><input type="checkbox" value="<?php e($table->Name); ?>" name="checked[]" /></td>
								<td><a href="<?php e(site_url(SITE_AREA . "/settings/database/browse/{$table->Name}")); ?>"><?php e($table->Name); ?></a></td>
								<td class='records'><?php echo $table->Rows; ?></td>
								<td><?php e(is_numeric($table->Data_length) ? byte_format($table->Data_length) : $table->Data_length); ?></td>
								<td><?php e(is_numeric($table->Index_length) ? byte_format($table->Index_length) : $table->Index_length); ?></td>
								<td><?php e(is_numeric($table->Data_free) ? byte_format($table->Data_free) : $table->Data_free); ?></td>
								<td><?php e($table->Engine); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>	
				
			</div>
			
			<div class="box-footer">

				<div class="form-group">
					<label class="control-label col-sm-2" for='database-action'><?php echo lang('bf_with_selected'); ?>:</label>
					<div class="col-sm-4">
						<select name="action" id='database-action' class="form-control">
							<option value="backup"><?php echo lang('database_backup'); ?></option>
							<option value="repair"><?php echo lang('database_repair'); ?></option>
							<option value="optimize"><?php echo lang('database_optimize'); ?></option>
							<option>------</option>
							<option value="drop"><?php echo lang('database_drop'); ?></option>
						</select>
					</div>
					<input type="submit" value="<?php echo lang('database_apply')?>" class="btn btn-primary" />
				</div>		
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