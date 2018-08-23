<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('competitions_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($competitions->id) ? $competitions->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/competitions/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/competitions" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
		
			<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
			
				<input id='competition_id' type='hidden' name='competition_id' value="<?php echo $competitions->id;?>" />
				
				<div class="form-group">
					<div class='col-sm-8 col-sm-push-2'>
						<h4>Place / Prise</h4>
					</div>
				</div>
				<?php $rewards = $this->competitions_model->get_competition_rewards($competitions->id);
					foreach ($rewards->result() as $record) :?>
					
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo $record->place;?></label>
						<div class='col-sm-8'>
							<input id='place' name='place[]' class="form-control" type='hidden' value="<?php echo $record->place;?>"/>
							<input id='reward' name='reward[]' class="form-control" type='text' value="<?php echo $record->reward;?>"/>
						</div>
					</div>
			
					<?php endforeach;?>

				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('competitions_action_edit'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/competitions', lang('competitions_cancel'), 'class="btn btn-warning"'); ?>
					
					<?php if ($this->auth->has_permission('Competitions.Dashboard.Delete')) : ?>
						<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('competitions_delete_confirm'))); ?>');">
							<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('competitions_delete_record'); ?>
						</button>
					<?php endif; ?>
				</div>
					

			<?php echo form_close(); ?>	
		</div>	
	</div>
	
<script type="text/javascript">
	var site_url = '<?php echo site_url();?>';
</script>		