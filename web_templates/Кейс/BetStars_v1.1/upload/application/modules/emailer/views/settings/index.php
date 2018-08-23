
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					<a class="btn btn-xs btn-default" href="<?php echo site_url();?>admin/settings/emailer"><?php echo lang('bf_context_settings'); ?></a>
					<a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/emailer/template"><?php echo lang('emailer_email_template') ?></a>
					<a class="btn btn-xs btn-default" href="<?php echo site_url();?>admin/settings/emailer/queue"><?php echo lang('emailer_emailer_queue') ?></a>
					<a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/emailer/create"><?php echo lang('emailer_create_email'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
				
		<div class="box-body">
		
			<?php echo form_open(SITE_AREA . '/settings/emailer', 'class="form-horizontal"'); ?>

					<h4 class="head pl20 text-left"><?php echo lang('emailer_general_settings'); ?></h4>
					<div class="form-group<?php echo form_error('sender_email') ? ' error' : ''; ?>">
						<label class="control-label col-sm-2" for="sender_email"><?php echo lang('emailer_system_email'); ?></label>
						<div class="col-sm-4">
							<input type="email" name="sender_email" id="sender_email" class="form-control" value="<?php echo set_value('sender_email', $sender_email); ?>" />
							<span class='help-inline'><?php echo form_error('sender_email'); ?></span>
							<p class="help-block"><?php echo lang('emailer_system_email_note'); ?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="mailtype"><?php echo lang('emailer_email_type'); ?></label>
						<div class="col-sm-4">
							<select name="mailtype" id="mailtype" class="form-control">
								<option value="text" <?php echo set_select('mailtype', 'text', $mailtype == 'text'); ?>><?php echo lang('emailer_mailtype_text'); ?></option>
								<option value="html" <?php echo set_select('mailtype', 'html', $mailtype == 'html'); ?>><?php echo lang('emailer_mailtype_html'); ?></option>
							</select>
						</div>
					</div>
					<div class="form-group<?php echo form_error('protocol') ? ' error' : ''; ?>">
						<label class="control-label col-sm-2" for="server_type"><?php echo lang('emailer_email_server'); ?></label>
						<div class="col-sm-4">
							<select name="protocol" id="server_type" class="form-control">
								<option value='mail' <?php echo set_select('protocol', 'mail', $protocol == 'mail'); ?>><?php echo lang('emailer_protocol_mail'); ?></option>
								<option value='sendmail' <?php echo set_select('protocol', 'sendmail', $protocol == 'sendmail'); ?>><?php echo lang('emailer_protocol_sendmail'); ?></option>
								<option value='smtp' <?php echo set_select('protocol', 'smtp', $protocol == 'smtp'); ?>><?php echo lang('emailer_protocol_smtp'); ?></option>
							</select>
							<span class="help-inline"><?php echo form_error('protocol'); ?></span>
						</div>
					</div>

					<h4 class="head pl20 text-left"><?php echo lang('emailer_settings'); ?></h4>
					<?php /* PHP Mail */ ?>
					<div id="mail" class="form-group">
						<p class="intro"><?php echo lang('emailer_settings_note'); ?></p>
					</div>
					<?php /* Sendmail */ ?>
					<div id="sendmail" class='subsection'>
						<div class="form-group<?php echo form_error('mailpath') ? ' error' : ''; ?>">
							<label class="control-label col-sm-2" for="mailpath"><?php echo lang('emailer_sendmail_path'); ?></label>
							<div class="col-sm-4">
								<input type="text" name="mailpath" id="mailpath" class="form-control" value="<?php echo set_value('mailpath', $mailpath) ?>" />
								<span class="help-inline"><?php echo form_error('mailpath'); ?></span>
							</div>
						</div>
					</div>
					<?php /* SMTP */ ?>
					<div id="smtp" class='subsection'>
						<div class="form-group<?php echo form_error('smtp_host') ? ' error' : ''; ?>">
							<label class="control-label col-sm-2" for="smtp_host"><?php echo lang('emailer_smtp_address'); ?></label>
							<div class="col-sm-4">
								<input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?php echo set_value('smtp_host', $smtp_host) ?>" />
								<span class="help-inline"><?php echo form_error('smtp_host'); ?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="smtp_user"><?php echo lang('emailer_smtp_username'); ?></label>
							<div class="col-sm-4">
								<input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?php echo set_value('smtp_user', $smtp_user) ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="smtp_pass"><?php echo lang('emailer_smtp_password'); ?></label>
							<div class="col-sm-4">
								<input type="password" name="smtp_pass" id="smtp_pass" class="form-control" value="<?php echo set_value('smtp_pass', $smtp_pass) ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="smtp_port"><?php echo lang('emailer_smtp_port'); ?></label>
							<div class="col-sm-4">
								<input type="text" name="smtp_port" id="smtp_port" class="form-control" value="<?php echo set_value('smtp_port', $smtp_port) ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="smtp_timeout"><?php echo lang('emailer_smtp_timeout_secs'); ?></label>
							<div class="col-sm-4">
								<input type="text" name="smtp_timeout" id="smtp_timeout" class="form-control" value="<?php echo set_value('smtp_timeout', $smtp_timeout) ?>" />
							</div>
						</div>
					</div>

				<fieldset class="form-actions">
					<input type="submit" name="save" class="btn btn-blue" value="<?php e(lang('emailer_save_settings')); ?>" />
				</fieldset>
			<?php echo form_close(); ?>




			<?php /* Test Settings */ ?>




			<h4 class="head pl20 text-left"><?php echo lang('emailer_test_header'); ?></h4>
			<?php echo form_open(SITE_AREA . '/settings/emailer/test', array('class' => 'form-horizontal', 'id'=>'test-form')); ?>

					<?php echo lang('emailer_test_settings') ?>
					<div class='form-group'>
						<p class="intro"><?php echo lang('emailer_test_intro'); ?></p>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="test-email"><?php echo lang('bf_email'); ?></label>
						<div class="col-sm-6">
						
							<div class="input-group input-group">
								<input type="email" name="email" id="test-email" class="form-control" value="<?php echo set_value('test_email', settings_item('site.system_email')); ?>" />
								<span class="input-group-btn">
									<button type="submit" name="test" class="btn btn-blue" type="button"><?php echo lang('emailer_test_button'); ?></button>
								</span>
							</div>

						</div>
					</div>
	
			<?php echo form_close(); ?>
			<div id="test-ajax"></div>

			
		</div>
	</div>	