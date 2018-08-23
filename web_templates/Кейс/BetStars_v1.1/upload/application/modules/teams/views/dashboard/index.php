

<?php

$num_columns	= 3;
$can_delete	= $this->auth->has_permission('Teams.Delete');
$can_edit		= $this->auth->has_permission('Teams.Edit');
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
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/teams" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<?php echo form_open($this->uri->uri_string()); ?>
			<div class="box-body">
			
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('teams_tab_all')); ?></li>
					<li class="<?php echo $filter_type == 'league_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('teams_tab_leagues');
							echo isset($filter_league) ? ": {$filter_league}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu" style="height:600px;overflow:auto;">
							<?php foreach ($leagues as $league) : 
								$country_id = $this->leagues_model->get_league_country_by_id($league->league_id);
							    $sport_id = $this->leagues_model->get_league_sport_id_by_id($league->league_id);
								$sport_icon = $this->sports_model->get_sport_icon_by_id($sport_id);?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/teams/index/league_id-<?php echo $league->league_id;?>">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($sport_icon); ?>"/>
									<img class="h30 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
									<?php echo $league->league_name; ?>
								</a>	
							</li>
							<?php endforeach; ?>
						</ul>
					</li>

				</ul>				
				<div class="table-responsive">
					<table id="teams_table" class="table table-stripped " role="grid">
						<thead>
							<tr>
								<th><?php echo lang('teams_league'); ?></th>
								
								<th><?php echo lang('teams_name'); ?></th>
								<th><?php echo lang('teams_logo'); ?></th>								
								
							</tr>
						</thead>
						<?php if ($has_records) : ?>
						<?php endif; ?>
						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :
							?>
							<tr>
								
								<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
								<td class="text-left pl50">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
									<img class="h30 mtm4" class="mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
									<?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?></td>
								</td>	
								
								<?php if ($can_edit) : ?>
									<td><?php echo anchor(SITE_AREA . '/dashboard/teams/edit/' . $record->team_id, '<span class="icon-pencil"></span> ' .  $record->name); ?></td>
								<?php else : ?>
									<td><?php e($record->name); ?></td>
								<?php endif; ?>

									
								<td><img class="h30 mtm2" src="<?php echo base_url();?>uploads/teams/<?php e($record->logo); ?>"/></td>
								
							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('teams_records_empty'); ?></td>
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


	<script>
		//Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#teams_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
	</script>	