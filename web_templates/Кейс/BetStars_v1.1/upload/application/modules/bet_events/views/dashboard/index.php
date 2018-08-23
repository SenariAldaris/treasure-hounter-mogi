
<?php

$num_columns	= 6;
$can_edit		= $this->auth->has_permission('Bet_events.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>

	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/bet_events" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string()); ?>
            <div class="box-body">
			
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('bet_events_tab_all')); ?></li>
					<li class="<?php echo $filter_type == 'sport_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('bet_events_tab_sports');
							echo isset($filter_sport) ? ": {$filter_sport}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu">
							<?php foreach ($sports as $sport) : ?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/bet_events/index/sport_id-<?php echo $sport->id;?>">
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
							echo lang('bet_events_tab_leagues');
							echo isset($filter_league) ? ": {$filter_league}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu" style="height:600px;overflow:auto;">
							<?php foreach ($leagues as $league) : ?>
							<?php $sport_icon = $this->sports_model->get_sport_icon_by_id($league->sport_id);?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/bet_events/index/league_id-<?php echo $league->league_id;?>">
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
								<th><?php echo lang('bet_events_championship'); ?></th>
								<th class="pn"></th>
								<th class="pn"></th>
								<th><?php echo lang('bet_events_match'); ?></th>
								<th class="pn"></th>
								<th class="pn"></th>
								<th><?php echo lang('bet_events_date'); ?></th>
								<th><?php echo lang('bet_events_time'); ?></th>
								<th><?php echo lang('bet_events_featured'); ?></th>
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

								<?php if ($can_edit) : ?>
									<td class="text-right">
										<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
										<?php e($record->home_team); ?>
									</td>
									<td class="w30 pn text-right">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
									</td>
									<td class="pn">
										<a href="<?php echo base_url('admin/dashboard'); ?>/bet_events/edit/<?php echo $record->id; ?>">
											<span class="text-blue mh5">edit</span>
										</a>
									</td>
									<td class="w30 pn text-left">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($record->away_team),$record->league_id)); ?>"/>
									</td>	
									<td class="text-left">
										<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
										<?php e($record->away_team); ?>	
									</td>
								<?php else : ?>
									<td class="text-right">
										<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
										<?php e($record->home_team); ?>
									</td>
									<td class="w30 pn text-right">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
									</td>
									<td class="pn"><span class="text-black mh5">-</span></td>
									<td class="w30 pn text-left">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($record->away_team),$record->league_id)); ?>"/>
									</td>	
									<td class="text-left">
										<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
										<?php e($record->away_team); ?>	
									</td>
								<?php endif; ?>
								
								<td><?php echo date('M j, Y', strtotime($record->match_date)); ?></td>
								<td><?php echo date('H:i T', strtotime($record->match_time)); ?></td>
								<td>
									<?php if ($record->featured) : ?>
									<span class="label label-success"><?php echo lang('bf_yes'); ?></span>
									<?php else : ?>
									<span class="label label-warning"><?php echo lang('bf_no'); ?></span>
									<?php endif; ?>
									
								</td>

							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('bet_events_records_empty'); ?></td>
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
	$("#check-all").click(function () {
        $('#events_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
</script>