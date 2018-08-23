
<div class="box">
	<div class="box-body">
		<div class="table-responsive">
			<span class="text-center"><?php echo lang('in_intro'); ?></span>

			<table class="table table-striped" role="grid">
				<tbody>
					<!-- PHP Version -->
					<tr>
						<td class="fl"><?php echo lang('in_php_version') .' <b>'. $php_min_version ?>+</b></td>
						<td class="fr"><?php echo $php_acceptable ? '<span class="label label-green">' : '<span class="label label-red">'; ?><?php echo $php_version ?></span></td>
					</tr>
					<tr>
						<td class="fl"><?php echo lang('in_curl_enabled') ?></td>
						<td class="fr"><?php echo $curl_enabled ? '<span class="label label-green">'. lang('in_enabled') .'</span>' : '<span class="label label-red">'. lang('in_disabled') .'</span>'; ?></td>
					</tr>

					<!-- Folders -->
					<tr><td class="fl text-blue"><b><?php echo lang('in_folders') ?></b></td></tr>

					<?php foreach ($folders as $folder => $perm) :?>
					<tr>
						<td class="fl"><?php echo $folder ?></td>
						<td class="fr"><?php echo $perm ? '<span class="label label-green">'. lang('in_writeable') .'</span>' : '<span class="label label-red">'. lang('in_not_writeable') .'</span>' ?></td>
					</tr>
					<?php endforeach; ?>

					<!-- Files -->
					<tr><td class="fl text-blue"><b><?php echo lang('in_files') ?></b></td></tr>

					<?php foreach ($files as $file => $perm) :?>
					<tr>
						<td class="fl"><?php echo $file ?></td>
						<td class="fr"><?php echo $perm ? '<span class="label label-green">'. lang('in_writeable') .'</span>' : '<span class="label label-red">'. lang('in_not_writeable') .'</span>' ?></td>
					</tr>
					<?php endforeach; ?>
					<tr>
						<td class="fl"></td>
						<td class="fr"><a href="install/dbsetup" class="btn btn-blue">Next</a></td>
					</tr>
				</tbody>
			</table>

		</div><!-- /.box-body -->
		
	</div>	

		
			