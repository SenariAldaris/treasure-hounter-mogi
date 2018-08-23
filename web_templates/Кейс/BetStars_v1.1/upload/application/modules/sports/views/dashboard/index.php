
<?php
$num_columns	= 3;
$can_edit		= $this->auth->has_permission('Sports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>

	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title col-md-8">
				<?php if (isset($toolbar_title)) : ?>
				<?php echo $toolbar_title; ?>
				<?php endif; ?>
			</h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
				  <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/sports" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<?php echo form_open($this->uri->uri_string()); ?>
			<div class="box-body">
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'active' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('sports_tab_active')); ?></li>
					<li<?php echo $filter_type == 'inactive' ? ' class="active"' : ''; ?>><?php echo anchor("{$index_url}inactive/", lang('sports_tab_inactive')); ?>
					</li>
				</ul>				
				<div class="table-responsive">
					<table id="sports_table" class="table table-striped">
						<thead>
							<tr>
								<th><?php echo lang('sports_icon'); ?></th>
								<th><?php echo lang('sports_name'); ?></th>									
								<th><?php echo lang('sports_active'); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :
							?>
							<tr>
							<td><img class="w30" src="<?php echo base_url();?>uploads/sports/<?php echo $record->icon; ?>"/></td>	
							<?php if ($can_edit) : ?>
								<td><?php echo anchor(SITE_AREA . '/dashboard/sports/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->name); ?></td>
							<?php else : ?>
								<td><?php e($record->name); ?></td>
							<?php endif; ?>
							
							<td><?php if ($record->active) : ?>
							<span class="label label-success"><?php echo lang('bf_active'); ?></span>
							<?php else : ?>
							<span class="label label-warning"><?php echo lang('bf_inactive'); ?></span>
							<?php endif; ?>			
				
							</td>
							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('sports_records_empty'); ?></td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>	
			</div><!-- /.box-body -->
			<?php if ($has_records) : ?>
				<div class="box-footer">
					<tr>
						<td colspan='<?php echo $num_columns; ?>'>	
							<?php echo $this->pagination->create_links();?>							
						</td>
					</tr>
				</div>
			<?php endif; ?>
		<?php echo form_close(); ?>
	</div><!-- /.box -->

	
<script type="text/javascript">
    //Check and uncheck all functionality
	$(".check-all").click(function () {
        $('#sports_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });	
</script>