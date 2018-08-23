<?php

$num_columns	= 3;
$can_edit		= $this->auth->has_permission('Rewards.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/rewards" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string()); ?>
		
			<div class="box-body">
			

					<ul class="nav nav-tabs">
						<li class="<?php echo $filter_type == 'competition_id' ? 'active ' : ''; ?>dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php
								echo lang('rewards_tab_competition');
								echo isset($filter_competition) ? ": {$filter_competition}" : '';
								?>
								<span class="caret light-caret"></span>
							</a>
							<ul class="dropdown-menu">
								<?php foreach ($competitions as $competition) : ?>
								<li>
									<a href="<?php echo base_url();?>admin/dashboard/rewards/index/competition_id-<?php echo $competition->id;?>">
										<?php echo $this->competitions_model->get_competition_name_by_id($competition->id);?>
										<span class="ml20 text-red text-right">
										(<?php echo date('M d,Y', strtotime($competition->start_date));?>-
										<?php echo date('M d,Y', strtotime($competition->end_date));?>)
										</span>
									</a>
								</li>
								<?php $curr = $competition->currency;?>
								<?php endforeach; ?>
							</ul>
						</li>

					</ul>
	
				
				<div class="table-responsive">
					<table id="rewards_table" class='table table-striped'>
						<thead>
							<tr>								
								<th><?php echo lang('rewards_field_competition'); ?></th>
								<th><?php echo lang('rewards_field_place'); ?></th>
								<th><?php echo lang('rewards_field_reward'); ?></th>
							</tr>
						</thead>
						
						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :
							?>
							<tr>

								<td class="text-blue"><?php echo $this->competitions_model->get_competition_name_and_date_by_id($record->competition_id); ?></td>
								<td>
									<?php e($record->place); ?>
									<input type="hidden" name="place[]" value="<?php echo $record->place; ?>" />
									<input type="hidden" name="id[]" value="<?php echo $record->id; ?>" />
								</td>
								<td class="w100">
									<input type="text" class="form-control" name="reward[]" id="reward" value="<?php echo $record->reward; ?>" />
								</td>
								<td class="w30">
									<?php echo $curr; ?>
								</td>
								
							</tr>
							


							<?php endforeach;
							
							else: ?>
							<tr>
								<td class="text-left text-red" colspan='<?php echo $num_columns; ?>'><?php echo lang('rewards_choose_competition'); ?></td>
							</tr>
							<?php endif; ?>
							
						</tbody>
					</table>
				</div>	
			</div>	<!-- /.box-body -->
			
			<?php if ($has_records) : ?>
				<div class="box-footer">
					<?php if ($can_edit) : ?>
						<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save'); ?>" />

					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php  echo form_close(); ?>
	</div>
	
	
<script type="text/javascript">
	//Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#rewards_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
</script>