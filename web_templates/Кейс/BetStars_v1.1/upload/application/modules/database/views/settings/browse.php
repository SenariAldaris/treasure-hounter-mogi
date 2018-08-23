<div class="alert alert-info">
    <h4 class='alert-heading'><?php e(lang('database_sql_query')); ?>:</h4>
    <p><?php e($query); ?></p>
</div>
<?php if (empty($num_rows) || empty($rows) || ! is_array($rows)) : ?>
<div class="alert alert-warning">
    <?php e(lang('database_no_rows')); ?>
</div>
<?php else : ?>
<p><?php echo e(sprintf(lang('database_total_results'), $num_rows)); ?></p>

	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/database"><?php echo lang('database_maintenance'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/database/backups"><?php echo lang('database_backups'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<div class="box-body">	
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<?php foreach ($rows[0] as $field => $value) : ?>
							<th><?php e($field); ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($rows as $row) : ?>
						<tr>
							<?php foreach ($row as $key => $value) : ?>
							<td><?php e($value); ?></td>
							<?php endforeach; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
<?php endif;?>
