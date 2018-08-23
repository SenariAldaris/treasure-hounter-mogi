<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Countries.Delete');
$can_edit		= $this->auth->has_permission('Countries.Edit');
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
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/countries/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/countries" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->

		<?php echo form_open($this->uri->uri_string()); ?>
		
			<div class="box-body">	
				<div class="table-responsive">
					<table id="countries" class='table table-striped'>
						<thead>
							<tr>
								<?php if ($can_delete && $has_records) : ?>
								<th class='column-check'><input class='check-all' type='checkbox' /></th>
								<?php endif;?>
								
								<th><?php echo lang('countries_flag'); ?></th>
								<th><?php echo lang('countries_name'); ?></th>
								<th><?php echo lang('countries_iso_alpha2'); ?></th>
								<th><?php echo lang('countries_iso_alpha3'); ?></th>
								<th><?php echo lang('countries_iso_numeric'); ?></th>
								<th><?php echo lang('countries_currency_code'); ?></th>
								<th><?php echo lang('countries_currency_name'); ?></th>
								<th><?php echo lang('countries_currrency_symbol'); ?></th>
								
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
								
								<td><img class="h30" src="<?php echo base_url();?>uploads/countries/<?php echo $record->flag; ?>"/></td>
								
							<?php if ($can_edit) : ?>
								<td><?php echo anchor(SITE_AREA . '/dashboard/countries/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->name); ?></td>
							<?php else : ?>
								<td><?php e($record->name); ?></td>
							<?php endif; ?>
								<td><?php e($record->iso_alpha2); ?></td>
								<td><?php e($record->iso_alpha3); ?></td>
								<td><?php e($record->iso_numeric); ?></td>
								<td><?php e($record->currency_code); ?></td>
								<td><?php e($record->currency_name); ?></td>
								<td><?php e($record->currrency_symbol); ?></td>
								
							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('countries_records_empty'); ?></td>
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
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('countries_delete_confirm'))); ?>')" />
						<?php echo $this->pagination->create_links(); ?>
					</td>
				</tr>
				<?php endif; ?>
			</div>
			<?php endif; ?>			
		<?php echo form_close();?>
			
			
	</div>
	
<script type="text/javascript">
    //Check and uncheck all functionality
	$(".check-all").click(function () {
        $('#countries tbody input[type="checkbox"]').prop('checked', this.checked);
    });	
</script>	