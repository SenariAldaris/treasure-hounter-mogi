			
	<div class="box">
		<div class="box-body">
			<?php $sport_id = $this->uri->segment(3); 
			
			$sport = $this->sports_model->get_sport_name_by_id($sport_id); ?>
			
			<h4 class="fs14 text-left"><?php echo lang('tips_by_sport'); ?> - 
			<img class="h24 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport_id)); ?>"/>
			<?php echo $sport;?></h4>	
			<div class="divider-4 mtn"></div>

			<!-- Accordion starts -->
			<div class="panel-group" id="accordion">			

				<?php if (isset($records) && is_array($records) && count($records)) : ?>
								<?php
					foreach ($records as $record) :
					?>
					
					
				<!-- Panel -->
				<div class="panel">	
					<!-- Panel heading -->
					<div class="panel-heading">
						<h4 class="panel-title">

							<img class="h24 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
							<?php $country_id = $this->championships_model->get_championship_country_by_id($record->championship_id);?>
							
							<img class="h24 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
							<span class="fs12 mr10"><?php e($this->leagues_model->get_league_short_name_by_id($record->league_id)); ?>
							</span>
								
							<?php $home_id = $this->bet_events_model->get_home_team_by_event_id($record->event_id); 
								$away_id   = $this->bet_events_model->get_away_team_by_event_id($record->event_id);
								$home_team = $this->teams_model->get_team_name_by_id($home_id);
								$away_team = $this->teams_model->get_team_name_by_id($away_id); 
							?>	
								
							<span class="text-blue"><?php echo $home_team; ?></span> 
							<span class="ml10 mr10">vs</span>
							<span class="text-blue"><?php echo $away_team; ?></span>
						
							<div class="fr fs12">
								<?php echo lang('tips_by'); ?>	
								<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->created_by;?>">	
									 <?php echo $this->tipsters_model->get_user_display_name_by_id($record->created_by);?>
								</span>

								
								<a href="<?php echo base_url(); ?>tips/preview/<?php echo $record->id; ?>" class="btn btn-blue mtm2 ml20">
									<?php echo lang('tips_view_full'); ?>
								</a>
								 
							</div>
						</h4>
					</div>
					<!-- End Panel heading -->

				</div>
				<!-- End Panel-->			
				
				
				
				
				
				
				
							
				<?php endforeach; else:?>
				<div class='alert alert-info mt20'>
					<?php echo lang('tips_records_empty'); ?>
				</div>
					
			</div>			
					
			<?php endif; ?>
			
		</div>
	</div>	