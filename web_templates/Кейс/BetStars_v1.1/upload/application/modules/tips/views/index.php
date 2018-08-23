	<div class="box">
		<div class="box-body">
				<?php echo form_open($this->uri->uri_string()); ?>
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('tips_tab_all')); ?></li>
					
					<li class="<?php echo $filter_type == 'sport_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('tips_tab_sport');
							echo isset($filter_sport) ? ": {$filter_sport}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu">
							<?php foreach ($sports as $sport) : ?>
							<li>
								<a href="<?php echo base_url();?>tips/index/sport_id-<?php echo $sport->id;?>">
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
							echo lang('tips_tab_league');
							echo isset($filter_league) ? ": {$filter_league}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu" style="height:600px;overflow:auto;">
							<?php foreach ($leagues as $league) : ?>
							<?php $sport_icon = $this->sports_model->get_sport_icon_by_id($league->sport_id);?>
							<li>
								<a href="<?php echo base_url();?>tips/index/league_id-<?php echo $league->league_id;?>">
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
					<table class='table table-striped'>
						<thead class="bg-black">
							<tr>
								<th class="pn"><?php echo lang('tips_championship'); ?></th>
								<th class="pn"></th>
								<th class="pn"></th>
								<th class="pn"><?php echo lang('tips_match'); ?></th>
								<th class="pn"></th>
								<th class="pn"></th>
								<th class="pn"><?php echo lang('tips_tipster'); ?></th>
								<th class="pn"></th>
							</tr>
						</thead>					
						<tbody>
					
					<?php if (isset($records) && is_array($records) && count($records)) : 

						foreach ($records as $record) :?>
						
						<tr>
							
							<td class="text-left">
								<img class="h30 mtm4 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
								<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
										
								<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>		
								<span class="fs12 mr10">
								
								<?php $league_name = $this->leagues_model->get_league_name_by_id($record->league_id); 
								echo substr($league_name, 0, 13)?> ...
								</span>
							</td>
							<?php if($record->bet_name == 'Outright Winner'):?>
								<td class="text-right"><?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?></td>
								<td></td>
								<td class="pn">
									<a href="<?php echo base_url(); ?>tips/preview/<?php echo $record->id; ?>">
										<span class="text-blue mh5">info</span>
									</a>	
								</td>
								<td></td>
								<td></td>
							<?php else: ?>
							
							<?php $match = $this->tips_model->get_match_by_id($record->match_id);
							
								foreach($match as $rec):?>

								<td class="text-right">
									<?php e($rec->home_team); ?>	
								</td>	
								<td class="w30 pn text-right">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->home_team,$record->league_id)); ?>"/>
								</td>
								<td class="pn">
									<a href="<?php echo base_url(); ?>tips/preview/<?php echo $record->id; ?>">
										<span class="text-blue mh5">info</span>
									</a>	
								</td>
								<td class="w30 pn text-left">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->away_team,$record->league_id)); ?>"/>
								</td>	
								<td class="text-left">
									<?php e($rec->away_team); ?>	
								</td>	

							<?php endforeach;?>
							<?php endif; ?>
							
							<div class="fr">
							<td>

								<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->created_by;?>">	
									 <?php echo $this->tipsters_model->get_user_display_name_by_id($record->created_by);?>
								</span>
							</td>	
							
							</div>

						</tr>
						<?php endforeach; 
						else:?>
						
							<tr class="">
								<td colspan="8" class="text-left text-red pl50"><?php echo lang('tips_records_empty'); ?></td>

							</tr>
						
						</tbody>
						<?php endif; ?>	
					</table>	


				</div>
			<?php echo form_close(); ?>	

<script type="text/javascript">
  // Define site_url variable for use in the js file
  var site_url = "<?php echo site_url(); ?>";
</script>	
