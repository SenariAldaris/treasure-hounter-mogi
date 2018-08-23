<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('rewards_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($rewards->id) ? $rewards->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/rewards/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/rewards" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
      
            <div class="box-body"> 

				<?php $options =  $competitions;
					echo form_dropdown_custom('competition_id', $options, set_value('sport', isset($rewards->competition_id) ? $rewards->competition_id : ''), lang('rewards_field_competition'). lang('bf_form_label_required'),  'class="form-control"');
				?>
				
				<?php $places = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10');
				
				    $options =  $places;
					echo form_dropdown_custom('place', $options, set_value('place', isset($rewards->place) ? $rewards->place : ''), lang('rewards_field_place'). lang('bf_form_label_required'),  'class="form-control"');
				?>				


				<div class="form-group<?php echo form_error('reward') ? ' error' : ''; ?>">
					<?php echo form_label(lang('rewards_field_reward') . lang('bf_form_label_required'), 'reward', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='reward' class="form-control" type='text' required='required' name='reward' maxlength='11' value="<?php echo set_value('reward', isset($rewards->reward) ? $rewards->reward : ''); ?>" />
						<span class='help-inline'><?php echo form_error('reward'); ?></span>
					</div>
				</div>
				
			</div>
			
			<div class='box-footer'>
				<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('rewards_action_edit'); ?>" />
				<?php echo anchor(SITE_AREA . '/dashboard/rewards', lang('rewards_cancel'), 'class="btn btn-yellow"'); ?>
				
				<?php if ($this->auth->has_permission('Rewards.Dashboard.Delete')) : ?>
					<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('rewards_delete_confirm'))); ?>');">
						<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('rewards_delete_record'); ?>
					</button>
				<?php endif; ?>
			</div>
		<?php echo form_close(); ?>
	</div>