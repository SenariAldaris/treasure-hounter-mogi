<div class="box">
	<div class="box-body">
		<span class="text-center"><?php echo lang('in_db_settings'); ?></span>
		<?php echo form_open('install/dbtest', array('autocomplete' => 'off', 'class' =>'form-horizontal')); ?>

		
				<div class="form-group">
					<?php echo form_label(lang('in_host') . lang('bf_form_label_required'), 'db_host', array('class' => 'control-label col-sm-3')); ?>
					<div class='col-sm-6'>
						<input type="text" name="db_host" class="form-control" value="<?php if(set_value('db_host')!='')echo set_value('db_host');else echo 'localhost';?>" />
					</div>
				</div>
				<div class="form-group">
					<?php echo form_label(lang('in_username') . lang('bf_form_label_required'), 'db_user', array('class' => 'control-label col-sm-3')); ?>
					<div class='col-sm-6'>
						<input type="text" name="db_user" class="form-control" value="<?php if(set_value('db_user')!='')echo set_value('db_user');else echo 'root';?>" />
					</div>
				</div>				
				<div class="form-group">
					<?php echo form_label(lang('in_password') . lang('bf_form_label_required'), 'db_pass', array('class' => 'control-label col-sm-3')); ?>
					<div class='col-sm-6'>
						<input type="text" name="db_pass" class="form-control" value="<?php if(set_value('db_pass')!='')echo set_value('db_pass');else echo '';?>" />
					</div>
				</div>		
				<div class="form-group">
					<?php echo form_label(lang('in_database') . lang('bf_form_label_required'), 'db_name', array('class' => 'control-label col-sm-3')); ?>
					<div class='col-sm-6'>
						<input type="text" name="db_name" class="form-control" value="<?php if(set_value('db_name')!='')echo set_value('db_name');else echo 'betstars';?>" />
					</div>
				</div>					
				<div class="form-group">
					<div class='col-sm-6 col-sm-push-3'>
						<button type="submit" class="btn btn-blue fr"><?php echo lang('in_check_db'); ?></button>
					</div>	
				</div>	
		<?php echo form_close(); ?>
		
	</div>
</div>			