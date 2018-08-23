
<?php $league_id = $this->uri->segment(3);
$league_name = $this->leagues_model->get_league_name_by_id($league_id);?>

<?php $sport_id = $this->leagues_model->get_league_sport_id_by_id($league_id);
$sport_name = $this->sports_model->get_sport_name_by_id($sport_id);?>
	<div class="box">
		<div class="box-header bg-white">

			<h4 class="head text-left pl10 fs14">
			<img class="h30 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport_id)); ?>"/>
			<?php $country_id = $this->leagues_model->get_league_country_by_id($league_id); ?>
			<img class="h30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
			<span class="bg-grey text-black p5"><?php e($league_name); ?></span>
			
			<form id="sport_form" class="form-inline">
			    <span class="pull-right mr20 hidden-xs" style="position: absolute;right: 0;top: 25px;">

						<div class="form-group <?php echo form_error('sport_id') ? ' has-error' : ''; ?>">
							<label class="control-label mr20"><?php echo lang('bet_events_filter_by_sport');?></label>
							<select name="sport_id" id="sport_id" class="form-control">
								<option value=""><?php echo lang('bet_events_select_sport');?></option>
								<?php foreach ($sports->result() as $sport) {
									$sel = ($sport->id==set_value('sport_id'))?'selected="selected"':'';
									?>
									<option value="<?php echo $sport->id;?>" <?php echo $sel;?>><?php echo $sport->name;?></option>
								<?php }?>
							</select>
						</div>
					<button type="submit" id="sport_filter" class="btn btn-white"><?php echo lang('bet_events_filter'); ?></button>
					<button class="gobottom pull-right btn btn-white ml10"><i class="fa fa-arrow-down"></i></button>
			    </span>
			</form>
			
			</h4>

		</div>	
		<div class="box-body ptn">	
		
		
			<ul class="nav nav-tabs mb10">
				<li class="active"><a href="#events" data-toggle="tab" aria-expanded="true"><?php echo lang('bet_events_todays_events'); ?></a></li>
				<li class=""><a href="#upcoming" data-toggle="tab" aria-expanded="true"><?php echo lang('bet_events_upcoming_fixtures'); ?></a></li>
				<li class=""><a href="#results" data-toggle="tab" aria-expanded="true"><?php echo lang('bet_events_latest_results'); ?></a></li>
				<li class=""><a href="#outright" data-toggle="tab" aria-expanded="true"><?php echo lang('bet_events_outright_winner'); ?></a></li>
			</ul>
			
			<div class="tab-content">		

				<div class="tab-pane active fade in" id="events">
					<div class="table-responsive">

						<table id="events_table" class="table table-striped" role="grid">
							<thead class="bg-black">
								<tr>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('bet_events_event'); ?></th>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="pn w100"><?php echo lang('bet_events_time'); ?></th>
									<th class="pn w80"><?php echo lang('bet_events_home'); ?></th>
									<th class="pn w80"><?php echo lang('bet_events_draw'); ?></th>
									<th class="pn w80"><?php echo lang('bet_events_away'); ?></th>
									<th class="pn w100"><?php echo lang('bet_events_all_bets'); ?></th>
								</tr>
							</thead>				
						
							<tbody>
								
								<?php $records = $this->bet_events_model->get_live_events_by_league($league_id);
								
								if (isset($records) && is_array($records) && count($records)) :

								foreach ($records as $record) :?>
								
								

								<tr>		
									<td class="text-blue text-right">
										<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
										<?php e($record->home_team); ?>
									</td>
									<td class="w30 pn text-right">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
									</td>
									<td class="w20 pn"><span class="text-black mh5">-</span></td>
									<td class="w30 pn text-left">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->away_team,$record->league_id)); ?>"/>
									</td>	
									<td class="text-blue text-left">
										<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
										<?php e($record->away_team); ?>	
									</td>		


									<td class="w100"><?php echo date('H:i T', strtotime($record->match_time)); ?></td>
									
									<td class="w50 pn">
										<?php $home_odds = $this->bet_events_model->get_home_odds($record->match_id);?>
										<?php if ($home_odds): ?>
											<span class="text-blue">									
												<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
												<?php $bet_id = $this->bet_events_model->get_home_bet_id($record->match_id);?>
													<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
													<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
													<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
													<input type="hidden" name="choice_name" id="choice_name" value="<?php echo $record->home_team;?>">
													<?php $choice_id = $this->bet_events_model->get_home_choice_id($record->match_id);?>
													<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
													<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
													<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
													<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
													<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
													<input type="hidden" name="odds" id="odds" value="<?php echo $home_odds;?>">
													<input type="submit" class="text-blue" value="<?php printf("%.2f", $home_odds); ?>">
												<?php echo form_close();?>
											</span>
										<?php endif;?>
									</td>
									<td class="w50 pn"><?php $draw_odds = $this->bet_events_model->get_draw_odds($record->match_id);?>
										<?php if ($draw_odds): ?>
											<span class="text-blue">
												<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
												<?php $bet_id = $this->bet_events_model->get_draw_bet_id($record->match_id);?>
													<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
													<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
													<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
													<input type="hidden" name="choice_name" id="choice_name" value="Draw">
													<?php $choice_id = $this->bet_events_model->get_draw_choice_id($record->match_id);?>
													<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
													<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
													<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
													<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
													<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
													<input type="hidden" name="odds" id="odds" value="<?php echo $draw_odds;?>">
													<input type="submit" class="text-red" value="<?php printf("%.2f", $draw_odds); ?>">
												<?php echo form_close();?>
											</span>
										<?php endif;?>
									</td>
									<td class="w50 pn"><?php $away_odds = $this->bet_events_model->get_away_odds($record->match_id);?>
										<?php if ($away_odds): ?>
											<span class="text-blue">
												<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
												<?php $bet_id = $this->bet_events_model->get_away_bet_id($record->match_id);?>
													<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
													<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
													<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
													<input type="hidden" name="choice_name" id="choice_name" value="<?php echo $record->away_team;?>">
													<?php $choice_id = $this->bet_events_model->get_away_choice_id($record->match_id);?>
													<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
													<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
													<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
													<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
													<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
													<input type="hidden" name="odds" id="odds" value="<?php echo $away_odds;?>">
													<input type="submit" class="text-blue" value="<?php printf("%.2f", $away_odds); ?>">
												<?php echo form_close();?>
											</span>
										<?php endif;?>
									</td>							

									<td class="w100 pn">
										<?php echo form_open(base_url('tips/insert_bet') . '/' . $record->match_id, 'class="form-horizontal"'); ?>	
										<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
										<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
										<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">								
										<input type="submit" class="btn btn-green" value="<?php echo lang('bet_events_all_bets'); ?>">
										<?php echo form_close();?>
									</td>

								</tr>
								
								<?php endforeach; ?>
								
								<?php else:?>
									

								<tr class="">
									 <td colspan="10" class="text-left text-red pl50"><?php echo lang('bet_events_no_events'); ?></td>
								</tr>

								<?php endif;?>	
									
							</tbody>
						</table>

					</div>	
				</div>

				<div class="tab-pane fade in" id="upcoming">
					<div class="table-responsive">

						<table id="events_table" class="table table-striped" role="grid">
							<thead class="bg-black">
								<tr>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('bet_events_event'); ?></th>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('bet_events_date'); ?></th>
									<th class="pn"><?php echo lang('bet_events_home'); ?></th>
									<th class="pn"><?php echo lang('bet_events_draw'); ?></th>
									<th class="pn"><?php echo lang('bet_events_away'); ?></th>
									<th class="w100 pn"><?php echo lang('bet_events_all_bets'); ?></th>
								</tr>
							</thead>				
						
							<tbody>
								
								<?php $records = $this->bet_events_model->get_upcoming_events_by_league($league_id);
								
								if (isset($records) && is_array($records) && count($records)) :

								foreach ($records as $record) :?>
								
								

								<tr>		
									<td class="text-blue text-right">
										<?php e($record->home_team); ?>
									</td>
									<td class="w30 pn text-right">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
									</td>
									<td class="pn"><span class="text-black mh5">-</span></td>
									<td class="w30 pn text-left">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->away_team,$record->league_id)); ?>"/>
									</td>	
									<td class="text-blue text-left">
										<?php e($record->away_team); ?>	
									</td>		

									
									<td class="w100">
										<span class="label label-black"><?php echo date('M d,Y', strtotime($record->match_date)); ?></span>
									</td>
									
									<td class="w60">
										<?php $home_odds = $this->bet_events_model->get_home_odds($record->match_id);?>
										<?php if ($home_odds): ?>
											<span class="text-blue">									
												<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
												<?php $bet_id = $this->bet_events_model->get_home_bet_id($record->match_id);?>
													<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
													<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
													<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
													<input type="hidden" name="choice_name" id="choice_name" value="<?php echo $record->home_team;?>">
													<?php $choice_id = $this->bet_events_model->get_home_choice_id($record->match_id);?>
													<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
													<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
													<input type="hidden" name="match_date" id="match_date" value="<?php echo $record->match_date; ?>">
													<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
													<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
													<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
													<input type="hidden" name="odds" id="odds" value="<?php echo $home_odds;?>">
													<input type="submit" class="text-blue" value="<?php printf("%.2f", $home_odds); ?>">
												<?php echo form_close();?>
											</span>
										<?php endif;?>
									</td>
									<td class="w60">
										<?php $draw_odds = $this->bet_events_model->get_draw_odds($record->match_id);?>
										<?php if ($draw_odds): ?>
											<span class="text-blue">
												<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
												<?php $bet_id = $this->bet_events_model->get_draw_bet_id($record->match_id);?>
													<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
													<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
													<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
													<input type="hidden" name="choice_name" id="choice_name" value="Draw">
													<?php $choice_id = $this->bet_events_model->get_draw_choice_id($record->match_id);?>
													<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
													<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
													<input type="hidden" name="match_date" id="match_date" value="<?php echo $record->match_date; ?>">
													<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
													<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
													<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
													<input type="hidden" name="odds" id="odds" value="<?php echo $draw_odds;?>">
													<input type="submit" class="text-red" value="<?php printf("%.2f", $draw_odds); ?>">
												<?php echo form_close();?>
											</span>
										<?php endif;?>
									</td>
									<td class="w60">
										<?php $away_odds = $this->bet_events_model->get_away_odds($record->match_id);?>
										<?php if ($away_odds): ?>
											<span class="text-blue">
												<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
												<?php $bet_id = $this->bet_events_model->get_away_bet_id($record->match_id);?>
													<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
													<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
													<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
													<input type="hidden" name="choice_name" id="choice_name" value="<?php echo $record->away_team;?>">
													<?php $choice_id = $this->bet_events_model->get_away_choice_id($record->match_id);?>
													<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
													<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
													<input type="hidden" name="match_date" id="match_date" value="<?php echo $record->match_date; ?>">
													<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
													<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
													<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
													<input type="hidden" name="odds" id="odds" value="<?php echo $away_odds;?>">
													<input type="submit" class="text-blue" value="<?php printf("%.2f", $away_odds); ?>">
												<?php echo form_close();?>
											</span>
										<?php endif;?>
									</td>							

									<td class="fr">
										<?php echo form_open(base_url('tips/insert_bet') . '/' . $record->match_id, 'class="form-horizontal"'); ?>	
										<input type="hidden" name="match_date" id="match_date" value="<?php echo $record->match_date; ?>">
										<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">	
										<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
										<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">										<input type="submit" class="btn btn-green" value="<?php echo lang('bet_events_all_bets'); ?>">
										<?php echo form_close();?>
									</td>		
								</tr>
								
								<?php endforeach; ?>
								
								<?php else:?>
									
								<tr class="">
									<td colspan="10" class="text-left text-red pl50"><?php echo lang('bet_events_no_upcoming_events'); ?></td>
								</tr>
								<?php endif;?>	
									
							</tbody>
						</table>

					</div>	
				</div>
			
				
				<div class="tab-pane fade in" id="results">
				
					<div class="table-responsive">

						<table id="events_table" class="table table-striped" role="grid">
							<thead class="bg-black">
								<tr>
									
									<th class="pn"><?php echo lang('bet_events_date'); ?></th>
									<th class="pn"><?php echo lang('bet_events_time'); ?></th>
									<th class="pn"><?php echo lang('bet_events_home'); ?></th>
									
									<th class="pn"></th>
									<th class="pn"><?php echo lang('bet_events_result'); ?></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('bet_events_away'); ?></th>
									
								</tr>
							</thead>				
						
							<tbody>
								
								<?php $records = $this->results_model->get_by_league($league_id);
								
								if (isset($records) && is_array($records) && count($records)) :

								foreach ($records as $record) :?>
								<tr>		
									<td class="w100">
										<span class="label label-black"><?php echo date('M d,Y', strtotime($record->match_date)); ?></span>
									</td>
									<td class="w80"><?php echo date('H:i T', strtotime($record->match_time)); ?></td>
									
									<td class="text-blue text-right mr10">
										<?php echo $record->home_team;?>
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
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->away_team,$record->league_id)); ?>"/>
									</td>
									<td class="text-blue text-left ml10">
										<?php echo $record->away_team;?>
									</td>	

									

								</tr>
								
								<?php endforeach; ?>
								
								<?php else:?>
									
								<tr class="">
									<td colspan="6" class="text-left text-red pl50"><?php echo lang('bet_events_no_results'); ?></td>

								</tr>
								<?php endif;?>	
									
							</tbody>
						</table>

					</div>					
				
				
				
				</div>
				
				<div class="tab-pane fade in" id="outright">
				
					<div class="table-responsive">

						<table id="events_table" class="table table-striped" role="grid">
							<thead class="bg-black">
								<tr>
									<th class="pn"><?php echo lang('bet_events_date'); ?></th>
									<th class="pn"><?php echo lang('bet_events_event'); ?></th>
									<th class="pn"><?php echo lang('bet_events_odds'); ?></th>
								</tr>
							</thead>				
						
							<tbody>
								
								<?php $records = $this->bet_events_model->get_outright_bets($league_id);
								
								if (isset($records) && is_array($records) && count($records)) :

								foreach ($records as $record) :?>

								<tr>		

									<td class="">
										<?php echo $record->match_date; ?>
									</td>
									<td class="text-blue text-left">
										<img class="h30 mtm4 mr20" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->choice_name,$record->league_id)); ?>"/>
										<?php echo $record->choice_name;?>
									</td>	

									<td class="fr">
										<span class="text-blue">
											
											<?php echo form_open(base_url('tips/outright_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
											<?php $bet_id = $this->bet_events_model->get_outright_bet_id($league_id);?>
												<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
												<input type="hidden" name="bet_name" id="bet_name" value="Outright Winner">
												<input type="hidden" name="choice_name" id="choice_name" value="<?php echo $record->choice_name;?>">
												<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $record->choice_id; ?>">
												<input type="hidden" name="sport_id" id="sport_id" value="<?php echo $sport_id; ?>">
												<input type="hidden" name="league_id" id="league_id" value="<?php echo $league_id; ?>">
												<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
												<input type="hidden" name="match_date" id="match_date" value="<?php echo $record->match_date; ?>">
												<input type="hidden" name="odds" id="odds" value="<?php echo $record->odd;?>">
												<input type="submit" class="btn btn-clean" value="<?php printf("%.2f", $record->odd); ?>">
											<?php echo form_close();?>
										</span>
									</td>		
								</tr>
								
								<?php endforeach; ?>
								
								<?php else:?>
									
								<tr class="">
									<td class="text-left text-red pl50"><?php echo lang('bet_events_no_bets'); ?></td>
									<td></td>
									<td></td>
								</tr>
								<?php endif;?>	
									
							</tbody>
						</table>

					</div>					
				
				
				
				</div>

				
			</div><!-- /.tab-content -->

				
		</div><!-- /.box-body -->
		
	</div>

<script type="text/javascript">
  // Define site_url variable for use in the js file
  var site_url = "<?php echo site_url(); ?>";
</script>