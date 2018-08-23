	<div class="box">
		<div class="box-body">
			<h4 class="head text-left pl20 fs14 mb20"><?php echo lang('tips_tipsters_ranking'); ?></h4>	
			<div class="divider-4"></div>

			
			<ul class="nav nav-tabs mb10">
				<li class="active"><a href="#all-time" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_ranking_all_time'); ?></a></li>
				<li class=""><a href="#last-six" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_ranking_last_six'); ?></a></li>
				<li class=""><a href="#last-three" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_ranking_last_three'); ?></a></li>
				<li class=""><a href="#last-month" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_ranking_last_month'); ?></a></li>
			</ul>	

			<div class="tab-content">

				<div class="tab-pane fade in" id="last-month">

					<div class="table-responsive">
						<?php $pos =1;?>
						<table class="table table-striped">
						
							<thead class="bg-black">
								<tr>
									<th class="w20 pn">#</th>
									<th class="pn"><?php echo lang('tips_tipster'); ?></th>
									<th class="pn"><?php echo lang('tips_total'); ?></th>
									<th class="pn"><?php echo lang('tips_won'); ?></th>
									<th class="pn"><?php echo lang('tips_lost'); ?></th>
									<th class="pn"><?php echo lang('tips_voided'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_stake'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_odds'); ?></th>
									<th class="pn"><?php echo lang('tips_profit'); ?></th>
									<th class="pn"><?php echo lang('tips_yield'); ?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="11">
									<?php if (empty($last_month_ranking) || ! is_array($last_month_ranking)) : ?>
									<?php echo lang('us_no_users'); ?>
									<?php else :?>
									</td>
								</tr>
							</tfoot>	
							
							<tbody>
								<tr>
									<?php foreach ($last_month_ranking as $record) : ?>							
									<td class="w20"><?php echo $pos++ ?></td>
									<td class="text-left"><a href="#"><img class="h30 mr10" src="<?php echo base_url();?>uploads/tipsters/<?php echo $record->avatar;?>" alt="" class="img-responsive" /></a>
									<img class="h30 mr10" src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($record->country);?>" alt="">									
										<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
											<?php echo $record->display_name; ?>
										</a>
									</td>

									<td><?php echo $this->tips_model->count_tipster_tips_last_month($record->id);?></td>
									<td>
									
										<span class="text-green"><i class="fa fa-thumbs-up"></i>
											<?php echo $this->tips_model->count_tipster_won_last_month($record->id);?>
										</span>	
									</td>
									<td>
										<span class="text-red"><i class="fa fa-thumbs-down"></i>
											<?php echo $this->tips_model->count_tipster_lost_last_month($record->id);?>
										</span>	
									</td>
									<td>
										<span class="text-yellow"><i class="fa fa-hand-stop-o"></i>
											<?php echo $this->tips_model->count_tipster_void_last_month($record->id);?>
										</span>	
									</td>
									
									<?php $user_tips = $this->tips_model->count_tipster_tips_last_month($record->id);
										  $user_stake = $this->tips_model->count_tipster_stake_last_month($record->id);
										  $user_profit = $this->tips_model->count_tipster_profit_last_month($record->id);	
										  $user_odds = $this->tips_model->count_tipster_avg_odds_last_month($record->id);
										  
										  $avg_stake = $user_stake/$user_tips;
										  $avg_odds  = $user_odds/$user_tips;
										  
										 
									?>											  
									
									
									<td><?php echo round($avg_stake, 2);?></td>
									<td><?php echo round($avg_odds, 2);?></td>

										<?php if ($user_profit < 0 ):  ?>	
											<td><span class="text-red"><?php echo round($user_profit, 2);?></span></td>
											<?php else : ?>
											<td><span class="text-green">+<?php echo round($user_profit, 2); ?></span></td>
											
										<?php endif; ?>

										<?php  $yield1 = ($user_profit-$user_stake)/$user_stake;
											   $yield =  $yield1*100;
										  
										if ($yield < 0 ):  ?>
											<td class="text-center"><span class="text-red"><?php echo round($yield, 2);?> %</span></td>
												
											<?php else : ?>
											<td class="text-center"><span class="text-green">+<?php echo round($yield, 2); ?> %</span></td>
										<?php endif; ?>	

								<tr>
								<?php endforeach; ?>
								<?php endif; ?>							
							</tbody>
						</table>
					</div>				
				</div>	

				
				<div class="tab-pane fade in" id="last-three">

					<div class="table-responsive">
						<?php $pos =1;?>
						<table class="table table-striped">
							<thead class="bg-black">
								<tr>
									<th class="w20 pn">#</th>
									<th class="pn"><?php echo lang('tips_tipster'); ?></th>
									<th class="pn"><?php echo lang('tips_total'); ?></th>
									<th class="pn"><?php echo lang('tips_won'); ?></th>
									<th class="pn"><?php echo lang('tips_lost'); ?></th>
									<th class="pn"><?php echo lang('tips_voided'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_stake'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_odds'); ?></th>
									<th class="pn"><?php echo lang('tips_profit'); ?></th>
									<th class="pn"><?php echo lang('tips_yield'); ?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="11">
									<?php if (empty($last_three_months_ranking) || ! is_array($last_three_months_ranking)) : ?>
									<?php echo lang('us_no_users'); ?>
									<?php else :?>
									</td>
								</tr>
							</tfoot>	
							
							<tbody>
								<tr>
									<?php foreach ($last_three_months_ranking as $record) : ?>							
									<td class="w20"><?php echo $pos++ ?></td>
									<td class="text-left"><a href="#"><img class="h30 mr10" src="<?php echo base_url();?>uploads/tipsters/<?php echo $record->avatar;?>" alt="" class="img-responsive" /></a>
									<img class="h30 mr10" src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($record->country);?>" alt="">									
										<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
											<?php echo $record->display_name; ?>
										</a>
									</td>

									<td><?php echo $this->tips_model->count_tipster_tips_last_three_months($record->id);?></td>
									<td>
									
										<span class="text-green"><i class="fa fa-thumbs-up"></i>
											<?php echo $this->tips_model->count_tipster_won_last_three_months($record->id);?>
										</span>	
									</td>
									<td>
										<span class="text-red"><i class="fa fa-thumbs-down"></i>
											<?php echo $this->tips_model->count_tipster_lost_last_three_months($record->id);?>
										</span>	
									</td>
									<td>
										<span class="text-yellow"><i class="fa fa-hand-stop-o"></i>
											<?php echo $this->tips_model->count_tipster_void_last_three_months($record->id);?>
										</span>	
									</td>
									
									<?php $user_tips = $this->tips_model->count_tipster_tips_last_three_months($record->id);
										  $user_stake = $this->tips_model->count_tipster_stake_last_three_months($record->id);
										  $user_profit = $this->tips_model->count_tipster_profit_last_three_months($record->id);	
										  $user_odds = $this->tips_model->count_tipster_avg_odds_last_three_months($record->id);
										  
										  $avg_stake = $user_stake/$user_tips;
										  $avg_odds  = $user_odds/$user_tips;
									?>											  
									
									
									<td><?php echo round($avg_stake, 2);?></td>
									<td><?php echo round($avg_odds, 2);?></td>

										<?php if ($user_profit < 0 ):  ?>	
											<td><span class="text-red"><?php echo round($user_profit, 2);?></span></td>
											<?php else : ?>
											<td><span class="text-green">+<?php echo round($user_profit, 2); ?></span></td>
											
										<?php endif; ?>

										<?php  $yield1 = ($user_profit-$user_stake)/$user_stake;
											   $yield =  $yield1*100;
										  
										if ($yield < 0 ):  ?>
											<td class="text-center"><span class="text-red"><?php echo round($yield, 2);?> %</span></td>
												
											<?php else : ?>
											<td class="text-center"><span class="text-green">+<?php echo round($yield, 2); ?> %</span></td>
										<?php endif; ?>	

								<tr>
								<?php endforeach; ?>
								<?php endif; ?>							
							</tbody>
						</table>
					</div>				
				</div>					   
				
				<div class="tab-pane fade in" id="last-six">

					<div class="table-responsive">
						<?php $pos =1;?>
						<table class="table table-striped">
							<thead class="bg-black">
								<tr>
									<th class="w20 pn">#</th>
									<th class="pn"><?php echo lang('tips_tipster'); ?></th>
									<th class="pn"><?php echo lang('tips_total'); ?></th>
									<th class="pn"><?php echo lang('tips_won'); ?></th>
									<th class="pn"><?php echo lang('tips_lost'); ?></th>
									<th class="pn"><?php echo lang('tips_voided'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_stake'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_odds'); ?></th>
									<th class="pn"><?php echo lang('tips_profit'); ?></th>
									<th class="pn"><?php echo lang('tips_yield'); ?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="11">
									<?php if (empty($last_six_months_ranking) || ! is_array($last_six_months_ranking)) : ?>
									<?php echo lang('us_no_users'); ?>
									<?php else :?>
									</td>
								</tr>
							</tfoot>	
							
							<tbody>
								<tr>
									<?php foreach ($last_six_months_ranking as $record) : ?>							
									<td class="w20"><?php echo $pos++ ?></td>
									<td class="text-left"><a href="#"><img class="h30 mr10" src="<?php echo base_url();?>uploads/tipsters/<?php echo $record->avatar;?>" alt="" class="img-responsive" /></a>
									<img class="h30 mr10" src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($record->country);?>" alt="">									
										<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
											<?php echo $record->display_name; ?>
										</a>
									</td>

									<td><?php echo $this->tips_model->count_tipster_tips_last_six_months($record->id);?></td>
									<td>
									
										<span class="text-green"><i class="fa fa-thumbs-up"></i>
											<?php echo $this->tips_model->count_tipster_won_last_six_months($record->id);?>
										</span>	
									</td>
									<td>
										<span class="text-red"><i class="fa fa-thumbs-down"></i>
											<?php echo $this->tips_model->count_tipster_lost_last_six_months($record->id);?>
										</span>	
									</td>
									<td>
										<span class="text-yellow"><i class="fa fa-hand-stop-o"></i>
											<?php echo $this->tips_model->count_tipster_void_last_six_months($record->id);?>
										</span>	
									</td>
									
									<?php $user_tips = $this->tips_model->count_tipster_tips_last_six_months($record->id);
										  $user_stake = $this->tips_model->count_tipster_stake_last_six_months($record->id);
										  $user_profit = $this->tips_model->count_tipster_profit_last_six_months($record->id);	
										  $user_odds = $this->tips_model->count_tipster_avg_odds_last_six_months($record->id);
										  
										  $avg_stake = $user_stake/$user_tips;
										  $avg_odds  = $user_odds/$user_tips;
									?>											  
									
									
									<td><?php echo round($avg_stake, 2);?></td>
									<td><?php echo round($avg_odds, 2);?></td>

										<?php if ($user_profit < 0 ):  ?>	
											<td><span class="text-red"><?php echo round($user_profit, 2);?></span></td>
											<?php else : ?>
											<td><span class="text-green">+<?php echo round($user_profit, 2); ?></span></td>
											
										<?php endif; ?>

										<?php  $yield1 = ($user_profit-$user_stake)/$user_stake;
											   $yield =  $yield1*100;
										  
										if ($yield < 0 ):  ?>
											<td class="text-center"><span class="text-red"><?php echo round($yield, 2);?> %</span></td>
												
											<?php else : ?>
											<td class="text-center"><span class="text-green">+<?php echo round($yield, 2); ?> %</span></td>
										<?php endif; ?>	

								<tr>
								<?php endforeach; ?>
								<?php endif; ?>							
							</tbody>
						</table>
					</div>				
				</div>	
			
				
				<div class="tab-pane fade active in" id="all-time">

					<div class="table-responsive">
						<?php $pos =1;?>
						<table class="table table-striped">
							<thead class="bg-black">
								<tr>
									<th class="w20 pn">#</th>
									<th class="pn"><?php echo lang('tips_tipster'); ?></th>
									<th class="pn"><?php echo lang('tips_total'); ?></th>
									<th class="pn"><?php echo lang('tips_won'); ?></th>
									<th class="pn"><?php echo lang('tips_lost'); ?></th>
									<th class="pn"><?php echo lang('tips_voided'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_stake'); ?></th>
									<th class="pn"><?php echo lang('tips_avg_odds'); ?></th>
									<th class="pn"><?php echo lang('tips_profit'); ?></th>
									<th class="pn"><?php echo lang('tips_yield'); ?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="11">
									<?php if (empty($all_time_ranking) || ! is_array($all_time_ranking)) : ?>
									<?php echo lang('us_no_users'); ?>
									<?php else :?>
									</td>
								</tr>
							</tfoot>	
							
							<tbody>
								<tr>
									<?php foreach ($all_time_ranking as $record) : ?>							
									<td class="w20"><?php echo $pos++ ?></td>
									<td class="text-left"><a href="#"><img class="h30 mr10" src="<?php echo base_url();?>uploads/tipsters/<?php echo $record->avatar;?>" alt="" class="img-responsive" /></a>
									<img class="h30 mr10" src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($record->country);?>" alt="">									
										<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
											<?php echo $record->display_name; ?>
										</a>
									</td>

									<td><?php echo $this->tips_model->count_all_tipster_tips($record->id);?></td>
									<td>
									
										<span class="text-green"><i class="fa fa-thumbs-up"></i>	
											<?php echo $this->tips_model->count_all_tipster_won($record->id);?>
										</span>
									</td>
									<td>
										<span class="text-red"><i class="fa fa-thumbs-down"></i>
											<?php echo $this->tips_model->count_all_tipster_lost($record->id);?>
										</span>	
									</td>
									<td>
										<span class="text-yellow"><i class="fa fa-hand-stop-o"></i>
											<?php echo $this->tips_model->count_all_tipster_void($record->id);?>
										</span>	
									</td>
									
									<?php $user_tips = $this->tips_model->count_all_tipster_tips($record->id);
										  $user_stake = $this->tips_model->count_all_tipster_stake($record->id);
										  $user_profit = $this->tips_model->count_all_tipster_profit($record->id);	
										  $user_odds = $this->tips_model->count_all_tipster_avg_odds($record->id);
										  
										  $avg_stake = $user_stake/$user_tips;
										  $avg_odds  = $user_odds/$user_tips;
									?>											  
									
									
									<td><?php echo round($avg_stake, 2);?></td>
									<td><?php echo round($avg_odds, 2);?></td>

										<?php if ($user_profit < 0 ):  ?>	
											<td><span class="text-red"><?php echo round($user_profit, 2);?></span></td>
											<?php else : ?>
											<td><span class="text-green">+<?php echo round($user_profit, 2); ?></span></td>
											
										<?php endif; ?>

										<?php  $yield1 = ($user_profit-$user_stake)/$user_stake;
											   $yield =  $yield1*100;
										  
										if ($yield < 0 ):  ?>
											<td class="text-center"><span class="text-red"><?php echo round($yield, 2);?> %</span></td>
												
											<?php else : ?>
											<td class="text-center"><span class="text-green">+<?php echo round($yield, 2); ?> %</span></td>
										<?php endif; ?>	

								<tr>
								<?php endforeach; ?>
								<?php endif; ?>							
							</tbody>
						</table>							
					</div>
				</div>	
				
			</div>
			<div class="divider-4"></div>
			
			<?php echo form_open($this->uri->uri_string(), 'id="form" class="form-horizontal"'); ?>	
			
				<div class="row">
					<div class="col-md-4 col-sm-2">
						<div class="form-group">
							<h4 class="fs14"><?php echo lang('tips_search_ranking_by_date'); ?></h4>
						</div><!-- form group-->
					</div>			
					<div class="col-md-2 col-sm-2">
						<div class="form-group">
							<input type="text" class="form-control" id="from" placeholder="<?php echo lang('tips_start_date'); ?>" name="from">
						</div><!-- form group-->
					</div>	
					<div class="col-md-2 col-sm-2">
						<div class="form-group">
							
							<input type="text" class="form-control" id="to" placeholder="<?php echo lang('tips_end_date'); ?>" name="to">   
						</div> <!-- form group--> 
					</div>	

					<div class="col-md-2 col-sm-2">	
						<button class="btn btn-blue btn-block mb10" type="submit" id='rankings-search'>
							<i class="glyphicon glyphicon-search"></i> <?php echo lang('tips_search'); ?>
						</button>
					</div> <!-- form group --> 
					<div class="col-md-2 col-sm-2">		
						<button class="btn btn-red btn-block mb10" type="submit" id='date-clear'><?php echo lang('tips_clear'); ?></button>
					</div> <!-- form group --> 	

				</div>	
				<!-- End row  -->	
			
			<?php echo form_close(); ?>
			
			<div class="divider-4 mt5"></div>
		
			<div id="search-rankings">
				<div class="table-responsive">	
					<table class='table table-striped'>	

						<tbody id="result">
						
						</tbody>
					</table>
				</div>			
			</div>
		
		</div>		

	</div>	

<?php echo $this->bookmakers_model->get_bookmaker_banner_full();?>
	
<script type="text/javascript">
	// Define site_url variable for use in the js file
	var site_url = "<?php echo site_url(); ?>";  
</script>			