<?php

$errorClass   = empty($errorClass) ? ' has-error' : $errorClass;
$controlClass = empty($controlClass) ? 'form-control' : $controlClass;
$fieldData = array(
    'errorClass'   => $errorClass,
    'controlClass' => $controlClass,
);

if (isset($password_hints)) {
    $fieldData['password_hints'] = $password_hints;
}

// In order for $renderPayload to be set properly, the order of the isset() checks
// for $current_user, $user, and $this->auth should be maintained. An if/elseif
// structure could be used for $renderPayload, but the separate if statements would
// still be needed to set $fieldData properly.
$renderPayload = null;
if (isset($current_user)) {
    $fieldData['current_user'] = $current_user;
    $renderPayload = $current_user;
}
if (isset($user)) {
    $fieldData['user'] = $user;
    $renderPayload = $user;
}
if (empty($renderPayload) && isset($this->auth)) {
    $renderPayload = $this->auth->user();
}

?>
	<div class="box box-info">
		<div class="box-header with-border">
		    <h3 class="box-title"><?php echo lang('us_user_info');?></h3>
		</div><!-- /.box-header -->


		<div class="box-body">
			<?php if (validation_errors()) : ?>
			<div class="alert alert-error">
				<?php echo validation_errors(); ?>
			</div>
			<?php endif;
			if (isset($user) && $user->role_name == 'Banned') : ?>
			<div data-dismiss="alert" class="alert alert-error">
				<?php echo lang('us_banned_admin_note'); ?>
			</div>
			<?php endif; ?>
			<div class="alert alert-info">
				<?php
				if (isset($password_hints)) {
					echo $password_hints;
				} ?>
			</div>
			
			<?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
			   
					<?php Template::block('user_fields', 'user_fields', $fieldData); ?>
				
					<?php
					// Allow modules to render custom fields
					Events::trigger('render_user_form', $renderPayload);
					?>

				
			<div class="box-footer">
                <input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_user'); ?>" />
				<?php echo anchor('/', lang('bf_action_cancel'),'class="btn btn-warning"'); ?>
            </div>	

			<?php echo form_close(); ?>
			
		</div>	
	</div>			