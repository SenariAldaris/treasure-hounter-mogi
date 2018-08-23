<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('tips_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($tips->id) ? $tips->id : '';

?>

	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/tips" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
      
            <div class="box-body">
			
				<div class="row">
				
					<div class="col-sm-6">
					
						<ul class="nav nav-stacked">
						
							<li><h4 class="text-center text-blue"><strong><?php echo lang('tips_event_details') ;?></strong></h4></li>
							<li>
								<input id="sport_id" type="hidden" name="sport_id" value="<?php echo $tips->sport_id; ?>" />
								<?php echo lang('tips_sport_id') ;?>
									<span class="pull-right">
										<img class="w30 mtm2" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($tips->sport_id)); ?>"/>
										<?php echo $this->sports_model->get_sport_name_by_id($tips->sport_id);?>
									</span>								
							</li>
							<li>
								<input id="league_id" type="hidden" name="league_id" value="<?php echo $tips->league_id; ?>" />
								<input id="match_id" type="hidden" name="match_id" value="<?php echo $tips->match_id; ?>" />
								<?php $country_id = $this->leagues_model->get_league_country_by_id($tips->league_id);?>
								<?php echo lang('tips_league_id') ;?>
									<span class="pull-right">
										<img class="w30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
										<?php echo $this->leagues_model->get_league_name_by_id($tips->league_id);?>
									</span>								
							</li>	
							<?php if($tips->bet_name != 'Outright Winner'):?>		
							<li>
								
								<?php $match = $this->tips_model->get_match_by_id($tips->match_id);							
								foreach($match as $rec):?>
								
								<?php echo lang('tips_match') ;?>
									<span class="pull-right text-blue">
                                    <?php e($rec->home_team); ?><span class="text-black mh5">-</span><?php e($rec->away_team); ?>
									</span>
								<?php endforeach;?>	
							</li>
							<?php endif;?>								
							<li>                               
								<?php echo lang('tips_match_date') ;?>
									<span class="pull-right label label-red">
										<input id="match_date" type="hidden" name="match_date" value="<?php echo $tips->match_date; ?>" />
										<?php echo date('M j, Y', strtotime($tips->match_date)); ?>
									</span>
							</li>							
							<?php if($tips->bet_name != 'Outright Winner'):?>	
							<li>				
								<?php echo lang('tips_match_time') ;?>
								<span class="pull-right label label-grey">
									<input id="match_time" type="hidden" name="match_time" value="<?php echo $tips->match_time; ?>" />
									<?php echo date('H:i', strtotime($tips->match_time)); ?>
								</span>
							</li>
							<?php endif;?>	
							<li><h4 class="text-center text-blue"><strong><?php echo lang('tips_bet_details') ;?></strong></h4></li>	
							<li>	
								<input id="created_on" type="hidden" name="created_on" value="<?php echo $tips->created_on; ?>" />	
								<?php echo lang('tips_created_on') ;?>
									<span class="pull-right">
										<span class="text-red"><?php echo date('M j, Y', strtotime($tips->created_on)); ?> </span> at 
										<span class="text-blue"><?php echo date('H:i', strtotime($tips->created_on)); ?></span>
									</span>
							</li>							
							<li>				
								<input id="created_by" type="hidden" name="created_by" value="<?php echo $tips->created_by; ?>" />
								<?php echo lang('tips_tipster') ;?>
									<span class="pull-right text-blue">
										<?php echo $this->tipsters_model->get_user_display_name_by_id($tips->created_by);?>
									</span>
							</li>							
							<li>				
								<input id="bet_name" type="hidden" name="bet_name" value="<?php echo $tips->bet_name; ?>" />
								<input id="bet_id" type="hidden" name="bet_id" value="<?php echo $tips->bet_id; ?>" />
								<?php echo lang('tips_bet_type') ;?>
									<span class="pull-right">
										<?php echo $tips->bet_name;?>
									</span>
							</li>	
							
							<li>
							<input id="choice_name" type="hidden" name="choice_name" value="<?php echo $tips->choice_name; ?>" />

								<?php echo lang('tips_bet_choice') ;?>
									<span class="pull-right">
										<?php echo $tips->choice_name;?>
									</span>
							</li>	

							
							<li>		
								<input id="odds" type="hidden" name="odds" value="<?php echo $tips->odd; ?>" />
								<?php echo lang('tips_odds') ;?>
									<span class="pull-right">
										<?php echo $tips->odd;?>
									</span>
							</li>
							<li>
								<input id="stake" type="hidden" name="stake" value="<?php echo $tips->stake; ?>" />
								<?php echo lang('tips_stake') ;?>
									<span class="pull-right text-blue">
										<?php echo $tips->stake;?>
									</span>
							</li>
						</ul>

					</div> <!-- /col -->	


					<div class="col-sm-6">
					
						<ul class="nav nav-stacked">
							<input id="description" type="hidden" name="description" value="<?php echo $tips->description; ?>" />
							<li><h4 class="text-center text-blue"><strong><?php echo lang('tips_description') ;?></strong></h4></li>
							
						</ul>	


						<div class="divider-4 mtn"></div>
						<div class="form-group<?php echo form_error('description') ? ' has-error' : ''; ?>">
											
							<?php echo $tips->description;?>
						
							
						</div>	
						
						<div class="divider-4"></div>
						<?php $result = $this->results_model->get_result_by_match_id($tips->match_id);
						foreach ($result as $record):?>
						<div class="form-group<?php echo form_error('result') ? ' error' : ''; ?>">
							<?php echo form_label(lang('tips_match_result'), 'result', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-7'>
								<input class="form-control" type='text' name='result' maxlength='30' 
								value="<?php echo $record->home; ?> - <?php echo $record->away; ?>" disabled /> 

							</div>
						
						</div>	
						<?php endforeach;?>						
						
						
						<?php $options = $statuses;

							echo form_dropdown_custom2( 'status', $options, set_value('status', isset($tips->status) ? $tips->status : ''),lang('tips_status'), 'class="form-control"');
						?>	

						<div class="alert alert-info">
							<h4> <?php echo lang('tips_note');?></h4>
								<?php echo lang('tips_winnings_calculate');?>
						</div>
						
						<div class="form-group">
							<div class='col-sm-6'>
								<ul class="nav nav-stacked fs16">
									<li><?php echo lang('tips_winnings');
									
									if ($tips->status == 3){ ?>
										<span class="pull-right text-green"><i class="fa fa-thumbs-up mr10"></i><?php echo $tips->winnings;?></span>
									<?php } 
									elseif ($tips->status == 4){ ?>
										<span class="pull-right text-red"><i class="fa fa-thumbs-down mr10"></i><?php echo $tips->winnings;?></span>
									<?php }									
									elseif ($tips->status == 5){ ?>
										<span class="pull-right text-yellow"><i class="fa fa-hand-stop-o mr10"></i><?php echo $tips->winnings;?></span>
									<?php }										
									else { ?>
										<span class="pull-right text-blue"><?php echo $tips->winnings;?></span>
									<?php } ?>	
									</li>
								</ul>
							</div>
						</div>
					</div><!-- /col -->	
			
			    </div><!-- /row -->	
				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('tips_action_edit'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/tips', lang('tips_cancel'), 'class="btn btn-yellow"'); ?>
					
					<?php if ($this->auth->has_permission('Tips.Content.Delete')) : ?>
						<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('tips_delete_confirm'))); ?>');">
							<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('tips_delete_record'); ?>
						</button>
					<?php endif; ?>
				</div>
		<?php echo form_close(); ?>
	</div>