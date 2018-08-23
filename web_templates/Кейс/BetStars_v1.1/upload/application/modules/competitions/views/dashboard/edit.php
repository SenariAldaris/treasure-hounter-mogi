<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('competitions_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($competitions->id) ? $competitions->id : '';

$min_tips = $this->competitions_model->get_competition_min_tips($id);

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



?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/competitions/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/competitions" id="list"><?php echo lang('bf_list'); ?></a>
					 <a class="btn btn-xs btn-grey" href="<?php echo site_url();?>admin/dashboard/rewards/index/competition_id-<?php echo $id;?>"><?php echo lang('competitions_field_rewards'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">

			<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
				<div class="row">
					<div class="col-md-6">		

						<div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_name') . lang('bf_form_label_required'), 'name', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-8'>
								<input id='name' class="form-control" type='text' required='required' name='name' maxlength='30' value="<?php echo set_value('name', isset($competitions->name) ? $competitions->name : ''); ?>" />
								<span class='help-block'><?php echo form_error('name'); ?></span>
							</div>
						</div>

						<div class="form-group<?php echo form_error('sport_id') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_sport'), 'sport', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-8'>
								<input id='sport_id' class="form-control" type='text' required='required' name='sport_id' maxlength='30' value="<?php echo $this->sports_model->get_sport_name_by_id($competitions->sport_id);?>" disabled />
								<span class='help-block'><?php echo form_error('sport_id'); ?></span>
							</div>
						</div>


						<div class="league">
							<div class="form-group<?php echo form_error('league_id') ? ' has-error' : ''; ?>">
								<label class="col-sm-4 control-label"><?php echo lang('competitions_field_league');?></label>
								<div class="col-sm-8">
									<input id='league_id' class="form-control" type='text' required='required' name='league_id' maxlength='30' value="<?php echo $this->leagues_model->get_league_name_by_id($competitions->league_id);?>" disabled />
									<span class='help-block'><?php echo form_error('league_id'); ?></span>
								</div>
							</div>
						</div>

						<?php $options = array('1'=> 'Month','2'=>'Year','3'=> 'Other');

							echo form_dropdown_custom2( 'type', $options, set_value('type', isset($competitions->type) ? $competitions->type : ''), lang('competitions_field_type'). lang('bf_form_label_required'), 'class="form-control"');
						?>	
						
						<div class="form-group<?php echo form_error('description') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_description') . lang('bf_form_label_required'), 'description', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-8'>
								<?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => 'form-control', 'value' => set_value('description', isset($competitions->description) ? $competitions->description : ''), 'required' => 'required')); ?>
								<span class='help-block'><?php echo form_error('description'); ?></span>
							</div>
						</div>

						<div class="form-group<?php echo form_error('start_date') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_start_date') . lang('bf_form_label_required'), 'start_date', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-8'>
								<input id='start_date' class="form-control" type='text' required='required' name='start_date'  value="<?php echo set_value('start_date', isset($competitions->start_date) ? $competitions->start_date : ''); ?>" />
								<span class='help-block'><?php echo form_error('start_date'); ?></span>
							</div>
						</div>

						<div class="form-group<?php echo form_error('end_date') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_end_date') . lang('bf_form_label_required'), 'end_date', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-8'>
								<input id='end_date' class="form-control" type='text' required='required' name='end_date'  value="<?php echo set_value('end_date', isset($competitions->end_date) ? $competitions->end_date : ''); ?>" />
								<span class='help-block'><?php echo form_error('end_date'); ?></span>
							</div>
						</div>

						<div class="form-group<?php echo form_error('min_tips') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_min_tips') . lang('bf_form_label_required'), 'min_tips', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-8'>
								<input id='min_tips' class="form-control" type='text' required='required' name='min_tips' maxlength='30' value="<?php echo set_value('min_tips', isset($competitions->min_tips) ? $competitions->min_tips : ''); ?>" />
								<span class='help-block'><?php echo form_error('min_tips'); ?></span>
							</div>
						</div>


					</div>
					
					<div class='col-md-6'>
					
						<?php $place =1;?>
						<h4><?php echo lang('competitions_ranking');?></h4>
						<div class="divider-4 mtn mbn"></div>
						<div class="scroll">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="w20">#</th>
									<th>Tipster</th>
									<th>Profit</th>
									<th>Yield</th>
									<th>Reward</th>

								</tr>
							</thead>								
							<tbody>
							<?php if (isset($rankings) && is_array($rankings) && count($rankings)) : 

								 foreach ($rankings as $record) : 	?>
								
								<tr>								
								<?php $t_tips = $this->competitions_model->count_tipster_tips_by_period($record->id,$start,$end);?>

								<?php if($t_tips >= $min_tips):?>
								<td class="w20"><?php $a = $place++; echo $a;?></td>
								<?php else : ?>
								<td class="w20"><?php $a = 0;?> - </td>
								<?php endif; ?>

								
								<td class="text-left"><a href="#">
									<?php echo $record->display_name; ?>
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
										<span class="text-blue fs16">
										
											<?php if ($prise):
  											echo $prise;?> <span class="ml5"><?php echo $competitions->currency;?></span>
											
											<?php else:?> / <?php endif; ?>	
											
										</span>
									</td>	
									<?php else : ?>	
										<td><?php echo lang('competitions_to_little_tips'); ?></td>
									<?php endif; ?>	

							<?php endforeach; ?>	
						
							<tr>
							<?php endif; ?>	
						</tbody>
					</table>								
					</div>			
								
								
								
								
								<div class="divider-4"></div>

											<?php 
							$data = array(
								'name' => 'active',
								'class' => 'form-control',
							);
							$options = array(
								'1' => lang('bf_active'),
								'0' => lang('bf_inactive'),
							);

							echo form_dropdown_custom2( $data, $options, set_value('active', isset($competitions->active) ? $competitions->active : ''), lang('competitions_field_active'). lang('bf_form_label_required'));
						?>
						<div class="form-group<?php echo form_error('price_pool') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_price_pool') . lang('bf_form_label_required'), 'price_pool', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-7'>
								<input id='price_pool' class="form-control" type='text' required='required' name='price_pool' maxlength='5' value="<?php echo set_value('price_pool', isset($competitions->price_pool) ? $competitions->price_pool : ''); ?>" />
								<span class='help-block'><?php echo form_error('price_pool'); ?></span>
							</div>
						</div>
						
						<div class="form-group<?php echo form_error('currency') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_currency') . lang('bf_form_label_required'), 'currency', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-7'>
								<input id='currency' class="form-control" type='text' required='required' name='currency' maxlength='100' value="<?php echo set_value('currency', isset($competitions->currency) ? $competitions->currency : ''); ?>" />
								<span class='help-block'><?php echo form_error('currency'); ?></span>
							</div>
						</div>						

						<div class="form-group<?php echo form_error('rewards') ? ' error' : ''; ?>">
							<?php echo form_label(lang('competitions_field_rewards') . lang('bf_form_label_required'), 'rewards', array('class' => 'control-label col-sm-4')); ?>
							<div class='col-sm-7'>
								<input id='rewards' name="rewards" type='hidden' value="<?php echo $competitions->rewards;?>"/>
								<input id='rewards' class="form-control" type='text' value="<?php echo set_value('rewards', isset($competitions->rewards) ? $competitions->rewards : ''); ?>" disabled />
								<span class='help-block'><?php echo form_error('rewards'); ?></span>
							</div>
						</div>

						<?php $options = $bookmakers;

							echo form_dropdown_custom2( 'sponsored_by', $options, set_value('sponsored_by', isset($competitions->sponsored_by) ? $competitions->sponsored_by : ''), lang('competitions_field_sponsored_by'). lang('bf_form_label_required'), 'class="form-control"');
						?>					
						
						<?php $winner = $this->competitions_model->competition_winner($start,$end);
						
						
								if(!$sport == 0)
								{	
									// IF competition is for specific sport 
									$winner = $this->competitions_model->where('tips.sport_id',$sport)->competition_winner($start,$end);
								}

								if(!$league == 0)
								{
									// IF competition is for specific league 
									$winner = $this->competitions_model->where('tips.league_id',$league)->competition_winner($start,$end);
								}
						
								$tipster = $this->tipsters_model->get_user_display_name_by_id($winner);?>
						
						<div class="form-group">
							<?php if(!$competitions->active) {
							echo form_label(lang('competitions_field_winner') . lang('bf_form_label_required'), 'winner', array('class' => 'control-label col-sm-4'));
							} else {
							echo form_label(lang('competitions_field_best_ranked') . lang('bf_form_label_required'), 'winner', array('class' => 'control-label col-sm-4')); }?>
							<div class='col-sm-7'>
							<?php if($winner) {?>
								<input id='winner' class="form-control" type='hidden' name='winner' value="<?php echo $winner; ?>" />
							<?php } else {?>
								<input id='winner' class="form-control" type='hidden' name='winner' value="0" />
							<?php } ?>
							
							<input class="form-control" type='text' value="<?php echo $tipster; ?>" disabled />
							</div>
						</div>
						
						
						
						
					
						
					</div>
					
					
				</div>	
				<!-- /row -->
				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('competitions_action_edit'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/competitions', lang('competitions_cancel'), 'class="btn btn-warning"'); ?>
					
					<?php if ($this->auth->has_permission('Competitions.Dashboard.Delete')) : ?>
						<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('competitions_delete_confirm'))); ?>');">
							<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('competitions_delete_record'); ?>
						</button>
					<?php endif; ?>
				</div>
					

			<?php echo form_close(); ?>	
		</div>	
	</div>
	
<script type="text/javascript">
	var site_url = '<?php echo site_url();?>';
</script>		