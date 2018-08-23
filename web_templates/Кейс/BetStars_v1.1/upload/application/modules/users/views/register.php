<?php

$errorClass   = empty($errorClass) ? ' has-error' : $errorClass;
$controlClass = empty($controlClass) ? 'form-control' : $controlClass;
$fieldData = array(
    'errorClass'    => $errorClass,
    'controlClass'  => $controlClass,
);

?>
<style>
p.already-registered {
    text-align: center;
}
</style>

	<div class="col-md-6 col-md-push-3">
		<div class="box mb20">
			<div class="box-body">										
				<h4 class="head-left"><?php echo lang('us_sign_up'); ?></h4>	
				<div class="divider-4"></div>	

				<div class="alert alert-info fade in">
					<?php
					if (isset($password_hints)) {
						echo $password_hints;
					}
					?>
				</div>

				<?php echo form_open(site_url(REGISTER_URL), array('id' => 'form_register', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
					
					<?php Template::block('user_fields', 'user_fields', $fieldData); ?>
				
				
					<?php
					// Allow modules to render custom fields. No payload is passed
					// since the user has not been created, yet.
					Events::trigger('render_user_form');?>


					<div class="form-group">
						<div class="col-sm-6 col-sm-push-4">
							<input class="btn btn-blue btn-block" type="submit" name="register" id="submit" value="<?php echo lang('us_register'); ?>" />
						</div>
					</div>
				
				<?php echo form_close(); ?>
				<p class='already-registered'>
					<?php echo lang('us_already_registered'); ?>
					<?php echo anchor(LOGIN_URL, lang('bf_action_login')); ?>
				</p>
			</div>
		</div>
	</div>