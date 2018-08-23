	<div class="box">
		<div class="box-body">
			<h4 class="head fs14"><?php echo lang('competitions_competition_details') ;?></h4>


			<?php  foreach ($records as $record) :?>		

					<ul class="nav nav-stacked">
					<li class="text-center text-blue"><?php e($record->name); ?></li>
				
					<?php if ($record->sport_id != 0) : ?>
					<li>
						<?php echo lang('competitions_field_sport'); ?>
						<span class="pull-right">
							<img class="h30" src="<?php echo base_url();?>uploads/sports/<?php echo $this->sports_model->get_sport_icon_by_id($record->sport_id);?>"/>
							<?php echo $this->sports_model->get_sport_name_by_id($record->sport_id) ?>
						</span>	
					</li>
					<?php endif; ?>
					
					<?php if ($record->league_id != 0) : ?>
					<li>
						<?php echo lang('competitions_field_league'); ?>
						<span class="pull-right">
							<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
							<img class="h30 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
							<?php echo $this->leagues_model->get_league_name_by_id($record->league_id) ?>
						</span>
					</li>	
					<?php endif; ?>	

					<li><?php echo lang('competitions_field_start_date'); ?>
						<span class="pull-right label label-blue">
							<?php echo date('M j, Y', strtotime($record->start_date)); ?>
						</span>
					</li>
					
					<li><?php echo lang('competitions_field_end_date'); ?>
						<span class="pull-right label label-red">
							<?php echo date('M j, Y', strtotime($record->end_date)); ?>
						</span>
					</li>	
					
					<li><?php echo lang('competitions_field_price_pool'); ?>
						<span class="pull-right text-green">
							<?php e($record->price_pool); ?><span class="ml5"><?php echo $record->currency;?></span>
						</span>
					</li>	
					
					<li><?php echo lang('competitions_field_rewards'); ?>
						<span class="pull-right">
							<?php e($record->rewards); ?>
						</span>
					</li>
					
					<li><?php echo lang('competitions_field_sponsored_by'); ?>
						<span class="pull-right">
							<img class="h30 mtm4" src="<?php echo base_url();?>uploads/bookmakers/<?php e($this->bookmakers_model->get_bookmaker_logo_by_id($record->sponsored_by)); ?>"/>
						</span>
					</li>	
					<li><?php echo lang('competitions_min_tips'); ?>
						<span class="pull-right">
							<?php e($record->min_tips); ?>
						</span>
					</li>				

					
					</ul>

			<?php endforeach; ?>
				
				
					
		</div><!-- /box-body -->	

	</div><!-- /box-->							