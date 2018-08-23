
<?php echo $this->bookmakers_model->get_bookmaker_banner_full();?>



	<div class="box mt20">
		<div class="box-body">
		
			<ul class="nav nav-tabs mb10">
				<li class="active"><a href="#last_minute" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_last_minute_bets'); ?></a></li>
				<li class=""><a href="#popular_bets" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_popular_bets'); ?></a></li>
				
				<li class=""><a href="#latest_tips" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_latest_tips'); ?></a></li>
			</ul>	
			<div class="tab-content">
			
			

				<div class="tab-pane active fade in" id="last_minute">

					<?php if (isset($last_minute) && is_array($last_minute) && count($last_minute)) :?>

				
					<div class="table-responsive">
						<table id="events_table" class="table table-striped" role="grid">
							<thead class="bg-black">
								<tr>
									<th class="pn"><?php echo lang('tips_match_start'); ?></th>
									<th class="pn"><?php echo lang('tips_championship'); ?></th>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('tips_match'); ?></th>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="pn"></th>
								</tr>
							</thead>				
							<tbody>
								<?php  foreach ($last_minute as $record) :?>

								<tr>			
									<td><?php echo date('H:i T', strtotime($record->match_time)); ?></td>
									<td class="text-left">
										<input type="hidden" id="event_sel" value="<?php echo $record->id; ?>"/>
										<img class="h30 mtm2" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
										<input type="hidden" id="sport_sel" value="<?php echo $record->sport_id; ?>"/>
										<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
										<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

										<?php $league_name = $this->leagues_model->get_league_name_by_id($record->league_id); 
										 echo character_limiter($league_name ,6,'&#8230;')?>
										<input type="hidden" id="league_sel" value="<?php echo $record->league_id; ?>"/>
										
									</td>	
									<td class="text-blue text-right">
										<?php e($record->home_team); ?>
									</td>
									<td class="w30 pn text-right">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
									</td>
									<td class="pn"><span class="text-black mh5">-</span></td>
									<td class="w30 pn text-left">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($record->away_team),$record->league_id)); ?>"/>
									</td>	
									<td class="text-blue text-left">
										<?php e($record->away_team); ?>	
									</td>	

									<td>
										<?php echo form_open(base_url('tips/insert_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>
										<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
										<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
										<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
										<input type="submit" class="btn btn-clean" value="Bet now">
										<?php echo form_close();?>
									</td>


								</tr>	

								<?php endforeach;?>						

							</tbody>
						</table>
					</div>

					<?php endif;?>
				</div>				
			


				<div class="tab-pane fade in" id="popular_bets">

					<?php if (isset($popular_bets) && is_array($popular_bets) && count($popular_bets)) :?>

				
					<div class="table-responsive">
						<table id="events_table" class="table table-striped" role="grid">
							<thead class="bg-black">
								<tr>
									<th class="pn"><?php echo lang('tips_championship'); ?></th>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="text-left pn"><?php echo lang('tips_match'); ?></th>
									<th class="pn"></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('tips_match_date'); ?></th>
									<th class="pn"><?php echo lang('tips_match_time'); ?></th>
									<th class="pn"></th>
								</tr>
							</thead>				
							<tbody>
								<?php  foreach ($popular_bets as $record) :?>

								<tr>			
									<td class="text-left pn">
										<input type="hidden" id="event_sel" value="<?php echo $record->id; ?>"/>
										<img class="h30 mtm2 " src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
										<input type="hidden" id="sport_sel" value="<?php echo $record->sport_id; ?>"/>
										<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
										<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

										<?php $league_name = $this->leagues_model->get_league_name_by_id($record->league_id); 
										echo character_limiter($league_name ,6,'&#8230;');?>

										
									</td>	

									<?php $match = $this->tips_model->get_match_by_id($record->match_id);
							
									foreach($match as $rec):?>

									<td class="text-right pn">
										<?php e($rec->home_team); ?>	
									</td>	
									<td class="w30 pn text-right">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->home_team,$record->league_id)); ?>"/>
									</td>
									<td class="pn">
										
											<span class="text-blue mh5">-</span>
									
									</td>
									<td class="w30 pn text-left">	
										<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->away_team,$record->league_id)); ?>"/>
									</td>	
									<td class="text-left pn">
										<?php e($rec->away_team); ?>	
									</td>	
	
								<?php endforeach;?>
									
									<td><?php echo date('Y-m-d', strtotime($record->match_date)); ?></td>
									<td><?php echo date('H:i T', strtotime($record->match_time)); ?></td>

									<td>
										<?php echo form_open(base_url('tips/insert_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>
										<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
										<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
										<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
										<input type="submit" class="btn btn-clean" value="<?php echo lang('tips_bet_now'); ?>">
										<?php echo form_close();?>
									</td>


								</tr>	

								<?php endforeach;?>						

							</tbody>
						</table>
					</div>

					<?php endif;?>
				</div>		


				<div class="tab-pane fade in" id="latest_tips">

					<?php if(isset($records) && is_array($records) && count($records)):?>

						
					<div class="table-responsive">
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
									
								</tr>
							</thead>										
							<tbody>

							<?php foreach ($records as $record) : ?>
							<?php $tipster = $this->tipsters_model->get_user_display_name_by_id($record->created_by);
							$avatar  = $this->tipsters_model->get_user_avatar_by_id($record->created_by);?>

							<tr>
								
								<td class="text-left">
									<img class="h30 mtm2" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
									<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
									<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
									
									<?php $league_name = $this->leagues_model->get_league_name_by_id($record->league_id); 
										echo character_limiter($league_name ,6,'&#8230;');?>
								</td>
								
								
								
								<?php if($record->bet_name == 'Outright Winner'):?>
								<td class="text-right">
									<?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?>
								</td>	
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
								
								<td>
									<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->created_by;?>">	
										<?php echo $this->tipsters_model->get_user_display_name_by_id($record->created_by);?>
									</a>
								</td>	
									
								<td><?php echo relative_time(strtotime($record->created_on)); ?></td>
								
								
							
							</tr>
							<?php endforeach;?>
							</tbody>
						</table>				
					
					</div>
					<?php endif;?>
				</div>
				
			</div>
		</div>		
	</div>
	
	
	
	<div class="row">
		<div class="col-md-6">
	
	
	<!-- TIPS STATS -->

		<div class="box">
			<div class="box-body">					
						
				<h4 class="head fs14 mb20"><?php echo lang('tips_tips_stats');?></h4>							
				
				
				<?php $total = $this->tips_model->count_all_ended_tips();
				
					$won = $this->tips_model->count_all_won_tips();
					$lost = $this->tips_model->count_all_lost_tips();
					$void = $this->tips_model->count_all_void_tips();
					
					if($total > 0) :
					
					$t_won = $won/$total*100;
					$t_lost = $lost/$total*100;
					$t_void = $void/$total*100;
					
					else:

					$t_won = 0;
					$t_lost = 0;
					$t_void = 0;
					
					endif;
				?>

				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_total');?></span>
					<span class="progress-number mr10"><?php echo $total;?></span>
					<div class="progress active">
						<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" 
							aria-valuemax="100" style="width: 100%">
							<span class="sr-only">100% Complete (success)</span>
						</div>
					</div>
				</div><!-- /.progress-group -->
										  
				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_tips_won');?><span class="text-green ml20"><?php echo round($t_won, 2);?> % </span></span>
					<span class="progress-number mr10"><b><?php echo $won;?></b>/<?php echo $total;?></span>
					<div class="progress active">
					  <div class="progress-bar progress-bar-success progress-bar-striped" style="width: <?php echo round($t_won, 2);?>%">
						<span class="sr-only"><?php echo round($t_won, 2);?>% Complete (success)</span>
					  </div>
					</div>
				</div><!-- /.progress-group -->
				 
				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_tips_lost');?><span class="text-red ml20"><?php echo round($t_lost, 2);?> % </span></span>
					<span class="progress-number mr10"><b><?php echo $lost;?></b>/<?php echo $total;?></span>
					<div class="progress active">
					  <div class="progress-bar progress-bar-red progress-bar-striped" style="width:<?php echo round($t_lost, 2);?>%">
						<span class="sr-only"><?php echo round($t_lost, 2);?>% Complete (success)</span>
					  </div>
					</div>
				</div><!-- /.progress-group -->
				 
				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_tips_voided');?><span class="text-yellow ml20"><?php echo round($t_void, 2);?> % </span></span>
					<span class="progress-number mr10"><b><?php echo $void;?></b>/<?php echo $total;?></span>
					<div class="progress active mbn">
					  <div class="progress-bar progress-bar-yellow  progress-bar-striped" style="width: <?php echo round($t_void, 2);?>%">
						<span class="sr-only"><?php echo round($t_void, 2);?>% Complete (success)</span>
					  </div>
					</div>
				</div><!-- /.progress-group -->

			</div>
		</div>

	
	<!-- /.TIPS STATS -->	

		</div>	


		
		<div class="col-md-6">
	<!-- TOP 5 RANKING -->

	<div class="box">
		<div class="box-body">
			<h4 class="head fs14"><?php echo lang('tips_top_5_ranking');?></h4>	

			<table class="table table-striped">
				<thead class="bg-black">
					<tr>
						<th class="pn w20">#</th>
						<th class="pn text-center"><?php echo lang('tips_tipster');?></th>
						<th class="pn text-center"><?php echo lang('tips_profit');?></th>
					</tr>
				</thead>					
				<?php $pos =1;?>
				
				<tbody>
					<tr>
						<?php if(isset($total_ranking) && is_array($total_ranking) && count($total_ranking)):
						
							foreach ($total_ranking as $record) : ?>						
							<td class="w20 mr10"><?php echo $pos++ ?></td>
							<td class="text-left">	
								<img src="<?php echo base_url();?>uploads/tipsters/<?php echo $record->avatar; ?>" class="h30 mr5"/>
								<img class="h30 mr10" src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($record->country);?>" alt="">	
								<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
									<?php echo $record->display_name; ?>					
								</a>
							</td>	

								<?php $user_stake = $this->tips_model->count_all_tipster_stake($record->id);
								$user_profit = $this->tips_model->count_all_tipster_profit($record->id);?>
									
							<?php if ($user_profit < 0 ):  ?>
								<td class="text-center"><span class="text-red"><?php echo round($user_profit, 2);?></span></td>												
								<?php else: ?>
								<td class="text-center"><span class="text-green">+<?php echo round($user_profit, 2); ?></span></td>
	
							<?php endif; ?>
					
					<tr>
					<?php endforeach; endif;?>
				</tbody>						
			</table>
		</div>	

		<!-- Box Footer -->
		<div class="box-footer bg-white">
			<a href="<?php echo base_url();?>tipsters" class="btn btn-clean btn-block"><?php echo lang('tips_view_full_ranking'); ?></a>
		</div>

    </div>
	
	<!-- /.TOP 5 RANKING -->














</div>	

		
	</div>	
	
	
	
	
	 
<script type="text/javascript"> 
	var site_url = "<?php echo site_url(); ?>";
</script>