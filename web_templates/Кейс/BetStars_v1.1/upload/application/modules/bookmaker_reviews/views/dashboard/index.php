<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Bookmaker_Reviews.Delete');
$can_edit		= $this->auth->has_permission('Bookmaker_Reviews.Edit');
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
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/bookmaker_reviews" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>			
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string()); ?>
			<div class="box-body">
				<div class="table-responsive">
					<table id="bookmaker_reviews" class='table table-striped'>
						<thead>
							<tr>
								<?php if ($can_delete && $has_records) : ?>
								<th class="column-check"><input id="check-all" type="checkbox" /></th>
								<?php endif;?>
								<th><?php echo lang('bookmaker_reviews_reviewed_by'); ?></th>
								<th><?php echo lang('bookmaker_reviews_bookmaker'); ?></th>
								<th><?php echo lang('bookmaker_reviews_posted'); ?></th>							
								<th><?php echo lang('bookmaker_reviews_review'); ?></th>
								<th><?php echo lang('bookmaker_reviews_rating'); ?></th>
								<th><?php echo lang('bookmaker_reviews_status'); ?></th>
								
							</tr>
						</thead>

						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :?>
							<tr>
							<?php if ($can_delete) : ?>
							<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->review_id; ?>' /></td>
							<?php endif;?>
							<td><?php echo $this->tipsters_model->get_user_display_name_by_id($record->user_id);?></td>
							<td><img class="h30" src="<?php echo base_url();?>uploads/bookmakers/<?php echo $this->bookmakers_model->get_bookmaker_logo_by_id($record->bookmaker_id);?>"></td>
							<td><?php echo relative_time(strtotime($record->date_posted));?></td>
							
							
							<?php if ($can_edit) : ?>
								<td><?php echo anchor(SITE_AREA . '/dashboard/bookmaker_reviews/edit/' . $record->review_id,  (character_limiter($record->description ,50,'&#8230;'))); ?></td>
							<?php else : ?>
								<td><?php e(character_limiter($record->description ,50,'&#8230;')); ?></td>
							<?php endif; ?>						
							

							<td><?php echo $record->rating;?> / 5</td>

							<td>
								<?php if ($record->status == 1) : ?>
								<span class="label label-success"><?php echo lang('bookmaker_reviews_approved'); ?></span>
								<?php else : ?>
								<span class="label label-warning"><?php echo lang('bookmaker_reviews_pending'); ?></span>
								<?php endif; ?>
								
							</td>
		  
							</tr>	
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('bookmaker_reviews_records_empty'); ?></td>
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
							<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('bookmaker_reviews_delete_confirm'))); ?>')" />
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
        $('#bookmaker_reviews tbody input[type="checkbox"]').prop('checked', this.checked);
    });
	</script>	