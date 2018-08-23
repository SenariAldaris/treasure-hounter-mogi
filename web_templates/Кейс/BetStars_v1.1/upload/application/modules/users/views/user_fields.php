<?php /* /users/views/user_fields.php */

$currentMethod = $this->router->fetch_method();

$errorClass     = empty($errorClass) ? ' has-error' : $errorClass;
$controlClass   = empty($controlClass) ? 'form-control' : $controlClass;
$registerClass  = $currentMethod == 'register' ? ' required' : '';
$editSettings   = $currentMethod == 'edit';
$createSettings   = $currentMethod == 'create';
$editProfile   = $currentMethod == 'edit_profile';

$defaultCountry = 'US';

?>


<?php if ($registerClass): ?>


	<div class="form-group<?php echo form_error('email') ? $errorClass : ''; ?>">
		<label class="control-label col-sm-4 required" for="email"><?php echo lang('bf_email'); ?></label>
		<div class="col-sm-7">
			<input class="<?php echo $controlClass; ?>" type="text" id="email" name="email" value="<?php echo set_value('email', isset($user) ? $user->email : ''); ?>" />
			<span class="help-block"><?php echo form_error('email'); ?></span>
		</div>
	</div>

	<div class="form-group<?php echo form_error('display_name') ? $errorClass : ''; ?>">
		<label class="control-label col-sm-4 <?php echo $registerClass; ?>" for="display_name"><?php echo lang('bf_display_name'); ?></label>
		<div class="col-sm-7">
			<input class="<?php echo $controlClass; ?>" type="text" id="display_name" name="display_name" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : ''); ?>" />
			<span class="help-block"><?php echo form_error('display_name'); ?></span>
		</div>
	</div>

	<div class="form-group<?php echo form_error('username') ? $errorClass : ''; ?>">
		<label class="control-label col-sm-4 <?php echo $registerClass; ?>" for="username"><?php echo lang('bf_username'); ?></label>
		<div class="col-sm-7">
			<input class="<?php echo $controlClass; ?>" type="text" id="username" name="username" value="<?php echo set_value('username', isset($user) ? $user->username : ''); ?>" />
			<span class="help-block"><?php echo form_error('username'); ?></span>
		</div>
	</div>

	<div class="form-group<?php echo form_error('password') ? $errorClass : ''; ?>">
		<label class="control-label col-sm-4 <?php echo $registerClass; ?>" for="password"><?php echo lang('bf_password'); ?></label>
		<div class="col-sm-7">
			<input class="<?php echo $controlClass; ?>" type="password" id="password" name="password" value="" />
			<span class="help-block"><?php echo form_error('password'); ?></span>
		 
		</div>
	</div>
	
	<div class="form-group<?php echo form_error('pass_confirm') ? $errorClass : ''; ?>">
		<label class="control-label col-sm-4 <?php echo $registerClass; ?>" for="pass_confirm"><?php echo lang('bf_password_confirm'); ?></label>
		<div class="col-sm-7">
			<input class="<?php echo $controlClass; ?>" type="password" id="pass_confirm" name="pass_confirm" value="" />
			<span class="help-block"><?php echo form_error('pass_confirm'); ?></span>
		</div>
	</div>
	

		<?php $options =  array('' => 'Select Country', 'Countries' => $countries);
			echo form_dropdown_custom2('country', $options, set_value('country', isset($user->country) ? $user->country : ''), lang('us_country'). lang('bf_form_label_required'),  'class="form-control"');
		?>
		
	
<?php endif; ?>			
		
		
		
