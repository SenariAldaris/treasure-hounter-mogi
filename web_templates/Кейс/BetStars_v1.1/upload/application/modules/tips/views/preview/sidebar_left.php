	<div class="box box-widget widget-user">
		<div class="box-body">
			<h4 class="head fs14"><?php echo lang('tips_bet_details') ;?></h4>

			<?php  foreach ($records as $record) :?>		

					<ul class="nav nav-stacked">	

						<li>		
							<?php echo lang('tips_post_date') ;?>
							<span class="pull-right">
								<span class="text-red"><?php echo date('M j, Y', strtotime($record->created_on)); ?> </span> 
							</span>
						</li>	
						<li>		
							<?php echo lang('tips_post_time') ;?>
							<span class="pull-right">
								<span class="text-blue"><?php echo date('H:i', strtotime($record->created_on)); ?></span>
							</span>
						</li>						
						<li>				
							<?php echo lang('tips_tipster') ;?>
							<span class="pull-right text-blue">
								<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->created_by;?>">
								<?php echo $this->tipsters_model->get_user_display_name_by_id($record->created_by);?>
								</a>
							</span>
						</li>							
						<li>				
							<?php echo lang('tips_bet_type') ;?>
							<span class="pull-right">
								<?php echo strtoupper($record->bet_name);?>
							</span>
						</li>	
						
					
						<li>				
							<?php echo lang('tips_bet_choice') ;?>
								<span class="pull-right label label-blue">
									<?php echo $record->choice_name;?>
								</span>
						</li>	

						<li>		
							<?php echo lang('tips_odds') ;?>
							<span class="pull-right">
								<?php echo $record->odd;?>
							</span>
						</li>
						<li>
							<?php echo lang('tips_stake') ;?>
							<span class="pull-right text-blue">
								<?php echo $record->stake;?>
							</span>
						</li>						
						<li>
							<?php echo lang('tips_status') ;?>
							<?php if($record->status == 3) {?>
							<span class="pull-right text-green">
							  <?php echo ucfirst($this->tips_model->get_tips_status_name_by_id($record->status)); ?>
							</span>
							<?php } elseif ($record->status == 4) {?>
							<span class="pull-right text-red">
							  <?php echo ucfirst($this->tips_model->get_tips_status_name_by_id($record->status)); ?>
							</span>
							<?php } elseif($record->status == 5) {?>
							<span class="pull-right text-yellow">
							  <?php echo ucfirst($this->tips_model->get_tips_status_name_by_id($record->status)); ?>
							</span>
							<?php } 
							else {?>
							<span class="pull-right text-blue">Active</span>	
							<?php } ?>	
						</li>
						<li>
							<?php echo lang('tips_winnings') ;?>
							<?php if($record->status == 3) {?>
								<span class="pull-right label label-green"><i class="fa fa-thumbs-up"></i>
									<?php echo $record->winnings;?>
								</span>	
							<?php } elseif ($record->status == 4) {?>
								<span class="pull-right label label-red"><i class="fa fa-thumbs-down"></i>
									<?php echo $record->winnings;?>
								</span>	
							<?php } elseif($record->status == 5) {?>
								<span class="pull-right label label-yellow"><i class="fa fa-hand-stop-o"></i>
									<?php echo $record->winnings;?>
								</span>	
							<?php } 	
							 else {?>
								<span class="pull-right label label-blue">?</span>	
							<?php } ?>	
						</li>						
					</ul>

			<?php endforeach; ?>
				
				
					
		</div><!-- /box-body -->	

	</div><!-- /box-->					