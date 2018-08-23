
<?php

$num_columns	= 9;
$has_records	= isset($records) && is_array($records) && count($records);

?>

	<div class="box box-widget">
            <div class="box-body tips">
			
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('results_tab_latest')); ?></li>
					<li class="<?php echo $filter_type == 'sport_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('results_tab_sports');
							echo isset($filter_sport) ? ": {$filter_sport}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu" style="height:600px;overflow:auto;">
							<?php foreach ($sports as $sport) : ?>
							<li>
								<a href="<?php echo base_url();?>results/index/sport_id-<?php echo $sport->id;?>">
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
								<a href="<?php echo base_url();?>results/index/league_id-<?php echo $league->league_id;?>">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($sport_icon); ?>"/>
									<img class="h30 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($league->country_id)); ?>"/>
									<?php echo $league->league_name; ?>
								</a>	
							</li>
							<?php endforeach; ?>
						</ul>
					</li>					
				</ul>				
				<div class="table-responsive mt10">
					<table id="events_table" class="table table-striped" role="grid">
						<thead class="bg-black">
							<tr>
								<th class="pn"><?php echo lang('results_championship_id'); ?></th>
								<th class="pn"></th>
								<th class="pn"></th>
								<th class="pn"><?php echo lang('results_event'); ?></th>								
								<th class="pn"></th>
								<th class="pn"></th>
								<th class="pn"><?php echo lang('results_date'); ?></th>
								<th class="pn"><?php echo lang('results_time'); ?></th>
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
									<?php echo $this->leagues_model->get_league_name_by_id($record->league_id);?>
								</td>	

								
								<td class="text-blue text-right">
									<?php e($record->home_team); ?>
								</td>
								<td class="w30 text-right">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
								</td>
								
								<td class="w100">
									<?php if($record->home > $record->away):?>
									<span class="text-blue"><?php echo $record->home; ?></span>
									<span class="mh5">-</span>
									<?php echo $record->away; ?>
									<?php elseif($record->home < $record->away):?>
									<?php echo $record->home; ?>
									<span class="mh5">-</span>
									<span class="text-blue"><?php echo $record->away; ?></span>	
									<?php else:?>
									<?php echo $record->home; ?>
									<span class="mh5">-</span>
									<?php echo $record->away; ?>
									<?php endif;?>											
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
			<div class="box-footer clearfix">

				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo $this->pagination->create_links();?>
					</td>
				</tr>

			</div>
			<?php endif; ?>
	</div><!-- /.box -->

