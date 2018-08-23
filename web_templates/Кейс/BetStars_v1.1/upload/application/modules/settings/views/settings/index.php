<?php 
$errorClass     = empty($errorClass) ? ' has-error' : $errorClass;
$controlClass   = empty($controlClass) ? 'form-control' : $controlClass;
$defaultTimezone = isset($user->timezone) ? $user->timezone : strtoupper(settings_item('site.default_timezone'));

if (validation_errors()) :?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4><i class="icon fa fa-ban"></i> Alert!</h4>
    <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div class="row">
	<div class="col-md-12">
	
	
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
			  <li class="active"><a href="#site_settings" data-toggle="tab"><?php echo lang('set_tab_site');?></a></li>
			  <li><a href="#tips_settings" data-toggle="tab"><?php echo lang('set_tab_tips');?></a></li>
			</ul>
			

		
			<div class="box no-shadow box-widget">

	
				<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
					<div class="box-body">

						<div class="tab-content">
							<div class="active tab-pane" id="site_settings">
							
								<div class="box-header with-border mb20">
									<h3 class="box-title col-md-8"><?php echo lang('set_tab_site'); ?></h3>
								</div><!-- /.box-header -->
								
								<div class="col-md-6">
					

									<div class="form-group<?php echo form_error('title') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="title"><?php echo lang('bf_site_name'); ?></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="title" id="title" class="span6" value="<?php echo set_value('site.title', isset($settings['site.title']) ? $settings['site.title'] : ''); ?>" />
											<span class='help-block'><?php echo form_error('title'); ?></span>
										</div>
									</div>
									<div class="form-group<?php echo form_error('system_email') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="system_email"><?php echo lang('bf_site_email'); ?></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="system_email" id="system_email" class="span4" value="<?php echo set_value('site.system_email', isset($settings['site.system_email']) ? $settings['site.system_email'] : ''); ?>" />
											<span class="help-block"><?php echo lang('bf_site_email_help'); ?></span>
										</div>
									</div>
									<div class="form-group<?php echo form_error('status') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="status"><?php echo (form_error('system_email') ? form_error('system_email') . '<br />' : '') . lang('bf_site_status'); ?></label>
										<div class="col-sm-8">
											<select name="status" class="form-control" id="status">
												<option value="1" <?php echo set_select('site.status', 1, isset($settings['site.status']) && $settings['site.status'] == 1); ?>><?php echo lang('bf_online'); ?></option>
												<option value="0" <?php echo set_select('site.status', 0, isset($settings['site.status']) && $settings['site.status'] == 0); ?>><?php echo lang('bf_offline'); ?></option>
											</select>
											<span class='help-block'><?php echo form_error('status'); ?></span>
										</div>
									</div>
									<div class="form-group<?php echo form_error('offline_reason') ? 'has-error' : ''; ?>"<?php echo isset($settings['site.status']) && $settings['site.status'] == 1 ? ' style="display:none"' : ''; ?>>
										<label class="control-label col-sm-4" for="offline_reason"><?php echo lang('settings_offline_reason'); ?></label>
										<div class="col-sm-8">
											<textarea id="offline_reason" name="offline_reason" class="form-control"><?php echo isset($settings['site.offline_reason']) ? $settings['site.offline_reason'] : ''; ?></textarea>
											<span class='help-block'><?php echo form_error('offline_reason'); ?></span>
										</div>
									</div>
									<div class="form-group<?php echo form_error('list_limit') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="list_limit"><?php echo lang('bf_top_number'); ?></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="list_limit" id="list_limit" value="<?php echo set_value('list_limit', isset($settings['site.list_limit']) ? $settings['site.list_limit'] : ''); ?>" class="span1" />
											<span class="help-block"><?php echo (form_error('list_limit') ? form_error('list_limit') . '<br />' : '') . lang('bf_top_number_help'); ?></span>
										</div>
									</div>
									<div class="form-group<?php echo form_error('language') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="language"><?php echo lang('bf_language'); ?></label>
										<div class="col-sm-8">
											<select name="language" class="form-control" id="language" >
												<?php
												if (! empty($languages) && is_array($languages)) :
													foreach ($languages as $language) :
														
												?>
												<option value="<?php e($language); ?>" <?php echo set_select('site.default_language', $language, isset($settings['site.default_language']) && $settings['site.default_language'] ==  $language); ?>><?php e(ucfirst($language)); ?></option>
												<?php
													endforeach;
												endif;
												?>
											</select>
											<span class="help-block"><?php echo (form_error('languages') ? form_error('languages') . '<br />' : '') . lang('bf_language_help'); ?></span>
										</div>
									</div>

									<div class="form-group<?php echo form_error('allow_register') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="language"><?php echo lang('bf_register'); ?></label>
										<div class="col-sm-6">
											<div class="checkbox">
												<label>
													<input type="checkbox" class="minimal" name="allow_register" id="allow_register" value="1" <?php echo set_checkbox('auth.allow_register', 1, isset($settings['auth.allow_register']) && $settings['auth.allow_register'] == 1); ?> />
													<?php echo lang('bf_allow_register'); ?>
												</label>
											</div>						
											<span class='help-block'><?php echo form_error('allow_register'); ?></span>
										</div>
									</div>
									<div class="form-group<?php echo form_error('user_activation_method') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="user_activation_method"><?php echo lang('bf_activate_method'); ?></label>
										<div class="col-sm-8">
											<select name="user_activation_method"  class="form-control"id="user_activation_method">
												<option value="0" <?php echo set_select('auth.user_activation_method', 0, isset($settings['auth.user_activation_method']) && $settings['auth.user_activation_method'] == 0); ?>><?php echo lang('bf_activate_none'); ?></option>
												<option value="1" <?php echo set_select('auth.user_activation_method', 1, isset($settings['auth.user_activation_method']) && $settings['auth.user_activation_method'] == 1); ?>><?php echo lang('bf_activate_email'); ?></option>
												<option value="2" <?php echo set_select('auth.user_activation_method', 2, isset($settings['auth.user_activation_method']) && $settings['auth.user_activation_method'] == 2); ?>><?php echo lang('bf_activate_admin'); ?></option>
											</select>
											<span class='help-block'><?php echo form_error('user_activation_method'); ?></span>
										</div>
									</div>		
									<div class="form-group<?php echo form_error('login_type') ? 'has-error' : ''; ?>">
										<label class="control-label col-sm-4" for="login_type"><?php echo lang('bf_login_type') ?></label>
										<div class="col-sm-8">
											<select name="login_type"  class="form-control" id="login_type">
												<option value="email" <?php echo set_select('auth.login_type', 'email', isset($settings['auth.login_type']) && $settings['auth.login_type'] == 'email'); ?>><?php echo lang('bf_login_type_email'); ?></option>
												<option value="username" <?php echo set_select('auth.login_type', 'username', isset($settings['auth.login_type']) && $settings['auth.login_type'] == 'username'); ?>><?php echo lang('bf_login_type_username'); ?></option>
												<option value="both" <?php echo set_select('auth.login_type', 'both', isset($settings['auth.login_type']) && $settings['auth.login_type'] == 'both'); ?>><?php echo lang('bf_login_type_both'); ?></option>
											</select>
											<span class='help-block'><?php echo form_error('login_type'); ?></span>
										</div>
									</div>	
								
									<div class="form-group">
										<label class="control-label col-sm-4" for="allow_remember"><?php echo lang('bf_remember'); ?></label>
										<div class="col-sm-6">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="allow_remember" id="allow_remember" value="1" <?php echo set_checkbox('auth.allow_remember', 1, isset($settings['auth.allow_remember']) && $settings['auth.allow_remember'] == 1); ?> />
													<?php echo lang('bf_allow_remember'); ?>
												</label>
											</div>
										</div>
									</div>	

								
									<div class="form-group<?php echo form_error('remember_length') ?'has-error' : ''; ?>" id="remember-length"<?php echo $settings['auth.allow_remember'] ? '' : ' style="display:none"'; ?>>
										<label class="control-label col-sm-4" for="remember_length"><?php echo lang('bf_remember_time'); ?></label>
										<div class="col-sm-8">
											<select class="form-control" name="remember_length" id="remember_length">
												<option value="604800"  <?php echo set_select('auth.remember_length', '604800', isset($settings['auth.remember_length']) && $settings['auth.remember_length'] == '604800'); ?>>1 <?php echo lang('bf_week'); ?></option>
												<option value="1209600" <?php echo set_select('auth.remember_length', '1209600', isset($settings['auth.remember_length']) && $settings['auth.remember_length'] == '1209600'); ?>>2 <?php echo lang('bf_weeks'); ?></option>
												<option value="1814400" <?php echo set_select('auth.remember_length', '1814400', isset($settings['auth.remember_length']) && $settings['auth.remember_length'] == '1814400'); ?>>3 <?php echo lang('bf_weeks'); ?></option>
												<option value="2592000" <?php echo set_select('auth.remember_length', '2592000', isset($settings['auth.remember_length']) && $settings['auth.remember_length'] == '2592000'); ?>>30 <?php echo lang('bf_days'); ?></option>
											</select>
											<span class='help-block'><?php echo form_error('remember_length'); ?></span>
										</div>
									</div>

								</div><!-- ./col -->
							
								<div class="col-md-6">





									<div class="form-group<?php echo form_error('password_min_length') ? 'has-error' : ''; ?>" id="password-strength">
										<label class="control-label col-sm-6" for="password_min_length"><?php echo lang('bf_password_strength'); ?></label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="password_min_length" id="password_min_length" value="<?php echo set_value('password_min_length', isset($settings['auth.password_min_length']) ? $settings['auth.password_min_length'] : ''); ?>" class="span1" />
											<span class="help-block"><?php echo (form_error('password_min_length') ? form_error('password_min_length') . '<br />' : '') . lang('bf_password_length_help'); ?></span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-6" id='password_options_label'><?php echo lang('set_option_password'); ?></label>
										<div class="col-sm-6" aria-labelledby='password_options_label' role='group'>
											<div class="checkbox">
												<label class="checkbox" for="password_force_numbers">
													<input type="checkbox" class="minimal" name="password_force_numbers" id="password_force_numbers" value="1" <?php echo set_checkbox('password_force_numbers', 1, isset($settings['auth.password_force_numbers']) && $settings['auth.password_force_numbers'] == 1); ?> />
													<?php echo lang('bf_password_force_numbers'); ?>
												</label>
											</div>
											<div class="checkbox">
												<label class="checkbox" for="password_force_symbols">								
													<input type="checkbox" class="minimal" name="password_force_symbols" id="password_force_symbols" value="1" <?php echo set_checkbox('password_force_symbols', 1, isset($settings['auth.password_force_symbols']) && $settings['auth.password_force_symbols'] == 1); ?> />
													<?php echo lang('bf_password_force_symbols'); ?>
												</label>
											</div>	
											<div class="checkbox">
												<label class="checkbox" for="password_force_mixed_case">
													<input type="checkbox" class="minimal" name="password_force_mixed_case" id="password_force_mixed_case" value="1" <?php echo set_checkbox('password_force_mixed_case', 1, isset($settings['auth.password_force_mixed_case']) && $settings['auth.password_force_mixed_case'] == 1); ?> />
													<?php echo lang('bf_password_force_mixed_case'); ?>
												</label>
											</div>
											<div class="checkbox">
												<label class="checkbox" for="password_show_labels">
													<input type="checkbox" class="minimal" name="password_show_labels" id="password_show_labels" value="1" <?php echo set_checkbox('password_show_labels', 1, isset($settings['auth.password_show_labels']) && $settings['auth.password_show_labels'] == 1); ?> />
													<?php echo lang('bf_password_show_labels'); ?>
												</label>
											</div>	
										</div>
									</div>
									<div class="form-group<?php echo form_error('password_iterations') ? 'has-error' : ''; ?>">
										<label for="password_iterations" class="control-label col-sm-6"><?php echo lang('set_password_iterations'); ?></label>
										<div class="col-sm-6">
											<select class="form-control" name="password_iterations" id='password_iterations'>
												<option <?php echo set_select('password_iterations', 2, isset($settings['password_iterations']) && $settings['password_iterations'] == 2) ?>>2</option>
												<option <?php echo set_select('password_iterations', 4, isset($settings['password_iterations']) && $settings['password_iterations'] == 4) ?>>4</option>
												<option <?php echo set_select('password_iterations', 8, isset($settings['password_iterations']) && $settings['password_iterations'] == 8) ?>>8</option>
												<option <?php echo set_select('password_iterations', 16, isset($settings['password_iterations']) && $settings['password_iterations'] == 16) ?>>16</option>
												<option <?php echo set_select('password_iterations', 31, isset($settings['password_iterations']) && $settings['password_iterations'] == 31) ?>>31</option>
											</select>
										</div>	
										<span class="help-block col-sm-12 pt20"><?php echo (form_error('password_iterations') ? form_error('password_iterations') . '<br />' : '') . lang('bf_password_iterations_note'); ?></span>
										
									</div>
									<div class="form-group">
										<label class="control-label col-sm-6" for="force_pass_reset"><?php echo lang('set_force_reset'); ?></label>
										<div class="col-sm-6">
											<a href="<?php echo site_url(SITE_AREA . '/settings/users/force_password_reset_all'); ?>" class="btn btn-danger" onclick="return confirm('<?php echo lang('set_password_reset_confirm'); ?>');"><?php echo lang('set_reset'); ?></a>
											
										</div>
										<span class="help-block col-sm-12 pt20"><?php echo lang('set_reset_note'); ?></span>
									</div>


								</div><!-- ./col -->

							</div><!-- ./tab pane -->
							
							<div class="tab-pane" id="tips_settings">
							
								<div class="box-header with-border mb20">
									<h3 class="box-title col-md-8"><?php echo lang('set_tab_tips'); ?></h3>
								</div><!-- /.box-header -->
								
								<div class="form-group<?php echo form_error('allow_post') ? 'has-error' : ''; ?>">
									<label class="control-label col-sm-2" for="language"><?php echo lang('set_tips_open'); ?></label>
									<div class="col-sm-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="minimal" name="allow_post" id="allow_post" value="1" <?php echo set_checkbox('tips.allow_post', 1, isset($settings['tips.allow_post']) && $settings['tips.allow_post'] == 1); ?> />
												<?php echo lang('set_tips_allow'); ?>
											</label>
										</div>						
										<span class='help-block'><?php echo form_error('allow_post'); ?></span>
									</div>
								</div>		

								<div class="form-group<?php echo form_error('tips_rules') ? 'has-error' : ''; ?>">
									<label class="control-label col-sm-2" for="tips_rules"><?php echo lang('set_tips_rules'); ?></label>
									<div class="col-sm-8">
										<textarea class="textarea form-control" id="tips_rules" name="tips_rules" cols="10" rows="15"/>
										<?php echo isset($settings['tips.rules']) ? $settings['tips.rules'] : ''; ?>
										</textarea>					
										<span class='help-block'><?php echo form_error('tips_rules'); ?></span>
									</div>
								</div>	
									
								
							</div><!-- ./tab pane -->

						</div><!-- ./tab content -->
					</div><!-- ./box body -->	
						
					<div class="box-footer">
						<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_context_settings'); ?>" />
					</div>

				<?php echo form_close(); ?>

			</div>
		</div>
	</div>
</div>			