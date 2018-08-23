<?php
	$tips_open = $this->settings_lib->item('tips.allow_post');


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
$country_id = $this->leagues_model->get_league_country_by_id($league_id);
$league_name = $this->leagues_model->get_league_name_by_id($league_id);

?>


	<div class="box">
		<div class="box-body">					
					
			<p class="text-center"><h4><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?>
				<span class="pull-right fs12"><?php echo lang('tips_action_before_post');?>
				<button type="button" class="btn btn-blue ml20" data-toggle="modal" data-target="#TipsRules">
					<?php echo lang('tips_action_read_rules');?>
				</button></span>
			</h4></p>
			<div class="divider-4"></div>
			
			<?php if ( $tips_open ) { ?>

				<?php echo form_open($this->uri->uri_string(), 'id="form" class="form-horisontal"'); ?>
				
					<?php if (isset($current_user->id)) : ?>
					  <input id="created_by" type="hidden" name="created_by" maxlength="30" value="<?php echo $current_user->id; ?>" />
					<?php endif; ?>
					
					<input id="created_on" type="hidden" name="created_on"  value="<?php echo date('Y-m-d H:i:s'); ?>" />
					
					<input type="hidden" id="sport_id" name="sport_id" value="<?php echo $sport_id; ?>"/>
					<input type="hidden" id="league_id" name="league_id" value="<?php echo $league_id; ?>"/>
					<input type="hidden" id="match_id" name="match_id" value="<?php echo $match_id; ?>"/>
					<input type="hidden" id="match_date" name="match_date" value="<?php echo $match_date; ?>"/>
					<input type="hidden" id="bet_id" name="bet_id" value="<?php echo $bet_id; ?>"/>
					<input type="hidden" id="bet_name" name="bet_name" value="<?php echo $bet_name; ?>"/>
					<input type="hidden" id="choice_id" name="choice_id" value="<?php echo $choice_id; ?>"/>
					<input type="hidden" id="choice_name" name="choice_name" value="<?php echo $choice_name; ?>"/>
					<input type="hidden" id="odds" name="odds" value="<?php echo $odds; ?>"/>

					<div class="form-group text-center">
					
						<img class="h30 mtm4" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($sport_id)); ?>"/>
						<img class="h30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
						
						<span class="text-blue fs14 mr20"><?php e(strtoupper($league_name)); ?></span>
						<span class="fs14 mr20"><?php echo date('M d,Y', strtotime($match_date)); ?></span>
					</div>	
						


					<div class="divider-4"></div>
					
					<!-- Start Row -->
					<div class="row">
				
						<div class="form-group">
							<div class="col-sm-4">
								<span class="fs16 text-blue mr10"><?php echo lang('tips_bet_type');?></span>
								<span class="fs14"><?php echo $bet_name; ?></span>
							</div>
							<div class="col-sm-5">
								<span class="fs16 text-blue mr10"><?php echo lang('tips_bet_choice');?></span>
								<img class="h30 mtm4 mr5" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($choice_name,$league_id)); ?>"/>
								<span class="fs14"><?php echo $choice_name; ?></span>
							</div>
							<div class="col-sm-3">
								<span class="fs16 text-blue mr10"><?php echo lang('tips_odds');?></span>
								<span class="fs18"><?php echo $odds; ?></span>
							</div>								
						</div>	
					</div>
					<!-- End Row -->
					<div class="divider-4"></div>
	

					<!-- Start Row -->
					<div class="row">

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
	var match_id = "<?php echo $this->uri->segment(3); ?>";
	// Define error messages for jquery validation

	var description_forgot = '<?php echo lang('tips_desc_forgot');?>'
	var description_req = '<?php echo lang('tips_min_words');?>'

</script>