<?php if ($editProfile || $editSettings || $createSettings): ?>	
<div class="row">
	<div class="col-md-6">

		<div class="form-group">
			<div class="col-sm-6 col-sm-push-4">
				<h4><?php echo lang('us_account_details'); ?></h4>
			</div>
		</div>
		
		<div class="form-group<?php echo form_error('email') ? $errorClass : ''; ?>">
			<label class="control-label col-sm-4 required" for="email"><?php echo lang('bf_email'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="email" name="email" value="<?php echo set_value('email', isset($user) ? $user->email : ''); ?>" />
				<span class="help-block"><?php echo form_error('email'); ?></span>
			</div>
		</div>

		<?php if ($editProfile || $editSettings ): ?>			
		<div class="form-group<?php echo form_error('display_name') ? $errorClass : ''; ?>">
			<label class="control-label col-sm-4" for="display_name"><?php echo lang('bf_display_name'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="display_name" name="display_name" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : ''); ?>" disabled />
				<input class="<?php echo $controlClass; ?>" type="hidden" id="display_name" name="display_name" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : ''); ?>" />
				<span class="help-block"><?php echo form_error('display_name'); ?></span>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if ($createSettings ): ?>			
		<div class="form-group<?php echo form_error('display_name') ? $errorClass : ''; ?>">
			<label class="control-label col-sm-4" for="display_name"><?php echo lang('bf_display_name'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="display_name" name="display_name" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : ''); ?>"/>

				<span class="help-block"><?php echo form_error('display_name'); ?></span>
			</div>
		</div>
		<?php endif; ?>		
		
		<div class="form-group<?php echo form_error('username') ? $errorClass : ''; ?>">
			<label class="control-label col-sm-4 <?php echo $registerClass; ?>" for="username"><?php echo lang('bf_username'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="username" name="username" value="<?php echo set_value('username', isset($user) ? $user->username : ''); ?>" />
				<span class="help-block"><?php echo form_error('username'); ?></span>
			</div>
		</div>
		
		<?php if ($editProfile || $editSettings ): ?>
		<div class="form-group">
			<div class="col-sm-6 col-sm-push-4">

				<span class="help-block"><?php echo lang('us_leave_empty_pass'); ?></span>
			</div>
		</div>
		<?php endif; ?>	
		
		<div class="form-group<?php echo form_error('password') ? $errorClass : ''; ?>">
			<label class="control-label col-sm-4 <?php echo $registerClass; ?>" for="password"><?php echo lang('bf_password'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="password" autocomplete="OFF" id="password" name="password" value="" />
				<span class="help-block"><?php echo form_error('password'); ?></span>
			 
			</div>
		</div>
		<div class="form-group<?php echo form_error('pass_confirm') ? $errorClass : ''; ?>">
			<label class="control-label col-sm-4 <?php echo $registerClass; ?>" for="pass_confirm"><?php echo lang('bf_password_confirm'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="password" id="pass_confirm" name="pass_confirm" value="" />
				<span class="help-block"><?php echo form_error('pass_confirm'); ?></span>
			</div>
		</div>
		
		<div class="form-group<?php echo form_error('avatar') ? ' has-error' : ''; ?>">
			<?php echo form_label(lang('us_avatar'), 'avatar', array('class' => 'col-sm-4 control-label')); ?>
			<div class="col-sm-7">
				<input type="file" name="avatar" id="file">
				<div class="dummyfile">
					<div class="input-group input-group">
						<input id="filename" type="text" class="form-control" name="file-name">
						<span class="input-group-btn">
						  <button id="fileselectbutton" class="btn btn-blue" type="button"><?php echo lang('bf_action_select'); ?></button>
						</span>
					</div>
				</div>	
				<span class='help-block'><?php echo form_error('avatar'); ?></span>
			</div>
		</div>

		<div class="form-group">
		<?php echo form_label(lang('us_current_avatar') , 'avatar', array('class' => 'col-md-4 control-label') ); ?>
			<div class="col-sm-8">
				 <img src="<?php echo base_url();?>uploads/tipsters/<?php echo set_value('current_avatar', isset($user) ? $user->avatar : 'avatar.jpg'); ?>" style="height:30px;"/>
				<input id="current_avatar" type="hidden" name="current_avatar" value="<?php echo set_value('current_avatar', isset($user) ? $user->avatar : ''); ?>"/>				  
			</div>
		</div>

	</div><!-- col -->
	
	<div class="col-md-6"><!-- col -->

	
		<div class="form-group">
			<div class="col-sm-6 col-sm-push-4">
				<h4><?php echo lang('us_personal_details'); ?></h4>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-4" for="first_name"><?php echo lang('us_first_name'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name', isset($user) ? $user->first_name : ''); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="last_name"><?php echo lang('us_last_name'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="last_name" name="last_name" value="<?php echo set_value('last_name', isset($user) ? $user->last_name : ''); ?>" />
			</div>
		</div>	

		<?php $options =  $countries;
			echo form_dropdown_custom2('country', $options, set_value('country', isset($user->country) ? $user->country : ''), lang('us_country'). lang('bf_form_label_required'),  'class="form-control"');
		?>

		<div class="form-group">
			<label class="control-label col-sm-4" for="about_me"><?php echo lang('us_about_me'); ?></label>
			<div class="col-sm-7">
				<textarea class="<?php echo $controlClass; ?>" id="about_me" name="about_me" style="height: 150px; padding: 10px;">
					<?php echo set_value('about_me', isset($user) ? $user->about_me : ''); ?>
				</textarea>
			</div>
		</div>	
		
		<div class="form-group">
			<div class="col-sm-6 col-sm-push-4">
				<h4><?php echo lang('us_payment_options'); ?></h4>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-4" for="paypal_account"><?php echo lang('us_paypal_account'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="paypal_account" name="paypal_account" value="<?php echo set_value('paypal_account', isset($user) ? $user->paypal_account : ''); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="skrill_account"><?php echo lang('us_skrill_account'); ?></label>
			<div class="col-sm-7">
				<input class="<?php echo $controlClass; ?>" type="text" id="skrill_account" name="skrill_account" value="<?php echo set_value('skrill_account', isset($user) ? $user->skrill_account : ''); ?>" />
			</div>
		</div>
		
		
	</div><!-- col -->
</div><!-- row -->		

	<?php endif; ?>		

	<?php if ($editSettings) : ?>

	<div class="form-group<?php echo form_error('force_password_reset') ? $errorClass : ''; ?>">
		<label class="control-label col-sm-2" for="force_password_reset"><?php echo lang('us_pass_reset'); ?></label>
		<div class="col-sm-7">
			<label class="checkbox" for="force_password_reset">
				<input type="checkbox" id="force_password_reset" name="force_password_reset" value="1" <?php echo set_checkbox('force_password_reset', empty($user->force_password_reset)); ?> />
				<?php echo lang('us_force_password_reset'); ?>
			</label>
		</div>
	</div>

	<?php endif; ?>
		


	<script type="text/javascript">
	
		// Define site_url variable for use in the js file
		var site_url = "<?php echo site_url(); ?>";
		// Define error messages for jquery validation

		var req_user = '<?php echo lang('us_required_user');?>'
		var req_pass = '<?php echo lang('us_required_pass');?>'

	</script>	