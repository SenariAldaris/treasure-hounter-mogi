
	<div class="col-md-6 col-md-push-3">
		<div class="box mb20">
			<div class="box-body">										
				<h4 class="head-left"><?php echo lang('us_activate'); ?></h4>	
				<div class="divider-4"></div>	
				
				<?php echo Template::message(); ?>
	
				<?php if (validation_errors()) { ?>

					<div class="alert alert-error fade in">
					  <a data-dismiss="alert" class="close">&times;</a>
						<?php echo validation_errors(); ?>
					</div>

				<?php } else { ?>

					<div class="well shallow-well">
						<?php echo lang('us_user_activate_note'); ?>
					</div>

				<?php } ?>

				<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>

				<div class="form-group <?php echo iif( form_error('code') , 'error') ;?>">
					<label class="control-label col-sm-3 required" for="code"><?php echo lang('us_activate_code'); ?></label>
					<div class="col-sm-6">
						<input class="form-control" type="text" id="code" name="code" value="<?php echo set_value('code') ?>" />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-6 col-sm-push-3">
						<input class="btn btn-blue btn-block" type="submit" name="activate" value="<?php echo lang('us_confirm_activate_code') ?>"  />
					</div>
				</div>

				<?php echo form_close(); ?>

			</div>
		</div>
	</div>