
	<div class="box">
		<div class="box-body pbn">
			<?php $total_active = $this->tips_model->count_all_active_tips();?>
			<h4 class="head fs14 mb10"><?php echo lang('tips_popular_leagues');?>
				<span class="pull-right mr10">(<?php echo $total_active;?>)</span>
			</h4>	

			<ul class="list-group list-group-unbordered">
				<?php if(isset($sport_counts) && is_array($sport_counts) && count($sport_counts)):
						
					foreach ($sport_counts as $record) :?>		
			
				<li class="list-group-item bg-grey">

				   <a class="ml10" href="<?php echo base_url();?>tips/index/sport_id-<?php echo $record->sport_id;?>">
						<img class="h30 mtm2" src="<?php echo base_url();?>uploads/sports/<?php echo $this->sports_model->get_sport_icon_by_id($record->sport_id); ?>"/> 
					   <span class="text-black">
						<?php echo strtoupper($this->sports_model->get_sport_name_by_id($record->sport_id)); ?>
					   </span>
				   </a>
				   
			   		<span class="pull-right mr10">(
						 <?php $count = 0;
							foreach ($sport_counts as $r)
							{
								if ($record->sport_id == $r->sport_id)
								{
									 $count = $r->count;
								}
							}
						 echo $count; ?>
					)</span>

			   </li>
			   <?php $league_counts = $this->tips_model->count_by_league($record->sport_id);
			   
					if(isset($league_counts) && is_array($league_counts) && count($league_counts)):
										
					foreach ($league_counts as $rec) :?>
					
				<li class="list-group-item ml30 fs12">
				
					<?php $country_id = $this->leagues_model->get_league_country_by_id($rec->league_id); ?>
						<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
					<a class="ml10" href="<?php echo base_url();?>tips/by_league/<?php echo $rec->league_id;?>"><?php echo $this->leagues_model->get_league_name_by_id($rec->league_id) ?></a>

					<span class="pull-right text-blue mr10">(
				      <?php $count = 0;
						foreach ($league_counts as $r)
						{
							if ($rec->league_id == $r->league_id)
							{
								$count = $r->count;
							}
						}
						echo $count; ?>
					)</span>
					
				</li>
				<?php endforeach; 
					endif;
					endforeach; 
				endif;?>
			</ul>
		</div>
		
		<!-- Box Footer -->
		<div class="box-footer clearfix"></div>
	</div>	