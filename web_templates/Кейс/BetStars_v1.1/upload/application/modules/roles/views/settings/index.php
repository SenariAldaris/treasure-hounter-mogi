<?php

$roleCount = array();
foreach ($role_counts as $r) {
    $roleCount[$r->role_name] = $r->count;
}

?>

	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/roles/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/roles" id="list"><?php echo lang('bf_list'); ?></a>
					 <a class="btn btn-xs btn-red" href="<?php echo site_url();?>admin/settings/roles/permission_matrix"><?php echo lang('matrix_header'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<div class="box-body">	
			<div class="alert alert-info"><?php e(lang('role_intro')); ?></div>
		

			<?php if (isset($role_counts) && is_array($role_counts) && count($role_counts)) : ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="text-center w200"><?php echo lang('role_account_type'); ?></th>
							<th class="text-center w100"># <?php echo lang('bf_users'); ?></th>
							<th><?php echo lang('role_description'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($roles as $role) : ?>
						<tr>
							<td><?php echo anchor(SITE_AREA . "/settings/roles/edit/{$role->role_id}", $role->role_name); ?></td>
							<td class='text-center'><?php echo isset($roleCount[$role->role_name]) ? $roleCount[$role->role_name] : 0; ?></td>
							<td><?php e($role->description); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>	
			<?php else : ?>
			<p><?php echo lang('role_no_roles'); ?></p>
			<?php endif; ?>
		</div>
	</div>	