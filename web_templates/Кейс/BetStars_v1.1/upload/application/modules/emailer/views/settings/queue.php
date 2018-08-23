<style>
th.id { width: 2em; }
th.to { width: 10em; }
th.attempts { width: 6em; }
td.attempts { text-align: center !important; }
th.sent { width: 3em; }
td.sent { text-align: center !important; }
th.preview { width: 6em; }
td.preview { text-align: center !important; }
</style>

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

			
				<div class="col-sm-4">
					<p class="lh30 mn"><?php echo lang('emailer_total_in_queue'); ?> <?php echo $total_in_queue ? $total_in_queue : '0'; ?></p>
				</div>
				<div class="col-sm-4">
					<p class="lh30 mn"><?php echo lang('emailer_total_sent'); ?> <?php echo $total_sent ? $total_sent : '0'; ?></p>
				</div>
				<div class="col-sm-4">
					<?php echo form_open($this->uri->uri_string(), array('class' => 'form-inline')); ?>
						<input type="submit" name="force_process" class="btn btn-blue" value="<?php e(lang('emailer_force_process')); ?>" />
						<input type="submit" name="insert_test" class="btn btn-warning" value="<?php e(lang('emailer_insert_test')); ?>" />
					<?php echo form_close(); ?>
				</div>
			<div class="clearfix"></div>

			<?php if (empty($emails) || ! is_array($emails)) : ?>
			<div class="alert mt10 alert-warning">
				<p><?php echo lang('emailer_stat_no_queue'); ?></p>
			</div>
			<?php
			else :
				$numColumns = 7;
				echo form_open($this->uri->uri_string());
			?>
			<div class="table-responsive">
				<table id="email_table" class="table table-striped">
					<thead>
						<tr>
							<th class="column-check"><input class="check-all" type="checkbox" /></th>
							<th class="id"><?php echo lang('emailer_id'); ?></th>
							<th class="to"><?php echo lang('emailer_to'); ?></th>
							<th><?php echo lang('emailer_subject'); ?></th>
							<th class="attempts"># <?php echo lang('emailer_attempts'); ?></th>
							<th class="sent"><?php echo lang('emailer_sent'); ?></th>
							<th class="preview"><?php echo lang('bf_action_preview'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($emails as $email) :?>
						<tr>
							<td class='column-check'><input type="checkbox" name="checked[]" value="<?php echo $email->id; ?>" /></td>
							<td class='id'><?php echo $email->id; ?></td>
							<td class='to'><?php e($email->to_email); ?></td>
							<td><?php e($email->subject); ?></td>
							<td class="attempts"><?php echo $email->attempts; ?></td>
							<td class="sent"><?php echo $email->success ? lang('bf_yes') : lang('bf_no'); ?></td>
							<td class="preview"><?php echo anchor(SITE_AREA . "/settings/emailer/preview/{$email->id}", lang('bf_action_preview'), array('target'=>'_blank')); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					
				</table>
			</div>
		</div>
		<div class="box-footer">
			<tr>
				<td colspan="<?php echo $numColumns; ?>">
					<?php echo lang('bf_with_selected') . '&nbsp;'; ?>
					<button type="submit" name="delete" id="delete-me" class="btn btn-danger" onclick="return confirm('<?php e(js_escape(lang('emailer_delete_confirm'))); ?>')">
						<span class="icon-white icon-trash"></span> <?php echo lang('bf_action_delete'); ?>
					</button>
				</td>
			</tr>
			<?php if ($this->pagination->create_links()) : ?>
			<tr>
				<td colspan="<?php echo $numColumns; ?>" class="text-left"><?php echo $this->pagination->create_links(); ?></td>
			</tr>
			<?php endif; ?>
        </div>
		 
        <?php echo form_close();
			endif; ?>
	</div>
	
	<?php if (isset($email_debug)) : ?>
	<h3><?php echo lang('emailer_queue_debug_heading'); ?></h3>
	<div class="notification attention">
		<p><?php echo lang('emailer_queue_debug_error'); ?></p>
	</div>
	<div class="box">
		<?php echo $email_debug; ?>
	</div>
	<?php endif;?>

<script type="text/javascript">
    //Check and uncheck all functionality
	$(".check-all").click(function () {
        $('#email_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });	
</script>	