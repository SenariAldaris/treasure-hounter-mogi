<?php
	$tips_open = $this->settings_lib->item('tips.allow_post');
?>

<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error animated animated-short zoomIn'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('tips_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($tips->id) ? $tips->id : '';
$match_id = $this->uri->segment(3);
$sport_id = $this->bet_events_model->get_sport_by_event_id($match_id);
$league_id = $this->bet_events_model->get_league_by_event_id($match_id);
$league_name = $this->leagues_model->get_league_name_by_id($league_id);
$country_id = $this->leagues_model->get_league_country_by_id($league_id);
$match_date = $this->bet_events_model->get_match_date_by_id($match_id); 
$match_time = $this->bet_events_model->get_match_time_by_id($match_id); 
?>


	<div class="box">

		<div class="box-body">					
			<ul class="nav nav-tabs mb15">
				<li class="active"><a href="#bet_detail" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_bet_details'); ?></a></li>
				<li class=""><a href="#stats" data-toggle="tab" aria-expanded="true"><?php echo lang('tips_statistics'); ?></a></li>
			</ul>		
		
			<div class="tab-content">		

				<div class="tab-pane active fade in" id="bet_detail">					
					<h4>
						<img class="h30 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport_id)); ?>"/>
						<img class="h30 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
									
						<span class="text-blue fs14 mr20"><?php e(strtoupper($league_name)); ?></span>
						<span class="fs14 mr20"><?php echo date('M d,Y', strtotime($match_date)); ?></span>
						<span class="fs14 mr20"><?php echo date('H:i T', strtotime($match_time)); ?></span>
						
						<span class="pull-right fs12"><?php echo lang('tips_action_before_post');?>
						<button type="button" class="btn btn-blue ml20" data-toggle="modal" data-target="#TipsRules">
							<?php echo lang('tips_action_read_rules');?>
						</button></span>
					</h4>
					<div class="divider-4"></div>
			
					<?php if ( $tips_open ) { ?>

						<?php echo form_open($this->uri->uri_string(), 'id="form" class="form-horisontal"'); ?>
						
							<?php if (isset($current_user->id)) : ?>
							  <input id="created_by" type="hidden" name="created_by" value="<?php echo $current_user->id; ?>" />
							<?php endif; ?>
							
							<input id="created_on" type="hidden" name="created_on"  value="<?php echo date('Y-m-d H:i:s'); ?>" />
							
							<input type="hidden" id="sport_id" name="sport_id" value="<?php echo $sport_id; ?>"/>
							<input type="hidden" id="league_id" name="league_id" value="<?php echo $league_id; ?>"/>
							<input type="hidden" id="match_id" name="match_id" value="<?php echo $match_id; ?>"/>
							<input type="hidden" id="match_date" name="match_date" value="<?php echo $match_date; ?>"/>
							<input type="hidden" id="match_time" name="match_time" value="<?php echo $match_time; ?>"/>

							<div class="form-group text-center">
								<span class="fs20"><?php e(strtoupper($home_team)); ?>
								<img class="h30 mtm2 ml10" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($home_team),$league_id)); ?>"/>
								<span class="mh20 text-blue">VS</span>
								<img class="h30 mtm2 mr10" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($away_team),$league_id)); ?>"/>
								<?php e(strtoupper($away_team)); ?></span>
							</div>

							<div class="divider-4"></div>

	

					<!-- Start Row -->
					<div class="row">
				
						<div class="bet_id">
							<div class="col-sm-4">
								<div class="form-group<?php echo form_error('bet_id') ? ' has-error' : ''; ?>">
									<?php echo form_label(lang('tips_bet_category') . lang('bf_form_label_required'), 'bet_id', array('class' => 'control-label')); ?>
								
									<select name="bet_id" id="bet_id" class="form-control">
										<!-- Auto Populated -->	
									</select>

									<?php echo form_error('bet_id');?>
								</div>
							</div>
						</div>
					
					
						<div class="choice_id">
							<div class="col-sm-5">
								<div class="form-group<?php echo form_error('choice_id') ? ' has-error' : ''; ?>">
									<?php echo form_label(lang('tips_bet_type') . lang('bf_form_label_required'), 'choice_id', array('class' => 'control-label')); ?>
								
									<select name="choice_id" id="choice_id" class="form-control">
										<!-- Auto Populated -->		
									</select>
									<?php echo form_error('choice_id');?>
								</div>
							</div>
						</div>

						<div class="stake">
							<div class="col-sm-3">
							<div class="form-group <?php echo form_error('stake') ? ' has-error' : ''; ?>">
								<?php echo form_label(lang('tips_stake') . lang('bf_form_label_required'), 'stake', array('class' => 'control-label')); ?>
								
									<?php $stakes = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10');?>
									<select name="stake" id="stake" class="form-control">
										<option value=""><?php echo lang('tips_select_stake');?></option>
										<?php foreach ($stakes as $stake) {
											$sel = ($stake==set_value('stake'))?'selected="selected"':'';
											?>
											<option value="<?php echo $stake;?>" <?php echo $sel;?>><?php echo $stake;?></option>
										<?php }?>
									</select>
									<span class='help-block'><?php echo form_error('stake'); ?></span>
								</div>
							</div>
						</div>	

					</div>
					<!-- End Row -->					

					<input type="hidden" name="odds" id="odds" value="" />
			

					<!-- Start Row -->
					<div class="row">				
					
						<div class="col-sm-12">
							<div class="form-group<?php echo form_error('description') ? ' has-error' : ''; ?>">
								<?php echo form_label(lang('tips_description') . lang('bf_form_label_required'), 'description', array('class' => 'control-label')); ?>
								<textarea class="textarea" name="description" id="description" placeholder="<?php echo lang('tips_min_words');?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
							</div>
							<span class='help-block'><?php echo form_error('description'); ?></span>
						</div>					
						
					</div>
					<!-- End Row -->	



					<div class="box-footer">
						<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('tips_action_send'); ?>" />	
					</div>
						
					<?php echo form_close(); ?>
					
					<?php } else { ?>
					
						<div class="alert alert-info">
							<h4> Sorry!</h4>
							Cannot bet now.
						</div>
						
					<?php } ?>
				
				
				</div>	<!-- /.tab-pane -->
				
				<div class="tab-pane fade in" id="stats">		
				
				
					<ul class="nav nav-tabs mb15">
						<li class="active">
							<a href="#head-to-head" data-toggle="tab" aria-expanded="true">
								<img class="h24 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($home_team,$league_id)); ?>"/>
								<span class=""> - </span>
								<img class="h24 mtm4 mr10" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($away_team,$league_id)); ?>"/>
								Head to head
							</a>
						</li>
						<li class="">
							<a href="#home" data-toggle="tab" aria-expanded="true">
								<img class="h24 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($home_team,$league_id)); ?>"/>
								<?php echo $home_team;?><span class="mh10">-</span>(<?php echo lang('tips_stats'); ?>)
							</a>
						</li>
						<li class="">
							<a href="#away" data-toggle="tab" aria-expanded="true">
								<img class="h24 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($away_team,$league_id)); ?>"/>
								<?php echo $away_team;?><span class="mh10">-</span>(<?php echo lang('tips_stats'); ?>)
							</a>
						</li>
					</ul>
				
					<div class="tab-content">	
						<div class="tab-pane active fade in" id="head-to-head">
							<h4 class="head text-left pl10 fs14"><?php echo lang('tips_head_to_head'); ?></h4>
							<div class="table-responsive">
								<table id="events_table" class="table table-striped" role="grid">
									<thead class="bg-black">
										<tr>
											<th class="text-left pn pl10"><?php echo lang('tips_championship'); ?></th>						
											<th class="pn"><?php echo lang('tips_match_date'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="w80 pn"><?php echo lang('tips_result'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
										</tr>
									</thead>				

									<tbody>
										<?php  $head_to_head = $this->results_model->get_head_to_head_results_a($home_team,$away_team,$sport_id);
												$head_to_head2 = $this->results_model->get_head_to_head_results_h($home_team,$away_team,$sport_id);

												if (isset($head_to_head) && is_array($head_to_head) && count($head_to_head) &&
												 (isset($head_to_head2) && is_array($head_to_head2) && count($head_to_head2))) :
												foreach ($head_to_head as $head_result):?>	
										<tr>
											<td class="text-left">
												<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($head_result->sport_id)); ?>"/>
												<?php $country_id = $this->leagues_model->get_league_country_by_id($head_result->league_id); ?>		
												<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

												<?php $league_name = $this->leagues_model->get_league_name_by_id($head_result->league_id); ?>
												<span class="text-black"><?php echo substr($league_name, 0, 15)?> ...</span>
											</td>					
											<td>
												<?php echo date('M d,Y', strtotime($head_result->match_date)); ?>
											</td>
											<td class="text-blue text-right mr10">
												<?php echo $head_result->home_team;?>
											</td>	
											<td class="w30 pn text-right">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($head_result->home_team,$head_result->league_id)); ?>"/>
												
											</td>						
											<td class="w100">
												<?php if($head_result->home > $head_result->away):?>
												<span class="text-blue"><?php echo $head_result->home; ?></span>
												<span class="mh5">-</span>
												<?php echo $head_result->away; ?>
												<?php elseif($head_result->home < $head_result->away):?>
												<?php echo $head_result->home; ?>
												<span class="mh5">-</span>
												<span class="text-blue"><?php echo $head_result->away; ?></span>	
												<?php else:?>
												<?php echo $head_result->home; ?>
												<span class="mh5">-</span>
												<?php echo $head_result->away; ?>
												<?php endif;?>											
											</td>	
											<td class="w30 pn text-left">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($head_result->away_team),$head_result->league_id)); ?>"/>
											</td>
											<td class="text-blue text-left ml10">
												<?php echo $head_result->away_team;?>
											</td>
					
										</tr>
										<?php endforeach;?>
										<?php foreach ($head_to_head2 as $head_result):?>	
										<tr>
											<td class="text-left">
												<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($head_result->sport_id)); ?>"/>
												<?php $country_id = $this->leagues_model->get_league_country_by_id($head_result->league_id); ?>		
												<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

												<?php $league_name = $this->leagues_model->get_league_name_by_id($head_result->league_id); ?>
												<span class="text-black"><?php echo substr($league_name, 0, 15)?> ...</span>
											</td>					
											<td>
												<?php echo date('M d,Y', strtotime($head_result->match_date)); ?>
											</td>
											<td class="text-blue text-right mr10">
												<?php echo $head_result->home_team;?>
											</td>	
											<td class="w30 pn text-right">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($head_result->home_team,$head_result->league_id)); ?>"/>
												
											</td>						
											<td class="w100">
												<?php if($head_result->home > $head_result->away):?>
												<span class="text-blue"><?php echo $head_result->home; ?></span>
												<span class="mh5">-</span>
												<?php echo $head_result->away; ?>
												<?php elseif($head_result->home < $head_result->away):?>
												<?php echo $head_result->home; ?>
												<span class="mh5">-</span>
												<span class="text-blue"><?php echo $head_result->away; ?></span>	
												<?php else:?>
												<?php echo $head_result->home; ?>
												<span class="mh5">-</span>
												<?php echo $head_result->away; ?>
												<?php endif;?>											
											</td>	
											<td class="w30 pn text-left">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($head_result->away_team),$head_result->league_id)); ?>"/>
											</td>
											<td class="text-blue text-left ml10">
												<?php echo $head_result->away_team;?>
											</td>					
										</tr>
										<?php endforeach;?>
										<?php else:?>
									
										<tr>
											<td colspan="7" class="text-left text-red pl50"><?php echo lang('bet_events_no_results'); ?></td>
										</tr>
										<?php endif;?>	
									</tbody>	
								</table>	
							</div>
						</div>	<!-- /.tab-pane -->	
						
						<div class="tab-pane fade in" id="home">
							<h4 class="head text-left pl10 fs14"><?php echo lang('tips_latest_results'); ?></h4>
							<div class="table-responsive">
								<table id="events_table" class="table table-striped" role="grid">
									<thead class="bg-black">
										<tr>
											<th class="text-left pn pl10"><?php echo lang('tips_championship'); ?></th>						
											<th class="pn"><?php echo lang('tips_match_date'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="w80 pn"><?php echo lang('tips_result'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
										</tr>
									</thead>				

									<tbody>
										<?php $home_results = $this->results_model->get_results_by_team($home_team,$sport_id);
						
											if (isset($home_results) && is_array($home_results) && count($home_results)) :
												foreach ($home_results as $home_result):?>	
										<tr>
											<td class="text-left">
												<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($home_result->sport_id)); ?>"/>
												<?php $country_id = $this->leagues_model->get_league_country_by_id($home_result->league_id); ?>		
												<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
												
												<?php $league_name = $this->leagues_model->get_league_name_by_id($home_result->league_id); ?>
												<span class="text-black"><?php echo substr($league_name, 0, 15)?> ...</span>
												
											</td>	
											<td>
												<?php echo date('M d,Y', strtotime($home_result->match_date)); ?>
											</td>						
											<td class="text-blue text-right mr10">
												<?php echo $home_result->home_team;?>
											</td>	
											<td class="w30 pn text-right">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($home_result->home_team,$home_result->league_id)); ?>"/>
												
											</td>

											<td class="w100">
												<?php if($home_result->home > $home_result->away):?>
												<span class="text-blue"><?php echo $home_result->home; ?></span>
												<span class="mh5">-</span>
												<?php echo $home_result->away; ?>
												<?php elseif($home_result->home < $home_result->away):?>
												<?php echo $home_result->home; ?>
												<span class="mh5">-</span>
												<span class="text-blue"><?php echo $home_result->away; ?></span>	
												<?php else:?>
												<?php echo $home_result->home; ?>
												<span class="mh5">-</span>
												<?php echo $home_result->away; ?>
												<?php endif;?>											
											</td>
											<td class="w30 pn text-left">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($home_result->away_team,$home_result->league_id)); ?>"/>
											</td>
											<td class="text-blue text-left ml10">
												<?php echo $home_result->away_team;?>
											</td>											
										</tr>
										<?php endforeach; endif;?>
									</tbody>	
								</table>	
							</div>
							<h4 class="head text-left pl10 fs14"><?php echo lang('bet_events_upcoming_fixtures'); ?></h4>
							<div class="table-responsive">

									<table id="events_table" class="table table-striped" role="grid">
									<thead class="bg-black">
										<tr>
											<th class="text-left pn pl10"><?php echo lang('tips_championship'); ?></th>						
											<th class="pn"><?php echo lang('tips_match_date'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="w80 pn"><?php echo lang('tips_match'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
										</tr>
									</thead>				
								
									<tbody>	
										<?php  $upcoming_events_home = $this->bet_events_model->get_upcoming_events_by_team($home_team,$league_id,$match_date);

											if (isset($upcoming_events_home) && is_array($upcoming_events_home) && count($upcoming_events_home)) :
												foreach ($upcoming_events_home as $upcoming_event):?>	
										<tr>
											<td class="text-left">
												<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($upcoming_event->sport_id)); ?>"/>
												<?php $country_id = $this->leagues_model->get_league_country_by_id($upcoming_event->league_id); ?>		
												<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

												<?php $league_name = $this->leagues_model->get_league_name_by_id($upcoming_event->league_id); ?>
												<span class="text-black"><?php echo substr($league_name, 0, 15)?> ...</span>
											</td>					
											<td>
												<?php echo date('M d,Y', strtotime($upcoming_event->match_date)); ?>
											</td>
											<td class="text-blue text-right mr10">
												<?php echo $upcoming_event->home_team;?>
											</td>	
											<td class="w30 pn text-right">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($upcoming_event->home_team,$upcoming_event->league_id)); ?>"/>
												
											</td>	
											<td class="pn"><span class="text-black mh5">-</span></td>
											<td class="w30 pn text-left">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($upcoming_event->away_team,$upcoming_event->league_id)); ?>"/>
												
											</td>	
											<td class="text-blue text-left mr10">
												<?php echo $upcoming_event->away_team;?>
											</td>
										</tr>	
										<?php endforeach;?>
										<?php else:?>
									
										<tr class="">
											<td colspan="7" class="text-left text-red pl50"><?php echo lang('bet_events_no_upcoming_events'); ?></td>
										</tr>
										<?php endif;?>	
									</tbody>
								</table>
							</div>								
						</div>	<!-- /.tab-pane -->	
						
						<div class="tab-pane fade in" id="away">
							<h4 class="head text-left pl10 fs14"><?php echo lang('tips_latest_results'); ?></h4>
							<div class="table-responsive">
								<table id="events_table" class="table table-striped" role="grid">
									<thead class="bg-black">
										<tr>
											<th class="text-left pn pl10"><?php echo lang('tips_championship'); ?></th>						
											<th class="pn"><?php echo lang('tips_match_date'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="w80 pn"><?php echo lang('tips_result'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
										</tr>
									</thead>				

									<tbody>
										<?php  $away_results = $this->results_model->get_results_by_team($away_team,$sport_id);

											if (isset($away_results) && is_array($away_results) && count($away_results)) :
												foreach ($away_results as $away_result):?>	
										<tr>
											<td class="text-left">
												<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($away_result->sport_id)); ?>"/>
												<?php $country_id = $this->leagues_model->get_league_country_by_id($away_result->league_id); ?>		
												<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

												<?php $league_name = $this->leagues_model->get_league_name_by_id($away_result->league_id); ?>
												<span class="text-black"><?php echo substr($league_name, 0, 15)?> ...</span>
											</td>					
											<td>
												<?php echo date('M d,Y', strtotime($away_result->match_date)); ?>
											</td>
											<td class="text-blue text-right mr10">
												<?php echo $away_result->home_team;?>
											</td>	
											<td class="w30 pn text-right">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($away_result->home_team,$away_result->league_id)); ?>"/>
												
											</td>						
											<td class="w100">
												<?php if($away_result->home > $away_result->away):?>
												<span class="text-blue"><?php echo $away_result->home; ?></span>
												<span class="mh5">-</span>
												<?php echo $away_result->away; ?>
												<?php elseif($away_result->home < $away_result->away):?>
												<?php echo $away_result->home; ?>
												<span class="mh5">-</span>
												<span class="text-blue"><?php echo $away_result->away; ?></span>	
												<?php else:?>
												<?php echo $away_result->home; ?>
												<span class="mh5">-</span>
												<?php echo $away_result->away; ?>
												<?php endif;?>											
											</td>	
											<td class="w30 pn text-left">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($away_result->away_team),$away_result->league_id)); ?>"/>
											</td>
											<td class="text-blue text-left ml10">
												<?php echo $away_result->away_team;?>
											</td>				
										</tr>
										<?php endforeach; endif;?>
									</tbody>	
								</table>	
							</div>
							
							<h4 class="head text-left pl10 fs14"><?php echo lang('bet_events_upcoming_fixtures'); ?></h4>
							<div class="table-responsive">

								<table id="events_table" class="table table-striped" role="grid">
									<thead class="bg-black">
										<tr>
											<th class="text-left pn pl10"><?php echo lang('tips_championship'); ?></th>						
											<th class="pn"><?php echo lang('tips_match_date'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
											<th class="w80 pn"><?php echo lang('tips_match'); ?></th>
											<th class="pn"></th>
											<th class="pn"></th>
										</tr>
									</thead>				
								
									<tbody>	
										<?php  $upcoming_events_away = $this->bet_events_model->get_upcoming_events_by_team($away_team,$league_id,$match_date);

											if (isset($upcoming_events_away) && is_array($upcoming_events_away) && count($upcoming_events_away)) :
												foreach ($upcoming_events_away as $upcoming_event):?>	
										<tr>
											<td class="text-left">
												<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($upcoming_event->sport_id)); ?>"/>
												<?php $country_id = $this->leagues_model->get_league_country_by_id($upcoming_event->league_id); ?>		
												<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>

												<?php $league_name = $this->leagues_model->get_league_name_by_id($upcoming_event->league_id); ?>
												<span class="text-black"><?php echo substr($league_name, 0, 15)?> ...</span>
											</td>					
											<td>
												<?php echo date('M d,Y', strtotime($upcoming_event->match_date)); ?>
											</td>
											<td class="text-blue text-right mr10">
												<?php echo $upcoming_event->home_team;?>
											</td>	
											<td class="w30 pn text-right">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($upcoming_event->home_team,$upcoming_event->league_id)); ?>"/>
												
											</td>	
											<td class="pn"><span class="text-black mh5">-</span></td>
											<td class="w30 pn text-left">	
												<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($upcoming_event->away_team,$upcoming_event->league_id)); ?>"/>
												
											</td>	
											<td class="text-blue text-left mr10">
												<?php echo $upcoming_event->away_team;?>
											</td>
										</tr>	
										<?php endforeach;?>
										<?php else:?>
									
										<tr class="">
											<td colspan="7" class="text-left text-red pl50"><?php echo lang('bet_events_no_upcoming_events'); ?></td>
										</tr>
										<?php endif;?>	
									</tbody>
								</table>
							</div>			
						</div>	<!-- /.tab-pane -->	
						
					</div><!-- /.tab-content -->

					
				</div>	<!-- /.tab-pane -->		
						
			</div><!-- /.tab-content -->				
				
				
				

		</div><!-- /.box-body -->
	</div><!-- /.box -->

	
	
  <div id="TipsRules" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content p10">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h1 class="text-center"><?php echo lang('tips_rules'); ?></h1>
        </div>
        <div class="modal-body" data-ng-controller="rulesCtrl">
          

        <?php $rules = $this->settings_lib->item('tips.rules');
		
				echo $rules
        ;?>
		  
		  
        </div>
        <div class="modal-footer bg-default">
            &nbsp;
        </div>
    </div>
    </div>
  </div><!--/modal-->
  
<script type="text/javascript">
	// Define site_url variable for use in the js file
	var site_url = "<?php echo site_url(); ?>";
	var match_id = "<?php echo $this->uri->segment(3); ?>";
	// Define error messages for jquery validation

	var description_forgot = '<?php echo lang('tips_desc_forgot');?>'
	var description_req = '<?php echo lang('tips_min_words');?>'

</script>