<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('leagues_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($leagues->id) ? $leagues->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/leagues/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/leagues" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			
			<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        
				<div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
					<?php echo form_label(lang('leagues_name') . lang('bf_form_label_required'), 'name', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-4">
						<input id='name' class="form-control" type='text' required='required' name='name' maxlength='50' value="<?php echo set_value('name', isset($leagues->name) ? $leagues->name : ''); ?>" />
						<span class='help-inline'><?php echo form_error('name'); ?></span>
					</div>
				</div>
				
			    
				<div class="form-group<?php echo form_error('short_name') ? ' error' : ''; ?>">
						<?php echo form_label(lang('leagues_short_name') . lang('bf_form_label_required'), 'short_name', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-4">
						<input id='short_name'  class="form-control" type='text' required='required' name='short_name' maxlength='50' value="<?php echo set_value('short_name', isset($leagues->short_name) ? $leagues->short_name : ''); ?>" />
						<span class='help-inline'><?php echo form_error('short_name'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('sport_id') ? ' has-error' : ''; ?>">
					<label class="col-md-2 control-label"><?php echo lang('leagues_sport');?></label>
					<div class="col-md-4">
						<select name="sport_id" id="sport_id" class="form-control">
							<option data-name="" value=""><?php echo lang('leagues_select_sport');?></option>
							<?php foreach ($sports->result() as $row) {
								$sel = ($row->id==set_value('sport_id'))?'selected="selected"':'';
								?>
								<option data-name="<?php echo $row->name;?>" value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $row->name;?></option>
							<?php }?>
						</select>
						<span class='help-inline'><?php echo form_error('sport_id'); ?></span>
					</div>
				</div>
                
				<div class="championship">
					<div class="form-group<?php echo form_error('championship_id') ? ' has-error' : ''; ?>">
						<label class="col-md-2 control-label"><?php echo lang('leagues_championship');?></label>
						<div class="col-md-4">
							<select name="championship_id" id="championship_id" class="form-control">
								
							</select>
							 <span class="help-inline"><?php echo form_error('championship_id'); ?></span>
						</div>
					</div>
				</div>
				

				
				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('leagues_action_create'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/leagues', lang('leagues_cancel'), 'class="btn btn-warning"'); ?>
					
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	
<script type="text/javascript">
	var site_url = '<?php echo site_url();?>';
</script>	