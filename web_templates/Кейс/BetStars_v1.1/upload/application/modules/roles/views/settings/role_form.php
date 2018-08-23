<?php

$controlClass = 'form-control';

if (validation_errors()) :
?>
<div class="alert alert-error fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/roles/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/roles" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		
		
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
			<div class="box-body">

					<h3 class="fs18"><?php echo lang('role_details'); ?></h3>
					<div class="divider-4"></div>
					
					<input type='hidden' name='role_id' value="<?php echo set_value('role_id', isset($role) ? $role->role_id : ''); ?>" />
					<div class="form-group<?php echo form_error('role_name') ? ' error' : ''; ?>">
						<label class="control-label col-sm-2" for="role_name"><?php echo lang('role_name'); ?></label>
						<div class="col-sm-4">
							<input class="<?php echo $controlClass; ?>" type="text" name="role_name" id="role_name" class="input-xlarge" value="<?php echo set_value('role_name', isset($role) ? $role->role_name : ''); ?>" />
							<span class="help-inline"><?php echo form_error('role_name'); ?></span>
						</div>
					</div>
					<div class="description form-group<?php echo form_error('description') ? ' error' : ''; ?>">
						<label class="control-label col-sm-2" for="description"><?php echo lang('bf_description'); ?></label>
						<div class="col-sm-4">
							<textarea class="<?php echo $controlClass; ?>" name="description" id="description" rows="3" class="input-xlarge"><?php echo set_value('description', isset($role) ? $role->description : ''); ?></textarea>
							<span class="help-inline"><?php echo form_error('description') ? form_error('description') : lang('role_max_desc_length'); ?></span>
						</div>
					</div>

					<div class="form-group<?php echo form_error('default') ? ' error' : ''; ?>">
						<label class="control-label col-sm-2" for="default"><?php echo lang('role_default_role'); ?></label>
						<div class="col-sm-4">
							<label class="checkbox" for="default">
								<input type="checkbox" name="default" id="default" value="1" <?php echo set_checkbox('default', 1, isset($role) && $role->default == 1); ?> />
								<?php echo lang('role_default_note'); ?>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" id="can_delete_label"><?php echo lang('role_can_delete_role'); ?></label>
						<div class="col-sm-4" aria-labelledby="can_delete_label" role="group">
							<label class="radio" for="can_delete_yes">
								<input type="radio" name="can_delete" id="can_delete_yes" value="1" <?php echo set_radio('can_delete', 1, isset($role) && $role->can_delete == 1); ?> />
								<?php echo lang('bf_yes'); ?>
							</label>
							<label class="radio" for="can_delete_no">
								<input type="radio" name="can_delete" id="can_delete_no" value="0" <?php echo set_radio('can_delete', 0, isset($role) && $role->can_delete == 0); ?> />
								<?php echo lang('bf_no'); ?>
							</label>
							<span class="help-inline"><?php echo lang('role_can_delete_note'); ?></span>
						</div>
					</div>
	
				<!-- Permissions -->
				<?php if (has_permission('Permissions.Manage')) : ?>
					<h3 class="fs18"><?php echo lang('role_permissions'); ?></h3>
					<div class="divider-4"></div>			

					<div class="alert alert-info"><?php echo lang('role_permissions_check_note'); ?></div>
					<?php echo Modules::run('roles/settings/matrix'); ?>
				
				<?php endif; ?>
			</div>	
			<div class="box-footer">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('role_save_role'); ?>" />
				<?php echo anchor(SITE_AREA . '/settings/roles', lang('bf_action_cancel'),'class="btn btn-warning"');
				if (isset($role)
					&& $role->can_delete == 1
					&& has_permission('Roles.Delete')
				) :
				?>
				<button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('<?php e(js_escape(lang('role_delete_confirm') . ' ' . lang('role_delete_note'))); ?>')"><span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('role_delete_role'); ?></button>
				<?php endif;?>
			</div>
		<?php echo form_close(); ?>
		
	</div>	