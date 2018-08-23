	
	
	
			<?php $league_id = $this->uri->segment(3); 
			
			$league = $this->leagues_model->get_league_name_by_id($league_id); 
			$sport = $this->leagues_model->get_league_sport_id_by_id($league_id);

			
			$total_tips = $this->tips_model->count_league_tips($league_id);
			$total_active = $this->tips_model->where('status',2)->count_league_tips($league_id);
			$total_ended = $this->tips_model->where('status !=', 1 || 2)->count_league_tips($league_id);
			$total_won  = $this->tips_model->where('status',3)->count_league_tips($league_id);
			$total_lost = $this->tips_model->where('status',4)->count_league_tips($league_id);
			$total_void = $this->tips_model->where('status',5)->count_league_tips($league_id);
			
			$total_profit = $this->tips_model->count_league_profit($league_id);
			
			
			$league_stats = $this->tips_model->get_league_top_tipsters($league_id);?>


	<div class="box">
		<div class="box-body pbn">

			<h4 class="head pl10 fs14 text-left">
			<a href="<?php echo base_url();?>tips/index/sport_id-<?php echo $sport;?>">
				<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport)); ?>"/>
			</a>
			<?php $country_id = $this->leagues_model->get_league_country_by_id($league_id); ?>
				<img class="h24 mtm4 mr20" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

			<?php echo lang('tips_statsistics'); ?> 
			</h4>	

			<ul class="list-group list-group-unbordered">
	
				<li class="list-group-item">
				   <?php echo lang('tips_total'); ?> <span class="text-blue pull-right mr10">( <?php echo $total_tips; ?> )</span>
			    </li>			
				<li class="list-group-item">
				   <?php echo lang('tips_active'); ?> <span class="text-blue pull-right mr10">( <?php echo $total_active; ?> )</span>
			   </li>
				<li class="list-group-item">
				   <?php echo lang('tips_tips_won'); ?> <span class="text-green pull-right mr10">( <?php echo $total_won; ?> )</span>
			   </li>					
				<li class="list-group-item">
				   <?php echo lang('tips_tips_lost'); ?><span class="text-red pull-right mr10">( <?php echo $total_lost; ?> )</span>
			   </li>
				<li class="list-group-item">
				   <?php echo lang('tips_tips_voided'); ?><span class="text-black pull-right mr10">( <?php echo $total_void; ?> )</span>
			   </li>
				<li class="list-group-item">
					<?php echo lang('tips_total_profit'); ?>
					<?php if ($total_profit < 0 ):  ?>	
					<span class="text-red pull-right mr10"><?php echo round($total_profit, 2);?></span>
					<?php else : ?>
					<span class="text-green pull-right mr10">+<?php echo round($total_profit, 2); ?></span>
					
					<?php endif; ?>				

			   </li>
				<li class="list-group-item">
				    <?php echo lang('tips_win_rate'); ?>

						<?php if($total_ended > 0) { $win_rate = ($total_won/$total_ended)*100;
							  } else { $win_rate = 0;
						} ;?>
					<span class="text-green pull-right mr10"><?php echo round($win_rate,0);?> %</span>		  
				</li>				
			</ul>
		</div>
		
		<!-- Box Footer -->
		<div class="box-footer clearfix"></div>
	</div>	

			<?php $top_tipsters = $this->tips_model->get_league_top_tipsters($league_id);?>


	<div class="box">
		<div class="box-body">

			<h4 class="head pl10 fs14 text-left">
			<a href="<?php echo base_url();?>tips/index/sport_id-<?php echo $sport;?>">
				<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport)); ?>"/>
			</a>
			<?php $country_id = $this->leagues_model->get_league_country_by_id($league_id); ?>
			<img class="h24 mtm4 mr20" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

			<?php echo lang('tips_top_tipsters'); ?> 
			</h4>	
			
			<?php $pos =1;?>
			<table class='table table-striped'>	
				<thead>
					<tr>
						<th class="w20 pv15">#</th>
						<th class="pv15"><?php echo lang('tips_tipster'); ?></th>
						<th class="pv15"><?php echo lang('tips_tips'); ?></th>
						<th class="pv15"><?php echo lang('tips_profit'); ?></th>

					</tr>
				</thead>	
				<tbody>	
				
					<?php if(isset($top_tipsters) && is_array($top_tipsters) && count($top_tipsters)):
							
						foreach ($top_tipsters as $record) :?>		
					<tr>
						<td class="w20"><?php echo $pos++ ?></td>
						<td class="text-left">
						
							<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
								<?php echo $record->display_name; ?>
							</a>
						</td>				
					
						<td><?php echo $record->tips ?></td>
						
						<?php $user_profit = $record->winnings; 
							if ($user_profit < 0 ):  ?>	
							<td><span class="text-red"><?php echo round($user_profit, 2);?></span></td>
							<?php else : ?>
							<td><span class="text-green">+<?php echo round($user_profit, 2); ?></span></td>
							
						<?php endif; ?>
					
					</tr>
					<?php endforeach; endif;?>
				</tbody>
			</table>
		</div>
		
		<!-- Box Footer -->
		<div class="box-footer clearfix"></div>
	</div>		