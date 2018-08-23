

	<?php  // The Id of the competition
		$id = $this->uri->segment(3);
		$title = $this->competitions_model->get_competition_name_by_id($id);
		$min_tips = $this->competitions_model->get_competition_min_tips($id);?>
		
		
	<div class="box">

		<div class="box-body">

			<h4 class="head fs14 pl20 mb10 text-left">
				<span class=""><?php echo $title; ?><?php echo lang('competitions_ranking'); ?></span>
			</h4>	


			<?php 
			

			
			$sport = $this->competitions_model->get_competition_sport($id);
			$league   = $this->competitions_model->get_competition_league($id);	
			
			// Start/End date of competition	
			$start = $this->competitions_model->get_competition_start_date($id);
			$end   = $this->competitions_model->get_competition_end_date($id);
			
			// Fetch ranking by competition start/end date
			$rankings = $this->competitions_model->competition_rankings($start,$end);	
			
			
			if(!$sport == 0)
			{	
				// IF competition is for specific sport 
				$rankings = $this->competitions_model->where('tips.sport_id',$sport)->competition_rankings($start,$end);
			}

			if(!$league == 0)
			{
				// IF competition is for specific league 
				$rankings = $this->competitions_model->where('tips.league_id',$league)->competition_rankings($start,$end);
			}


			if (isset($rankings) && is_array($rankings) && count($rankings)) : ?>
			
			

					<span class="text-blue fs16"><?php echo lang('competitions_note'); ?>
						<span class="fs14 text-red"><?php echo lang('competitions_min_of'); ?> <?php echo $min_tips;?> <?php echo lang('competitions_qualify'); ?>
						</span>
					</span>

		
				<div class="table-responsive mt10">
					<?php $pos =1;?>
					<?php $place =1;?>
					<?php $place2 =1;?>
					<table class="table table-striped">
						<thead class="bg-black">
							<tr>
								<th class="w20 pn">#</th>
								<th class="pn"><?php echo lang('tips_tipster'); ?></th>
								<th class="pn"><?php echo lang('tips_total'); ?></th>
								<th class="pn"><?php echo lang('tips_won'); ?></th>
								<th class="pn"><?php echo lang('tips_lost'); ?></th>
								<th class="pn"><?php echo lang('tips_voided'); ?></th>
								<th class="pn"><?php echo lang('tips_profit'); ?></th>
								<th class="pn"><?php echo lang('tips_yield'); ?></th>
								<th class="pn"><?php echo lang('competitions_field_reward'); ?></th>

							</tr>
						</thead>
						
						<tbody>

							<?php foreach ($rankings as $record) : 	?>
							
							<tr>
		
								<?php $t_tips = $this->competitions_model->count_tipster_tips_by_period($record->id,$start,$end);?>

								<?php if($t_tips >= $min_tips):?>
								<td class="w20"><?php $a = $place++; echo $a;?></td>
								<?php else : ?>
								<td class="w20"><?php $a = 0;?> - </td>
								<?php endif; ?>

								
								<td class="text-left"><a href="#"><img class="w30 mr20" src="<?php echo base_url();?>uploads/tipsters/<?php echo $record->avatar;?>" alt="" class="img-responsive" /></a>
								
									<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
										<?php echo $record->display_name; ?>
									</a>
								</td>

								<td><?php 
								echo $t_tips;?></td>
								<td>
								
									<span class="text-green"><i class="fa fa-thumbs-up"></i>
										<?php echo $this->competitions_model->count_tipster_won_by_period($record->id,$start,$end);?>
									</span>	
								</td>
								<td>
									<span class="text-red"><i class="fa fa-thumbs-down"></i>
										<?php echo $this->competitions_model->count_tipster_lost_by_period($record->id,$start,$end);?>
									</span>	
								</td>
								<td>
									<span class="text-yellow"><i class="fa fa-hand-stop-o"></i>
										<?php echo $this->competitions_model->count_tipster_void_by_period($record->id,$start,$end);?>
									</span>	
								</td>
								
								<?php 
									  $user_stake = $this->competitions_model->count_tipster_stake_by_period($record->id,$start,$end);
									  $user_profit = $this->competitions_model->count_tipster_profit_by_period($record->id,$start,$end);	

								?>											  
								

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
									
									<?php $prise = $this->competitions_model->get_rewards($id,$a);?>
									
									<?php if ($t_tips >= $min_tips):  ?>
									<td>
										<span class="label label-blue">
										
											<?php if ($prise):
  											echo $prise;?> 
											<span class="ml5"><?php echo $this->competitions_model->get_currency($id);?></span>
											
											<?php else:?> / <?php endif; ?>	
											
										</span>
									</td>	
									<?php else : ?>	
										<td><?php echo lang('competitions_to_little_tips'); ?></td>
									<?php endif; ?>	

							<?php endforeach; ?>	

							<tr>
						</tbody>
					</table>

				</div>					
		
			<?php endif ;?>	

		</div>
	</div>
