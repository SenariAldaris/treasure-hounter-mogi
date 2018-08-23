<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('teams_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($teams->id) ? $teams->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/teams" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
			<div class="box-body">
				

				<div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
					<?php echo form_label(lang('teams_name') . lang('bf_form_label_required'), 'name', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input type="text"  class="form-control" placeholder="<?php echo $teams->name;?>" disabled />
						<input id='name' type='hidden' name='name' value="<?php echo $teams->name; ?>" />
						<span class='help-inline'><?php echo form_error('name'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('logo') ? ' error' : ''; ?>">
					<?php echo form_label(lang('teams_logo') . lang('bf_form_label_required'), 'logo', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-3">
						<input type="file" name="logo" id="file">
						<div class="dummyfile">
							<div class="input-append">
								<input id="filename" type="text" class="input form-control" name="file-name">
								<a id="fileselectbutton" class="btn btn-blue">Select</a>
							</div>
						</div>
						<span class='help-inline'><?php echo form_error('logo'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('teams_current_logo') , 'logo', array('class' => 'col-md-2 control-label') ); ?>
					<div class="col-sm-4">
						 <img src="<?php echo base_url();?>uploads/teams/<?php echo set_value('current_logo', isset($teams->logo) ? $teams->logo : ''); ?>" style="height:30px;"/>
						<input id="current_logo" type="hidden" name="current_logo" value="<?php echo set_value('current_logo', isset($teams->logo) ? $teams->logo : ''); ?>"/>				  
					</div>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('teams_league') , 'league_id', array('class' => 'col-md-2 control-label') ); ?>
					<div class="col-sm-4">
					    <?php $cur_league = $this->leagues_model->get_league_name_by_id($teams->league_id);?>
						<input type="text"  class="form-control" placeholder="<?php echo $cur_league;?>" disabled=""> 
						<input type="hidden" id="league_id" name="league_id" class="form-control" value="<?php echo set_value('league_id', isset($teams->league_id) ? $teams->league_id : ''); ?>" />			  
					</div>
				</div>
				

				

				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('teams_action_edit'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/teams', lang('teams_cancel'), 'class="btn btn-yellow"'); ?>
				</div>
			</div>	
		<?php echo form_close(); ?>
	</div>