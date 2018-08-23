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
		<h3><?php echo lang('database_drop_title'); ?></h3>
		<?php if (empty($tables) || ! is_array($tables)) : ?>
		<div class="alert alert-error">
			<?php echo lang('database_drop_none'); ?>
		</div>
		<?php
		else :
			echo form_open(SITE_AREA . '/developer/database/drop');
		?>
		
			<h4><?php echo lang('database_drop_confirm'); ?></h4>
			<ul class="list-group list-group-unbordered">
				<?php foreach ($tables as $table) : ?>
				<li class="list-group-item"><?php e($table); ?>
					<input type="hidden" name="tables[]" value="<?php e($table); ?>" />
				</li>
				<?php endforeach; ?>
			</ul>
			<div class="alert alert-warning">
				<?php echo lang('database_drop_attention'); ?>
			</div>
		</div>		
		<div class="box-footer">
			<button type="submit" name="drop" class="btn btn-danger"><?php e(lang('database_drop_button')); ?></button>
			<?php echo anchor(SITE_AREA . '/developer/database', lang('bf_action_cancel'), 'class="btn btn-warning"'); ?>
		</div>
			<?php
				echo form_close();
			endif;
			?>
			
	</div>