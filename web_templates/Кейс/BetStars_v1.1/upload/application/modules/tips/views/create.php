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

?>


	<div class="box">
		<div class="box-body">					
					
			<p class="text-center"><h4><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?>
				<span class="pull-right fs12"><span class="hidden-xs"><?php echo lang('tips_action_before_post');?></span>
				<button type="button" class="btn btn-blue ml20" data-toggle="modal" data-target="#TipsRules">
					<?php echo lang('tips_action_read_rules');?>
				</button></span>
			</h4></p>
			<div class="divider-4"></div>
			
			<?php if ( $tips_open ) { ?>

				<?php echo form_open($this->uri->uri_string(), 'id="form" class="form-horizontal"'); ?>
				
					<?php if (isset($current_user->id)) : ?>
					  <input id="created_by" type="hidden" name="created_by" maxlength="30" value="<?php echo $current_user->id; ?>" />
					<?php endif; ?>
					
					<input id="created_on" type="hidden" name="created_on"  value="<?php echo date('Y-m-d H:i:s'); ?>" />
				
				
					<!-- Start Row -->
					<div class="row">
					
						<div class="col-sm-4">
							<div class="form-group<?php echo form_error('sport_id') ? ' has-error' : ''; ?>">
							
								<?php echo form_label(lang('tips_select_sport') . lang('bf_form_label_required'), 'sport_id', array('class' => 'control-label')); ?>
								<select name="sport_id" id="sport_id" class="form-control">
									<option value=""><?php echo lang('tips_select_sport');?></option>
									<?php foreach ($sports->result() as $row) {
										$sel = ($row->id==set_value('sport_id'))?'selected="selected"':'';
										?>
										<option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $row->name;?></option>
									<?php }?>
								</select>
								<span class='help-block'><?php echo form_error('sport_id'); ?></span>
							</div>
						</div>	

						<div class="league">
							<div class="col-sm-4">
								<div class="form-group<?php echo form_error('league_id') ? ' has-error' : ''; ?>">
									<label class="control-label"><?php echo lang('tips_select_league');?></label>
									<select name="league_id" id="league_id" class="form-control">
										<!-- Auto Populated -->	
									</select>
									<?php echo form_error('league_id');?>
								</div>
							</div>
						</div>

					</div>
					<!-- End Row -->
				

					<!-- Start Row -->
					<div class="row">


						<div class="match">
						<div class="col-sm-8">
								<div class="form-group<?php echo form_error('match_id') ? ' has-error' : ''; ?>">
									<?php echo form_label(lang('tips_select_event') . lang('bf_form_label_required'), 'match_id', array('class' => 'control-label')); ?>
									<select name="match_id" id="match_id" class="form-control">
										<!-- Auto Populated -->		
									</select>
									<?php echo form_error('match_id');?>
								</div>
							</div>
						</div>
						
						
					</div>
					<!-- End Row -->	

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
		// Define error messages for jquery validation

		var description_forgot = '<?php echo lang('tips_desc_forgot');?>'
		var description_req = '<?php echo lang('tips_min_words');?>'

	</script>