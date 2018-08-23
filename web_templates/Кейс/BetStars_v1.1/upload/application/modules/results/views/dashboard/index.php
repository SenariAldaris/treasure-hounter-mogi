
<?php

$num_columns	= 9;
$has_records	= isset($records) && is_array($records) && count($records);

?>

	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/results" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
            <div class="box-body">
			
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('results_tab_all')); ?></li>
					<li class="<?php echo $filter_type == 'sport_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('results_tab_sports');
							echo isset($filter_sport) ? ": {$filter_sport}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu">
							<?php foreach ($sports as $sport) : ?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/results/index/sport_id-<?php echo $sport->id;?>">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($sport->icon); ?>"/>
									<?php echo $sport->name; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</li>
					<li class="<?php echo $filter_type == 'league_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('results_tab_leagues');
							echo isset($filter_league) ? ": {$filter_league}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu" style="height:600px;overflow:auto;">
							<?php foreach ($leagues as $league) : ?>
							<?php $sport_icon = $this->sports_model->get_sport_icon_by_id($league->sport_id);?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/results/index/league_id-<?php echo $league->league_id;?>">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($sport_icon); ?>"/>
									<img class="h30 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($league->country_id)); ?>"/>
									<?php echo $league->league_name; ?>
								</a>	
							</li>
							<?php endforeach; ?>
						</ul>
					</li>
				</ul>				
				<div class="table-responsive">
					<table id="events_table" class="table table-striped" role="grid">
						<thead>
							<tr>
								<th><?php echo lang('results_championship_id'); ?></th>
								<th></th>
								<th></th>
								<th></th>
								<th><?php echo lang('results_event'); ?></th>								
								<th></th>
								<th></th>
								<th></th>
								<th><?php echo lang('results_date'); ?></th>
								<th><?php echo lang('results_time'); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :
							?>
							<tr>
								<td class="text-left">
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
									
									<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
								
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
						
																		
								</td>	
								<input type="hidden" name="id[]" id="id" value="<?php echo $record->id; ?>" />	
								<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>" />	
								
								<td class="text-blue text-right">
									<?php e($record->home_team); ?>
								</td>
								<td class="w30 text-right">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
								</td>
								<td class="w50 pn">
									<input type="text" class="form-control" name="home[]" id="home" value="<?php echo $record->home; ?>" />
								</td>	
								<td class="pn"><span class="text-black mh5">-</span></td>
								<td class="w50 pn">
									<input type="text" class="form-control" name="away[]" id="away" value="<?php echo $record->away; ?>" />
								</td>	
								<td class="w30 text-left">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($record->away_team),$record->league_id)); ?>"/>
								</td>	
								<td class="text-blue text-left">
									<?php e($record->away_team); ?>	
								</td>	
								
								<td><?php echo date('M j, Y', strtotime($record->match_date)); ?></td>
								<td><?php echo date('H:i T', strtotime($record->match_time)); ?></td>
								
							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('results_records_empty'); ?></td>
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
								<input type="submit" name="save" class="btn btn-blue" value="<?php echo lang('bf_action_save'); ?>" />
								<?php echo $this->pagination->create_links();?>
							</td>
						</tr>

			</div>
			<?php endif; ?>
		<?php echo form_close(); ?>	

	</div><!-- /.box -->


	
<script type="text/javascript">
    //Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#events_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
</script>