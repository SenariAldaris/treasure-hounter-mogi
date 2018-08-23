			
	<div class="box mb20">
		<div class="box-body">
			<?php $league_id = $this->uri->segment(3); 
			
			$league = $this->leagues_model->get_league_name_by_id($league_id); 
			$sport = $this->leagues_model->get_league_sport_id_by_id($league_id);?>

			
			<h4 class="head pl10 fs14 text-left">
			<a href="<?php echo base_url();?>tips/index/sport_id-<?php echo $sport;?>">
				<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport)); ?>"/>
			</a>
			<?php $country_id = $this->leagues_model->get_league_country_by_id($league_id); ?>
			<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
			<a href="<?php echo base_url();?>tips/by_league/<?php echo $league_id;?>">
			</a>	
			<span class="mr10"><?php echo $league;?></span> 
			<?php echo lang('tips_tips'); ?> 
			</h4>	


			<?php if (isset($records) && is_array($records) && count($records)) : ?>
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
						<th class="pn"><?php echo lang('tips_posted_on'); ?></th>
						<th class="pn"></th>
					</tr>
				</thead>				
				<tbody>								
						<?php foreach ($records as $record) : ?>
									
					<tr>
						
						<td class="text-left">
							<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
							<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id); ?>
							<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
							<span class="fs12 mr5"><?php $league_name = $this->leagues_model->get_league_name_by_id($record->league_id); ?>
							<?php echo substr($league_name, 0, 13)?> ...
							</span>
						</td>
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
						<div class="fr">
							<td class="hidden-xs">

								<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->created_by;?>">	
									 <?php echo $this->tipsters_model->get_user_display_name_by_id($record->created_by);?>
								</span>
							</td>	
							<td class="hidden-xs">	
								<?php echo relative_time(strtotime($record->created_on)); ?>

								 
							
							</td>
						</div>
						
					
					</tr>		

					<?php endforeach; ?>
				</tbody>
			</table>					
					<?php else:?>
					
					<div class='alert alert-info mt20'>
						<?php echo lang('tips_records_empty'); ?>
					</div>
					
		

			<?php endif; ?>
			
		</div>
	</div>	

	<div class="box">
		<div class="box-body">
		
			<h4 class="head pl10 fs14 text-left">
			<a href="<?php echo base_url();?>tips/index/sport_id-<?php echo $sport;?>">
				<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport)); ?>"/>
			</a>
			<?php $country_id = $this->leagues_model->get_league_country_by_id($league_id); ?>
				<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
				<a href="<?php echo base_url();?>tips/by_league/<?php echo $league_id;?>"></a>
				<span class="mr10"><?php echo $league;?></span> 
				
			<?php echo lang('tips_active_events'); ?> 
			</h4>	
			
			<div class="table-responsive">
				<table class="table table-striped" role="grid">
					<thead class="bg-black">
						<tr>
							<th class="pn"><?php echo lang('tips_championship'); ?></th>
							<th class="pn"></th>
							<th class="pn"></th>
							<th class="pn"><?php echo lang('tips_match'); ?></th>
							<th class="pn"></th>
							<th class="pn"></th>
							<th class="pn"><?php echo lang('tips_match_date'); ?></th>
							<th class="pn"><?php echo lang('tips_match_time'); ?></th>
							<th class="pn"></th>
						</tr>
					</thead>					
				
					<tbody>
						<?php $events = $this->bet_events_model->limit(10)->where(array('league_id' => $league_id,))->get_active_events();

						if (isset($events) && is_array($events) && count($events)) :

						foreach ($events as $record) :?>

						<tr>			
							<td class="text-left">
								
								<a href="<?php echo base_url();?>tips/index/sport_id-<?php echo $record->sport_id;?>">
									<img class="h24 mtm4 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
								</a>
								<input type="hidden" id="sport_sel" value="<?php echo $record->sport_id; ?>"/>
								<?php $country_id = $this->leagues_model->get_league_country_by_id($league_id); ?>
								<img class="h24 mtm4 mr5" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
								
								<?php $league_name = $this->leagues_model->get_league_name_by_id($record->league_id); ?>
								<?php echo substr($league_name, 0, 8)?> ...
								
							</td>	


							<td class="text-blue text-right">
								<?php e($record->home_team); ?>	
							</td>	
							<td class="w30 pn text-right">	
								<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
							</td>
							<td class="pn">
								<span class="mh5">-</span>	
							</td>
							<td class="w30 pn text-left">	
								<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->away_team,$record->league_id)); ?>"/>
							</td>	
							<td class="text-blue text-left">
								<?php e($record->away_team); ?>	
							</td>	
								
							<td><?php echo date('M d,Y', strtotime($record->match_date)); ?></td>
							<td><?php echo date('H:i T', strtotime($record->match_time)); ?></td>
							<td>
								<?php echo form_open(base_url('tips/insert_bet') . '/' . $record->match_id, 'class="form-horizontal"'); ?>	
								<input type="hidden" name="match_date" id="match_date" value="<?php echo $record->match_date; ?>">
								<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
								<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
								<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">								
								<input type="submit" class="btn btn-clean" value="<?php echo lang('tips_bet_now'); ?>">
								<?php echo form_close();?>
							</td>


						</tr>	

						<?php endforeach; ?>
						
						<?php else: ?>
						<tr>
							<td class="text-left text-red pl50"><?php echo lang('tips_no_active_events'); ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					
					<?php endif;?>						

					</tbody>
				</table>
			</div>		
		</div><!-- /.box-body -->
		
		<div class="box-footer"></div>
		
	</div>	  