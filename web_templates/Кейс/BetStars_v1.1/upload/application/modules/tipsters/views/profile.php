	<div class="box no-shadow mb20">
		<div class="box-body">
		

				<ul class="nav nav-tabs">
				  <li class="active"><a href="#stats" data-toggle="tab"><?php echo lang('tips_tab_stats');?></a></li>
				  <li><a href="#tips" data-toggle="tab"><?php echo lang('tips_tab_tips');?></a></li>
				  <?php if(isset($current_user) && $current_user->id == $user->id) :?>
				  <li><a href="#activities" data-toggle="tab"><?php echo lang('tips_frends_activities');?></a></li>
				  <?php endif;?>
				</ul>

				<div class="tab-content pn mt20">
					<div class="active tab-pane" id="stats">

						<div class="row">
							<div class="col-sm-4">
							  <div class="description-block">					
								<span class="description-text-big mb10"><?php echo lang('tips_total_stake');?></span>
								<h5 class="description-header fs18 text-blue">
									<?php $t_stake = $this->tips_model->count_all_tipster_stake($user->id);?>
									<h5 class="description-header fs18 text-blue"><?php echo $t_stake;?></h5>
									<?php if (!$t_stake):  ?>
									<h5 class="description-header fs18 text-blue">0</h5>
									<?php endif;?> 									
								</h5>
							  </div><!-- /.description-block -->
							</div><!-- /.col -->
							
							<div class="col-sm-4">
								<div class="description-block">
									<span class="description-text-big mb10"><?php echo lang('tips_total_profit');?></span>
									<?php $t_profit = $this->tips_model->count_all_tipster_profit($user->id);
										  
									if ($t_profit <= 0 ):  ?>
										<h5 class="description-header fs18 text-red"><?php echo round($t_profit, 2);?></h5>							
									<?php else : ?>
										<h5 class="description-header fs18 text-green">+<?php echo round($t_profit, 2);?></h5>
									<?php endif; ?>
								</div><!-- /.description-block -->
							</div><!-- /.col -->
							<div class="col-sm-4">
								<div class="description-block">
									<span class="description-text-big mb10"><?php echo lang('tips_total_yield');?></span>
									<?php  if($t_stake > 0) {
													
											$yield1 = ($t_profit-$t_stake)/$t_stake;
											$yield =  $yield1*100;
															  
											if ($yield < 0 ):  ?>
											<h5 class="description-header fs18 text-red"><?php echo round($yield, 2);?> %</h5>
																	
											<?php else : ?>
											<h5 class="description-header fs18 text-green">+<?php echo round($yield, 2);?> %</h5>
											<?php endif; 	
										} else	{ ?><h5 class="description-header fs18 text-blue">0</h5>
												
									<?php }; ?>
								</div><!-- /.description-block -->
							</div><!-- /.col -->
							
						</div><!-- /.row -->
						
						<div class="divider-4 mtn mbn"></div>						
					
						<?php $total_tips = $this->tips_model->count_all_tipster_tips($user->id);
							  $total_won  = $this->tips_model->count_all_tipster_won($user->id);
							  if($total_tips > 0) { $win_rate = ($total_won/$total_tips)*100;
							  } else { $win_rate = 0;
							  } ;?>
						<div class="row">
							<div class="stats1 widget-user">
								<div class="col-sm-4">
								  <div class="description-block mt20">
									<h5 class="description-header mb20"><?php echo lang('tips_win_rate');?></h5>
									<input type="text" class="knob" value="<?php echo round($win_rate,0);?>" data-angleArc="250" data-angleoffset="-125" data-thickness="0.2" data-width="120" data-height="120" data-fgColor="#51d466" data-readonly="true">
									<span class="percent text-green"> % </span>
								  </div><!-- /.description-block -->
								</div><!-- /.col -->
								<div class="col-sm-4">
									<div class="description-block mtn">
										<ul class="nav nav-stacked">
											<li>
												<a class="text-left"><?php echo lang('tips_total');?>
													<span class="pull-right text-blue">
														<?php echo $this->tips_model->count_all_tipster_tips($user->id);?>
													</span>
												</a>
											</li>
											<li>
												<a class="text-left"><?php echo lang('tips_total_won');?></span>
													<span class="pull-right text-green">
														<?php echo $this->tips_model->count_all_tipster_won($user->id);?>
													</span>
												</a>
											</li>
											<li>
												<a class="text-left"><?php echo lang('tips_total_lost');?></span>
													<span class="pull-right text-red">
														<?php echo $this->tips_model->count_all_tipster_lost($user->id);?>
													</span>
												</a>
											</li>	
											<li>
												<a class="text-left"><?php echo lang('tips_total_void');?></span>
													<span class="pull-right">
														<?php echo $this->tips_model->count_all_tipster_void($user->id);?>
													</span>
												</a>
											</li>												
										</ul>
									</div>	
								</div><!-- /.col -->
								<div class="col-sm-4">
									<div class="description-block mtn">
										<ul class="nav nav-stacked">
											<li><a class="text-left">Avg Stake
											<?php $t_tips = $this->tips_model->count_all_tipster_tips($user->id);
											if($total_tips > 0) {
											$avg_stake = $t_stake/$t_tips?>
											
												<span class="pull-right text-blue"><?php echo round($avg_stake,2);?></span>
												<?php } else {?>
												<span class="pull-right text-blue">0</span>
												<?php } ?>
											</a>
											</li>			
											<li><a class="text-left">Avg Odds								
											<?php $t_odds = $this->tips_model->count_all_tipster_avg_odds($user->id);
											if($total_tips > 0) {
											$avg_odds = $t_odds/$t_tips?>
											
											<span class="pull-right text-blue"><?php echo round($avg_odds,2);?></span>
											<?php } else {?>
												<span class="pull-right text-blue">0</span>
												<?php } ?>
											</a>
											</li>
											<li><a class="text-center text-blue fs16">Last 5 Streak</a></li>
											
											<li>
												<span class="text-center">
													<?php $streaks = $this->tips_model->limit(5)->get_archived_tipster_tips($user->id);
													if(isset($streaks) && is_array($streaks) && count($streaks)):
													
													foreach ($streaks as $streak):
													if ($streak->status == 3) { ?>
													
													<a href="<?php echo base_url();?>tips/preview/<?php echo $streak->id;?>">
													<span class="label label-green">W</span>
													</a>
													
													<?php } elseif($streak->status == 4) {?>
													
													<a href="<?php echo base_url();?>tips/preview/<?php echo $streak->id;?>">
													<span class="label label-red">L</span>
													</a>	
																									
													<?php } endforeach;  endif;?>	
													
												</span>
											</li>							
										</ul>
									</div>	
								</div><!-- /.col -->
							</div>
						</div><!-- /.row -->

						<div class="divider-4 mtn"></div>
						<div class="row">
							<div class="col-sm-3">
							  <div class="description-block">					
								<span class="description-text-big">Competitions Won</span>
								<h5 class="description-header fs22 text-blue"><span>x</span>
								<?php echo $this->competitions_model->get_tipster_competitions_won($user->id);?></h5>
							  </div><!-- /.description-block -->
							</div><!-- /.col -->
							
							<div class="col-sm-3">
							  <div class="description-block">
								<span class="description-text-big">Tipster of the Month</span>
								<h5 class="description-header fs22 text-blue"><span>x</span>
								<?php echo $this->competitions_model->get_tipster_of_the_month_won($user->id);?></h5>
							  </div><!-- /.description-block -->
							</div><!-- /.col -->
							<div class="col-sm-3">
							  <div class="description-block">
								<span class="description-text-big">Tipster of the Year</span>
								<h5 class="description-header fs22 text-blue"><span>x</span>
								<?php echo $this->competitions_model->get_tipster_of_the_year_won($user->id);?></h5>
							  </div><!-- /.description-block -->
							</div><!-- /.col -->
							
							<div class="col-sm-3">
							  <div class="description-block">
								<span class="description-text-big">Other Competitions</span>
								<h5 class="description-header fs22 text-blue"><span>x</span>
								<?php echo $this->competitions_model->get_tipster_other_won($user->id);?></h5>
							  </div><!-- /.description-block -->
							</div><!-- /.col -->
							
						</div><!-- /.row -->
						
						<div class="divider-4 mtn"></div>
						<div class="row">
							
							<div class="col-sm-6">										
								<?php $total_tips = $this->tips_model->count_all_tipster_tips($user->id);?>
								
								<h4 class="fw100 fs14 text-center text-uppercase"><?php echo lang('tips_fav_sports');?></h4>
								
								<ul class="nav nav-stacked">

									<?php if(isset($fav_sports) && is_array($fav_sports) && count($fav_sports) && ($total_tips > 0)):
									
									foreach ($fav_sports as $record) : ?>			
									<li><a href="<?php echo base_url();?>tips/index/sport_id-<?php echo $record->sport_id;?>">
										<img src="<?php echo base_url();?>uploads/sports/<?php echo $this->sports_model->get_sport_icon_by_id($record->sport_id); ?> " class="h30 mr10"/>
										<?php echo $this->sports_model->get_sport_name_by_id($record->sport_id) ?>
										
										<span class="pull-right text-blue">
										  <?php $count = 0;
												foreach ($fav_sports as $r)
												{
													if ($record->sport_id == $r->sport_id)
													{
													  $count = $r->count;
													}
												}
												
												$str = ($count/$total_tips)*100;
											  echo round($str, 2); ?> %
										</span></a>
									</li>
									<?php endforeach; endif;?>	
								</ul>													
							</div><!-- /.col -->
							
							<div class="col-sm-6">
								<h4 class="fw100 fs14 text-center text-uppercase"><?php echo lang('tips_fav_leagues');?></h4>
								<ul class="nav nav-stacked">

									<?php if(isset($fav_leagues) && is_array($fav_leagues) && count($fav_leagues) && ($total_tips > 0)):
									
									foreach ($fav_leagues as $record) : ?>			
									<li><a href="<?php echo base_url();?>tips/index/league_id-<?php echo $record->league_id;?>">
									   <?php $country = $this->leagues_model->get_league_country_by_id($record->league_id);?>
										<img src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($country); ?> " class="h30 mr10 mtm4"/>
										<?php echo $this->leagues_model->get_league_name_by_id($record->league_id) ?>
										
										<span class="pull-right text-blue">
										  <?php $count = 0;
												foreach ($fav_leagues as $r)
												{
													if ($record->league_id == $r->league_id)
													{
													  $count = $r->count;
													}
												}
												
												$str = ($count/$total_tips)*100;
											  echo round($str, 2); ?> %
										</span></a>
									</li>
									<?php endforeach; endif;?>	
								</ul>
							</div><!-- /.col -->

						</div><!-- /.row -->		

					</div>	<!-- /.tab-pane stats-->	
			
					<div class="tab-pane" id="tips">

						
							<ul class="nav nav-tabs grey">
							  <li class="active"><a href="#active_tips" data-toggle="tab"><?php echo lang('tips_active_tips');?></a></li>
							  <li><a href="#archived_tips" data-toggle="tab"><?php echo lang('tips_archived_tips');?></a></li>
							</ul>
							<div class="tab-content">
							
								<div class="active tab-pane" id="active_tips">	
						
									

									<div class="divider-4 mbn"></div>
										<h3><?php echo lang('tips_active_tipster_tips');?></h3>
									<div class="divider-4 mtn"></div>	

									<table class='table table-striped'>	
										<tbody>
										
											<?php if ($active_tips) : foreach ($active_tips as $record) : ?>

											<tr>
											
												<td class="text-left">
													<img class="h24 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
													<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
													
													<img class="h24 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
													<span class="fs12 mr10"><?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?>
													</span>
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
												<div class="fr">
													<td class="w150 hidden-xs">	
															<?php echo relative_time(strtotime($record->created_on)); ?>
													</td>
												</div>
									
												
											</tr>		

									
											<?php endforeach;
												
												else: ?>
													<?php echo lang('tips_records_empty'); ?>
													
											<?php endif; ?>

										</tbody>
									</table>
								
								</div><!-- ./Active tips -->
								
								<div class="tab-pane" id="archived_tips">	

									<div class="divider-4 mbn"></div>
										<h3><?php echo lang('tips_archived_tipster_tips');?></h3>
									<div class="divider-4 mtn"></div>	
											
								<?php echo form_open('', 'id="form" class="form-horizontal"'); ?>	
								
									<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id;?>"> 
									<div class="row">
										<div class="col-sm-2">
											<div class="form-group">
												
												<input type="text" class="form-control" id="from" placeholder="<?php echo lang('tips_start_date'); ?>" name="from">
											</div><!-- form group-->
										</div>	
										<div class="col-sm-2">
											<div class="form-group">
												
												<input type="text" class="form-control" id="to" placeholder="<?php echo lang('tips_end_date'); ?>" name="to">   
											</div> <!-- form group--> 
										</div>	
										<div class="col-sm-2">		
											<div class="form-group">
												<select name="sport_id" id="sport_id" class="form-control">
														<option value=""><?php echo lang('tips_sport_id');?></option>
														<?php foreach ($sports->result() as $row) {?>
															<option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
														<?php }?>
												</select>
											</div>
										</div>	
										<div class="col-sm-2">	
											<div class="form-group">				
												<select class="form-control" id="status" name="status"> 
												<option value=""><?php echo lang('tips_status');?></option>
												<option value="3"><?php echo lang('tips_won'); ?></option>
												<option value="4"><?php echo lang('tips_lost'); ?></option>
												<option value="5"><?php echo lang('tips_voided'); ?></option>									
												</select>								
											</div> <!-- form group--> 
										</div>	
										<div class="col-sm-2">	
											<button class="btn btn-blue btn-block mb10" type="submit" id='date-search'>
												<i class="glyphicon glyphicon-search"></i> <?php echo lang('tips_search'); ?>
											</button>
										</div> <!-- form group --> 
										<div class="col-sm-2">		
											<button class="btn btn-red btn-block mb10"  id='date-clear'><?php echo lang('tips_clear'); ?></button>
										</div> <!-- form group --> 	

									</div>	
									<!-- End row  -->				
									<?php echo form_close(); ?>
									
									
									
									<div id="archived-tips">
									
										<table class='table table-striped'>	
											<tbody>
											
												<?php if ($archived_tips) : foreach ($archived_tips as $record) : ?>

												<tr>
												
													<td class="text-left">
														<img class="h30 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
														<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
														
														<img class="h30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
														<span class="fs12 mr10"><?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?>
														</span>
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

													<div class="fr">
														<td>
															<?php if($record->status == 3) { ?>
																
																<span class="text-green"><i class="fa fa-thumbs-up"></i>	
																	<?php echo $record->winnings;?>
																</span>
																
																<?php } elseif($record->status == 4) {?>
																
																<span class="text-red"><i class="fa fa-thumbs-down"></i>	
																	<?php echo $record->winnings;?>
																</span>
																
																<?php } elseif($record->status == 5) {?>
																
																<span class="text-yellow"><i class="fa fa-hand-stop-on"></i>	
																	<?php echo $record->winnings;?>
																</span>													
																<?php } else {?>
																
																<span class="text-blue">	
																	/
																</span>
																<?php } ?>
																
														</td>		
														<td class="w150 hidden-xs">	
															<?php echo relative_time(strtotime($record->created_on)); ?>

														</td>
													</div>
													
												
												</tr>


												<?php endforeach;
													else: ?>
													<?php echo lang('tips_records_empty'); ?>
													
												<?php endif; ?>
											</tbody>
										</table>
									</div>

								
								
									<div id="search-tips">
										<table class='table table-striped'>	
											<tbody id="result">
											
											</tbody>
										</table>								
									</div>

								</div><!-- ./Archived tips -->
							</div>	

					</div>	
						
					<div class="tab-pane" id="activities">

						<div class="box-body pn">
						
							<div class="table-responsive">
								<table class="table table-striped" role="grid">
									<thead class="bg-black">
										<tr>
											<th class="pn pl20"><?php echo lang('tips_tipster'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="text-left pn"><?php echo lang('tips_match'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="pn"><?php echo lang('tips_posted_on'); ?></th>
										</tr>
									</thead>		
									<tbody>						
										<?php $followings = $this->tipsters_model->get_followings($user->id);
									
										if ($followings) {
											foreach ($followings as $r) :
										
										$tips =  $this->tips_model->limit(10)->get_frends_activities($r->following_id);
										
										if ($tips) : foreach ($tips as $record) :
										
										$tipster = $this->tipsters_model->get_user_display_name_by_id($record->created_by);
										$avatar  = $this->tipsters_model->get_user_avatar_by_id($record->created_by); ?>
							  
										<tr>			
											<td class="w30 text-left">
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/tipsters/<?php echo $avatar;?>" alt="user image">
											</td>
											<td class="text-left">
												<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->created_by;?>" class="name"><?php echo $tipster; ?></a>
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
												<a href="<?php echo base_url(); ?>tips/preview/<?php echo $record->id; ?>">
													<span class="text-blue mh5">info</span>
												</a>	
											</td>
											<td class="w30 pn text-left">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->away_team,$record->league_id)); ?>"/>
											</td>	
											<td class="text-left pn">
												<?php e($rec->away_team); ?>	
											</td>	
			
											<?php endforeach;?>
											
											<td><?php echo relative_time(strtotime($record->created_on)); ?></td>								
										</tr>	

										<?php endforeach; endif;?>

								
										 <?php endforeach; 
										} else {;?> 
										
										<tr>
											<td class="text-red"><?php echo lang('tips_no_friends'); ?></td>
										</tr>
									
										<?php } ;?>
									</tbody>
							</table>						
						</div>
					</div><!-- ./tab-pane -->
				</div>	
			
		</div>		
	</div>
	
<script type="text/javascript">
	// Define site_url variable for use in the js file
	var site_url = "<?php echo site_url(); ?>";  
</script>	
