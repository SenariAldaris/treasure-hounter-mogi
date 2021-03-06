
	<div class="col-md-6 col-md-push-3">
		<div class="box mb20">
			<div class="box-body">										
				<h4 class="head-left"><?php echo lang('us_reset_password'); ?></h4>	
				<div class="divider-4"></div>
				
				<?php echo Template::message(); ?>
				
				<?php if (validation_errors()) : ?>
					<div class="alert alert-error fade in">
						<?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>

				<div class="alert alert-info fade in">
					<?php echo lang('us_reset_note'); ?>
				</div>


				<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>

					<div class="form-group <?php echo iif( form_error('email') , 'error'); ?>">
						<label class="control-label col-sm-4 required" for="email"><?php echo lang('bf_email'); ?></label>
						<div class="col-sm-6">
							<input class="form-control" type="text" name="email" id="email" value="<?php echo set_value('email') ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-6 col-sm-push-4">
							<input class="btn btn-blue btn-block" type="submit" name="send" value="<?php e(lang('us_send_password')); ?>" />
						</div>
					</div>

				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
