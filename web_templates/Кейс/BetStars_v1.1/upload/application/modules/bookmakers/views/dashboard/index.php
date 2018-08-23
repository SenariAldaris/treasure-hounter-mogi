<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Bookmakers.Delete');
$can_edit		= $this->auth->has_permission('Bookmakers.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/bookmakers/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/bookmakers" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string()); ?>
			<div class="box-body">
				<div class="table-responsive">
					<table id="bookmakers_table" class='table table-striped'>
						<thead>
							<tr>
								<?php if ($can_delete && $has_records) : ?>
								<th class="column-check"><input id="check-all" type="checkbox" /></th>
								<?php endif;?>
								<th><?php echo lang('bookmakers_logo'); ?></th>
								<th><?php echo lang('bookmakers_name'); ?></th>
								<th><?php echo lang('bookmakers_url'); ?></th>							
								<th><?php echo lang('bookmakers_rating'); ?></th>
								<th><?php echo lang('bookmakers_bonus_offer'); ?></th>
								<th><?php echo lang('bookmakers_bonus_code'); ?></th>
								
							</tr>
						</thead>

						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :
							?>
							<tr>
							
								<?php if ($can_delete) : ?>
								<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
								<?php endif;?>
								<td><img class="h30" src="<?php echo base_url();?>uploads/bookmakers/<?php e($record->logo); ?>"/></td>
							<?php if ($can_edit) : ?>
								<td><?php echo anchor(SITE_AREA . '/dashboard/bookmakers/edit/' . $record->id,  $record->name); ?></td>
							<?php else : ?>
								<td><?php e($record->name); ?></td>
							<?php endif; ?>
								
								<td><?php e($record->url); ?></td>
								<?php $rating = $this->bookmaker_reviews_model->rating($record->id);?>
								<td><span class='text-blue fs16'><?php e($rating); ?>/ 5</td>
								<td><?php e($record->bonus_offer); ?></td>
								<td><?php e($record->bonus_code); ?></td>
								
							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('bookmakers_records_empty'); ?></td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>	
			<?php if ($has_records) : ?>
				<div class="box-footer">
					<?php if ($can_delete) : ?>
					<tr>
						<td colspan='<?php echo $num_columns; ?>'>
							<?php echo lang('bf_with_selected'); ?>
							<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('bookmakers_delete_confirm'))); ?>')" />
							<?php echo $this->pagination->create_links();?>
						</td>
					</tr>
					<?php endif; ?>
				</div>
			<?php endif; ?>	
		<?php echo form_close();?>
		
	</div>	
	
	<script>
		//Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#bookmakers_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
	</script>	