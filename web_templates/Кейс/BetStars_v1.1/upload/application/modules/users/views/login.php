<?php
	$site_open = $this->settings_lib->item('auth.allow_register');
?>

	<div class="col-md-6 col-md-push-3">
		<div class="box mb20">
			<div class="box-body">										
				<h4 class="head-left"><?php echo lang('us_login'); ?></h4>	
				<div class="divider-4"></div>

				<?php echo Template::message(); ?>

				<?php if (validation_errors()) :?>

					<div class="alert alert-error fade in">
					  <a data-dismiss="alert" class="close">&times;</a>
						<?php echo validation_errors(); ?>
					</div>

				<?php endif; ?>

				<?php echo form_open(LOGIN_URL, array('autocomplete' => 'off', 'id' => 'login_form', 'class' =>'form-horizontal')); ?>

					<div class="form-group <?php echo iif( form_error('username') , 'has-error') ;?>">
						<label class="control-label col-sm-4 required" for="username"><?php echo lang('bf_username'); ?></label>
						<div class="col-sm-6">
							<input type="text" name="username" id="username" class="form-control" value="<?php echo set_value('login'); ?>" tabindex="1" placeholder="<?php echo lang('bf_username'); ?>" />
						</div>
					</div>


					<div class="form-group <?php echo iif( form_error('password') , 'has-error') ;?>">
						<label class="control-label col-sm-4 required" for="password"><?php echo lang('bf_password'); ?></label>
						<div class="col-sm-6">
							<input type="password" name="password" id="password" class="form-control" placeholder="<?php echo lang('bf_password'); ?>">
						</div>
					</div>

					<?php if ($this->settings_lib->item('auth.allow_remember')) : ?>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-6">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember_me" id="remember_me" value="1" tabindex="3" />
										<span class="inline-help"><?php echo lang('us_remember_note'); ?></span>
									</label>	
								</div>
							</div>
						</div>
					<?php endif ;?>
					
					<div class="form-group">
						<div class="col-sm-6 col-sm-push-4">
							<input class="btn btn-blue btn-block" type="submit" name="log-me-in" value="<?php e(lang('us_let_me_in')); ?>"  />
						</div>
					</div>

                <?php echo form_close(); ?>
					
				<?php // show for Email Activation (1) only
				if ($this->settings_lib->item('auth.user_activation_method') == 1) : ?>
					<!-- Activation Block -->
					<p style="text-align: left" class="well">
						<?php echo lang('bf_login_activate_title'); ?><br />
						<?php
						$activate_str = str_replace('[ACCOUNT_ACTIVATE_URL]',anchor('/activate', lang('bf_activate')),lang('bf_login_activate_email'));
						$activate_str = str_replace('[ACTIVATE_RESEND_URL]',anchor('/resend_activation', lang('bf_activate_resend')),$activate_str);
						echo $activate_str; ?>
					</p>
				<?php endif; ?>

				<p style="text-align: center">
					<?php if ( $site_open ) : ?>
						<?php echo anchor(REGISTER_URL, lang('us_sign_up')); ?>
					<?php endif; ?>

					<br/><?php echo anchor('/forgot_password', lang('us_forgot_your_password')); ?>
				</p>
	
	
	
            </div>
        </div>
    </div>
	
	<script type="text/javascript">
	
		// Define site_url variable for use in the js file
		var site_url = "<?php echo site_url(); ?>";
		// Define error messages for jquery validation

		var req_user = '<?php echo lang('us_required_user');?>'
		var req_pass = '<?php echo lang('us_required_pass');?>'

	</script>	