
<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Leagues.Delete');
$can_edit		= $this->auth->has_permission('Leagues.Edit');
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
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/leagues" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<?php echo form_open($this->uri->uri_string()); ?>
			<div class="box-body">
			
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('leagues_tab_all')); ?></li>
					<li<?php echo $filter_type == 'inactive' ? ' class="active"' : ''; ?>><?php echo anchor("{$index_url}inactive/", lang('leagues_tab_inactive')); ?></li>
					<li class="<?php echo $filter_type == 'sport_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('leagues_tab_sports');
							echo isset($filter_sport) ? ": {$filter_sport}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu">
							<?php foreach ($sports as $sport) : ?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/leagues/index/sport_id-<?php echo $sport->id;?>">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($sport->icon); ?>"/>
									<?php echo $sport->name; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</li>

				</ul>			
				<div class="table-responsive">
					<table id="leagues_table" class="table table-striped" role="grid">
						<thead>
							<tr>
								<?php if ($can_edit && $has_records) : ?>
								<th class="column-check"><input id="check-all" type="checkbox" /></th>
								<?php endif;?>
								<th><?php echo lang('leagues_sport'); ?></th>
								<th><?php echo lang('leagues_country'); ?></th>
								<th><?php echo lang('leagues_name'); ?></th>
								<th><?php echo lang('leagues_active'); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :
							?>
							<tr>
								<?php if ($can_edit) : ?>
								<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
								<?php endif;?>

								<td class="w50">
									<img class="h30 mtm4"src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
								</td>
								
								<td class="text-left">
									<img class="h30 mr10 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($record->country_id)); ?>"/>
									<?php echo $this->countries_model->get_country_name_by_id($record->country_id);?>
								</td>		
								
								<?php if ($can_edit) : ?>
									<td><?php echo anchor(SITE_AREA . '/dashboard/leagues/edit/' . $record->id, $record->league_name); ?></td>
								<?php else : ?>
									<td><?php e($record->league_name); ?></td>
								<?php endif; ?>

							
								
								<td><?php if ($record->active) : ?>
								<span class="label label-success"><?php echo lang('us_active'); ?></span>
								<?php else : ?>
								<span class="label label-warning"><?php echo lang('us_inactive'); ?></span>
								<?php endif; ?>
								</td>
							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('leagues_records_empty'); ?></td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>	
				</div>
			</div><!-- /.box-body -->
				<?php if ($has_records) : ?>
					<div class="box-footer">

							<?php echo lang('bf_with_selected'); ?>
							<input type="submit" name="activate" class="btn btn-green" value="<?php echo lang('bf_action_activate'); ?>" />
							<input type="submit" name="deactivate" class="btn btn-yellow" value="<?php echo lang('bf_action_deactivate'); ?>" />
							<?php echo $this->pagination->create_links();?>

					</div>
				<?php endif; ?>
		<?php echo form_close(); ?>
	</div><!-- /.box -->

<script type="text/javascript">
	//Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#leagues_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
</script>