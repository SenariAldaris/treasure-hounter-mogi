	<div class="col-md-6 col-md-push-3">
		<div class="box mb20">
			<div class="box-body">										
				<h4 class="head-left"><?php echo lang('us_reset_password_note'); ?></h4>	
				<div class="divider-4"></div>
				
				<?php echo Template::message(); ?>

				<?php if (validation_errors()) : ?>
					<div class="alert alert-error fade in">
						<?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>


				<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

					<input type="hidden" name="user_id" value="<?php echo $user->id ?>" />

					<div class="form-group <?php echo iif( form_error('password') , 'has-error') ;?>">
						<label class="control-label col-sm-4" for="password"><?php echo lang('bf_password'); ?></label>
						<div class="col-sm-6">
							<input class="form-control" type="password" name="password" id="password" value="" placeholder="Password...." />
							<p class="help-block"><?php echo lang('us_password_mins'); ?></p>
						</div>
					</div>

					<div class="form-group <?php echo iif( form_error('pass_confirm') , 'has-error') ;?>">
						<label class="control-label col-sm-4" for="pass_confirm"><?php echo lang('bf_password_confirm'); ?></label>
						<div class="col-sm-6">
							<input class="form-control" type="password" name="pass_confirm" id="pass_confirm" value="" placeholder="<?php echo lang('bf_password_confirm'); ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-6 col-sm-push-4">
							<input class="btn btn-blue btn-block" type="submit" name="set_password" id="submit" value="<?php e(lang('us_set_password')); ?>"  />
						</div>
					</div>

				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
