    
<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('bet_events_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($bet_events->id) ? $bet_events->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/bet_events/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/bet_events" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
				  
			<div class="box-body">

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo lang('bet_events_sport');?></label>
					<div class="col-md-3">
						<input type="hidden" name="sport_id" value="<?php echo $bet_events->sport_id;?>">
						<input type="text" class="form-control" name="sport_id" id="sport_id" placeholder="<?php echo $this->sports_model->get_sport_name_by_id($bet_events->sport_id);?>" disabled />
					</div>
				</div>
				

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo lang('bet_events_league');?></label>
					<div class="col-md-3">
						<input type="hidden" name="league_id" value="<?php echo $bet_events->league_id;?>">
						<input type="text" class="form-control" name="league_id" id="league_id" 
						placeholder="<?php echo $this->leagues_model->get_league_name_by_id($bet_events->league_id);?>" disabled />
					</div>
				</div>

				
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo lang('bet_events_match');?></label>
					<div class="col-md-6">
						<input type="hidden" name="match_id" value="<?php echo $bet_events->match_id;?>">
						<input type="text" class="form-control" placeholder="<?php echo $bet_events->home_team;?> - <?php echo $bet_events->away_team;?>" disabled />
					</div>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('bet_events_match_date') , 'match_date', array('class' => 'col-md-2 control-label')); ?>
					<div class="col-md-3">
						<input type="hidden" name="match_date" value="<?php echo $bet_events->match_date;?>">
						<input class="form-control" type='text' value="<?php echo date('M d Y', strtotime($bet_events->match_date)); ?>" disabled />
					</div>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('bet_events_match_time') , 'match_time', array('class' => 'col-md-2 control-label')); ?>
					<div class="col-md-3">
						<input type="hidden" name="match_time" value="<?php echo $bet_events->match_time;?>">
						<input class="form-control" type="text" value="<?php echo date('H:i', strtotime($bet_events->match_time)); ?>" disabled />
					</div>
				</div>
				
				<?php 
					$data = array(
						'name' => 'featured',
						'class' => 'form-control',
					);
					$options = array(
						'1' => lang('bf_yes'),
						'0' => lang('bf_no'),
					);

					echo form_dropdown_custom( $data, $options, set_value('featured', isset($bet_events->featured) ? $bet_events->featured : ''), lang('bet_events_featured'));
				?>

			</div>
			
			<div class="box-footer">
				<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('bet_events_action_edit'); ?>" />
				<?php echo anchor(SITE_AREA . '/dashboard/bet_events', lang('bet_events_cancel'), 'class="btn btn-yellow"'); ?>
			</div>

			
		<?php echo form_close(); ?>
	</div><!-- /.box -->
 