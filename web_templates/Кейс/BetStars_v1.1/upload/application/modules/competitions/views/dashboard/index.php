<?php

$num_columns	= 9;
$can_delete	= $this->auth->has_permission('Competitions.Delete');
$can_edit		= $this->auth->has_permission('Competitions.Edit');
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
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/competitions/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/competitions" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<?php echo form_open($this->uri->uri_string()); ?>
			<div class="box-body">
			
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'active' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('competitions_active')); ?></li>
					<li<?php echo $filter_type == 'inactive' ? ' class="active"' : ''; ?>><?php echo anchor("{$index_url}inactive/", lang('competitions_ended')); ?>
					</li>
				</ul>
			
			

					
					
					
				<div class="table-responsive">
					<table id="competitions" class='table table-striped'>
						<thead>
							<tr>
								<?php if ($can_delete && $has_records) : ?>
								<th class='column-check'><input class='check-all' type='checkbox' /></th>
								<?php endif;?>
								
								<th><?php echo lang('competitions_field_name'); ?></th>
								<th></th>
								<th><?php echo lang('competitions_field_sport'); ?></th>
								<th><?php echo lang('competitions_field_league'); ?></th>
								<th><?php echo lang('competitions_field_price_pool'); ?></th>
								<th><?php echo lang('competitions_field_active'); ?></th>
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
								
								<?php if ($can_edit) : ?>
									<td><?php echo anchor(SITE_AREA . '/dashboard/competitions/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->name); ?></td>
								<?php else : ?>
									<td><?php e($record->name); ?></td>
								<?php endif; ?>
								
								<td>
									<?php echo date('M d,Y', strtotime($record->start_date)); ?>
									<span class="mh10">-</span><?php echo date('M d,Y', strtotime($record->end_date)); ?>
								</td>
								
								<?php if ($record->sport_id) : ?>
								<td><img class="h30" src="<?php echo base_url();?>uploads/sports/<?php echo $this->sports_model->get_sport_icon_by_id($record->sport_id);?>"/></td>
								<?php else : ?>
								<td>-</td>
								<?php endif; ?>
								
								
								<?php if ($record->league_id) : ?>
								<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
								<td>
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
									<?php echo $this->leagues_model->get_league_name_by_id($record->league_id) ?>
								</td>
								<?php else : ?>
								<td>-</td>
								<?php endif; ?>							


								<td class="text-blue"><?php e($record->price_pool); ?><span class="ml5"><?php echo $record->currency;?></span></td>
								
								<td><?php if ($record->active) : ?>
								<span class="label label-success"><?php echo lang('us_active'); ?></span>
								<?php else : ?>
								<span class="label label-warning"><?php echo lang('us_inactive'); ?></span>
								<?php endif; ?>
								</td>
								<td>
									<a class="btn btn-xs btn-grey" href="<?php echo site_url();?>admin/dashboard/rewards/index/competition_id-<?php echo $record->id;?>"><?php echo lang('competitions_field_rewards'); ?></a>
								</td>
							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('competitions_records_empty'); ?></td>
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
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('competitions_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		<?php echo form_close(); ?>
	</div>
	
<script type="text/javascript">
    //Check and uncheck all functionality
	$(".check-all").click(function () {
        $('#competitions tbody input[type="checkbox"]').prop('checked', this.checked);
    });	
</script>	