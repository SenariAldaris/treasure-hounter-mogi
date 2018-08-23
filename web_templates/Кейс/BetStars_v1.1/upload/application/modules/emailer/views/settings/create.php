<style>
#email_content { width: 90%; }
.id_column { width: 3em; }
.login_column { width: 11em; }
.status_column { width: 10em; }
</style>
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <h4 class="alert-heading"><?php echo lang('emailer_validation_errors_heading'); ?></h4>
    <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

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

		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		
			<div class="box-body">

				<div class='form-group'>
					<label class='control-label col-sm-2' for='email_subject'><?php echo lang('emailer_email_subject'); ?></label>
					<div class='col-sm-4'>
						<input type="text" class="form-control" name="email_subject" id="email_subject" value="<?php if (isset($email_subject)) { e($email_subject); } ?>" />
					</div>
				</div>
				<div class='form-group'>
					<label class='control-label col-sm-2' for='email_content'><?php echo lang('emailer_email_content'); ?></label>
					<div class='col-sm-10'>
						<textarea name="email_content" class="form-control" id="email_content" rows="15"><?php
							if (isset($email_content)) {
								e($email_content);
							}
						?></textarea>
					</div>
				</div>
	  
				<h4 class="head pl20 text-left"><?php echo lang('bf_users'); ?></h4>
				<?php if (empty($users) || ! is_array($users)) : ?>
				<p><?php echo lang('emailer_no_users_found'); ?></p>
				<?php
				else :
					$hasChecked = ! empty($checked) && is_array($checked);
					$numColumnsUsers = 7;
				?>
				<div class="table-responsive">
					<table id="users_table" class="table table-striped">
						<thead>
							<tr>
								<th class="column-check"><input class="check-all" type="checkbox" /></th>
								<th class="id_column"><?php echo lang('bf_id'); ?></th>
								<th><?php echo lang('bf_username'); ?></th>
								<th><?php echo lang('bf_display_name'); ?></th>
								<th><?php echo lang('bf_email'); ?></th>
								<th class="login_column"><?php echo lang('us_last_login'); ?></th>
								<th class="status_column"><?php echo lang('us_status'); ?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="<?php echo $numColumnsUsers; ?>">
								</td>
							</tr>
						</tfoot>
						<tbody>
							<?php foreach ($users as $user) : ?>
							<tr>
								<td class='column-check'>
									<input type="checkbox" name="checked[]" value="<?php echo $user->id; ?>"<?php echo $hasChecked && in_array($user->id, $checked) ? ' checked="checked"' : ''; ?> />
								</td>
								<td><?php echo $user->id; ?></td>
								<td>
									<a href='<?php echo site_url(SITE_AREA . "/settings/users/edit/{$user->id}"); ?>'><?php echo $user->username; ?></a>
									<?php echo $user->banned ? '<span class="label label-warning">Banned</span>' : ''; ?>
								</td>
								<td><?php echo $user->display_name; ?></td>
								<td><?php echo empty($user->email) ? '' : mailto($user->email); ?></td>
								<td><?php echo $user->last_login == '0000-00-00 00:00:00' ? '---' : date('M j, y g:i A', strtotime($user->last_login)); ?></td>
								<td><?php if ($user->active) : ?>
									<span class="label label-success"><?php echo lang('us_active'); ?></span>
									<?php else : ?>
									<span class="label label-warning"><?php echo lang('us_inactive'); ?></span>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>	
			</div>
			
			<div class="box-footer">
				<?php echo lang('bf_with_selected') . '&nbsp;'; ?>
				<input type="submit" name="create" class="btn btn-blue" value="<?php echo lang('emailer_create_email'); ?>" />
				<?php echo anchor(SITE_AREA . '/settings/emailer/queue', lang('bf_action_cancel'), 'class="btn btn-yellow"'); ?>
			</div>
			<?php endif; ?>
		<?php echo form_close(); ?>
	</div>
	
	
	<script type="text/javascript">
    //Check and uncheck all functionality
	$(".check-all").click(function () {
        $('#users_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });	
</script>	