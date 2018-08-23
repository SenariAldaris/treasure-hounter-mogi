	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					<a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/sysinfo"><?php echo lang('sysinfo_system'); ?></a>
					<a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/sysinfo/php_info"><?php echo lang('sysinfo_php'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-striped">
					<tbody>
						<?php foreach ($info as $key => $val) : ?>
						<tr>
							<th class="text-left w200"><?php e(lang($key)); ?></th>
							<td><?php e($val); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>