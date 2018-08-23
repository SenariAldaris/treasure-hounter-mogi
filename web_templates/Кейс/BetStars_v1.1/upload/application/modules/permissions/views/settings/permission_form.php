	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/permissions/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/permissions" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        
			<div class="box-body">

				<div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
					<label for="name" class="control-label col-sm-2"><?php echo lang('permissions_name'); ?></label>
					<div class="col-sm-4">
						<input class="form-control" id="name" type="text" name="name" class="input-large" maxlength="30" value="<?php echo set_value('name', isset($permissions->name) ? $permissions->name : ''); ?>" />
						<span class="help-inline"><?php echo form_error('name'); ?></span>
					</div>
				</div>
				<div class="form-group<?php echo form_error('description') ? ' error' : ''; ?>">
					<label for="description" class="control-label col-sm-2"><?php echo lang('permissions_description'); ?></label>
					<div class="col-sm-4">
						<input class="form-control" id="description" type="text" name="description" maxlength="100" value="<?php echo set_value('description', isset($permissions->description) ? $permissions->description : ''); ?>" />
						<span class="help-inline"><?php echo form_error('description'); ?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="status" class="control-label col-sm-2"><?php echo lang('permissions_status'); ?></label>
					<div class="col-sm-4">
						<select name="status" id="status" class="form-control">
							<option value="active" <?php echo set_select('status', 'active', isset($permissions->status) && $permissions->status == 'active'); ?>><?php echo lang('permissions_active'); ?></option>
							<option value="inactive" <?php echo set_select('status', 'inactive', isset($permissions->status) && $permissions->status == 'inactive'); ?>><?php echo lang('permissions_inactive'); ?></option>
						</select>
					</div>
				</div>
				
			</div>

			<div class='box-footer'>
				<input type="submit" name="save" class="btn btn-blue" value="<?php echo lang('permissions_save'); ?>" />
				<?php echo anchor(SITE_AREA . '/settings/permissions', lang('bf_action_cancel'), 'class="btn btn-yellow"');
				?>
			</div>
		<?php echo form_close(); ?>
	</div>