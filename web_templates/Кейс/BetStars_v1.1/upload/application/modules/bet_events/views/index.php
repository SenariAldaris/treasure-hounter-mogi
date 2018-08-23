<?php  $sport_name = $this->sports_model->get_sport_name_by_id(1);?>
	<div class="box">
		<div class="box-header bg-white pbn">

			<h4 class="head text-left pl10 fs14">
			<img class="h30 mtm2" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id(1)); ?>"/>
			<span class="bg-white text-black p5"><?php echo $sport_name;?></span>
			<span class="ml10"><?php echo lang('bet_events_active_events'); ?></span>
			<form id="sport_form" class="form-inline">
			    <span class="pull-right mr20 hidden-xs" style="position: absolute;right: 0;top: 25px;">

						<div class="form-group <?php echo form_error('sport_id') ? ' has-error' : ''; ?>">
							<label class="control-label mr20"><?php echo lang('bet_events_filter_by_sport');?></label>
							<select name="sport_id" id="sport_id" class="form-control">
								<option value=""><?php echo lang('bet_events_select_sport');?></option>
								<?php foreach ($sports->result() as $sport) {
									$sel = ($sport->id==set_value('sport_id'))?'selected="selected"':'';
									?>
									<option value="<?php echo $sport->id;?>" <?php echo $sel;?>><?php echo $sport->name;?></option>
								<?php }?>
							</select>
						</div>
					<button type="submit" id="sport_filter" class="btn btn-white"><?php echo lang('bet_events_filter'); ?></button>
					<button class="gobottom pull-right btn btn-white ml10"><i class="fa fa-arrow-down"></i></button>
			    </span>
			</form>
			
			</h4>

		</div>	

		<div class="box-body">	
			<div class="table-responsive">
				
					<?php  if (isset($leagues) && is_array($leagues) && count($leagues)) :

						foreach ($leagues as $league) :?>
 
				
				<table id="events_table" class="table table-striped" role="grid">
					<thead class="bg-black">
						<tr>
							<th class="text-left pn w225 pl10">
								<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($league->sport_id)); ?>"/>
								<img class="h24 mtm4 mr5" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($league->country_id)); ?>"/>
								<a class="text-white" href="<?php echo base_url();?>events/by_league/<?php echo $league->league_id;?>">
								
								<?php echo character_limiter($league->league_name ,12,'&#8230;'); ?>
								</a>
								
							</th>
							<th class="pn"></th>
							<th class="pn"></th>
							<th class="pn"></th>
							<th class="pn"></th>
							<th class="pn w100"><?php echo lang('bet_events_time'); ?></th>
							<th class="pn w80"><?php echo lang('bet_events_home'); ?></th>
							<th class="pn w80"><?php echo lang('bet_events_draw'); ?></th>
							<th class="pn w80"><?php echo lang('bet_events_away'); ?></th>
							<th class="pn w100"><?php echo lang('bet_events_all_bets'); ?></th>


						</tr>
					</thead>				
				
					<tbody>
						
						<?php 
						
							$records = $this->bet_events_model->get_live_events_by_league($league->league_id);
							
							if (isset($records) && is_array($records) && count($records)) :

							foreach ($records as $record) :
						
						?>

						<tr>		


							<td class="text-blue text-right">
								<?php e($record->home_team); ?>
							</td>
							<td class="w30 pn text-right">
								<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($record->home_team,$record->league_id)); ?>"/>
							</td>
							<td class="w20 pn">
								<span class="text-black mh5">-</span>
							</td>	
							<td class="w30 pn text-left">	
								<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name(trim($record->away_team),$record->league_id)); ?>"/>
							</td>
							<td class="text-blue text-left">		
								<?php e($record->away_team); ?>	
							</td>
							<td class="w100"><?php echo date('H:i T', strtotime($record->match_time)); ?></td>
							
							<td class="w50 pn"><?php $home_odds = $this->bet_events_model->get_home_odds($record->match_id);?>
								<?php if ($home_odds): ?>
									<span class="text-blue">									
										<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
											<?php $bet_id = $this->bet_events_model->get_home_bet_id($record->match_id);?>	
											<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
											<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
											<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
											<?php $choice_id = $this->bet_events_model->get_home_choice_id($record->match_id);?>
											<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
											<input type="hidden" name="choice_name" id="choice_name" value="<?php echo $record->home_team;?>">
											<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
											<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
											<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
											<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
											<input type="hidden" name="odds" id="odds" value="<?php echo $home_odds;?>">
											<input type="submit" class="text-blue" value="<?php printf("%.2f", $home_odds); ?>">
										<?php echo form_close();?>
									</span>
								<?php endif;?>
							</td>
							<td class="w50 pn"><?php $draw_odds = $this->bet_events_model->get_draw_odds($record->match_id);?>
								<?php if ($draw_odds): ?>
									<span class="text-blue">
										<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
										<?php $bet_id = $this->bet_events_model->get_draw_bet_id($record->match_id);?>
											<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
											<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
											<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
											<?php $choice_id = $this->bet_events_model->get_draw_choice_id($record->match_id);?>
											<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
											<input type="hidden" name="choice_name" id="choice_name" value="Draw">
											<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
											<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
											<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
											<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
											<input type="hidden" name="odds" id="odds" value="<?php echo $draw_odds;?>">
											<input type="submit" class="text-red" value="<?php printf("%.2f", $draw_odds); ?>">
										<?php echo form_close();?>
									</span>
								<?php endif;?>
							</td>
							<td class="w50 pn"><?php $away_odds = $this->bet_events_model->get_away_odds($record->match_id);?>
								<?php if ($away_odds): ?>
									<span class="text-blue">
										<?php echo form_open(base_url('tips/custom_bet') . '/' . $record->match_id, 'id="bet" class="form-horizontal"'); ?>										
										<?php $bet_id = $this->bet_events_model->get_away_bet_id($record->match_id);?>
											<input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_id;?>">
											<?php $bet_name = $this->bet_events_model->get_bet_name_by_id($bet_id,$record->match_id);?>
											<input type="hidden" name="bet_name" id="bet_name" value="<?php echo $bet_name;?>">
											<?php $choice_id = $this->bet_events_model->get_away_choice_id($record->match_id);?>
											<input type="hidden" name="choice_id" id="choice_id" value="<?php echo $choice_id;?>">
											<input type="hidden" name="choice_name" id="choice_name" value="<?php echo $record->away_team;?>">
											<input type="hidden" name="match_id" id="match_id" value="<?php echo $record->match_id; ?>">
											<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
											<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
											<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">
											<input type="hidden" name="odds" id="odds" value="<?php echo $away_odds;?>">
											<input type="submit" class="text-blue" value="<?php printf("%.2f", $away_odds); ?>">
										<?php echo form_close();?>
									</span>
								<?php endif;?>
							</td>							
							<?php if ($home_odds && $away_odds) :?>
							<td class="w100 pn">
								<?php echo form_open(base_url('tips/insert_bet') . '/' . $record->match_id, 'class="form-horizontal"'); ?>	
								<input type="hidden" name="match_time" id="match_time" value="<?php echo $record->match_time; ?>">
								<input type="hidden" name="home_team" id="home_team" value="<?php echo $record->home_team; ?>">
								<input type="hidden" name="away_team" id="away_team" value="<?php echo $record->away_team; ?>">						
								<input type="submit" class="btn btn-green" value="<?php echo lang('bet_events_all_bets'); ?>">
								<?php echo form_close();?>
							</td>
							<?php endif;?>


						</tr>
							<?php endforeach; endif;?>
					</tbody>
				</table>
				
				<?php endforeach; ?>
						
				<?php else:?>
					<table id="events_table" class="table table-striped" role="grid">
						<tr class="">
						     <td colspan="10" class="text-left text-red pl50"><?php echo lang('bet_events_no_events'); ?></td>
						</tr>
					</table>	
				<?php endif;?>						


			</div>		
		</div><!-- /.box-body -->
		
	</div>
	
<script type="text/javascript">
  // Define site_url variable for use in the js file
  var site_url = "<?php echo site_url(); ?>";
</script>