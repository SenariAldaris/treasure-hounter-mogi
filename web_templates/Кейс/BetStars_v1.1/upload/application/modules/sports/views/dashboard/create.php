
<?php if (validation_errors()) : ?>

<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('sports_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php endif;

$id = isset($sports->id) ? $sports->id : ''; ?>



	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title col-md-8">
				<?php if (isset($toolbar_title)) : ?>
				<?php echo $toolbar_title; ?>
				<?php endif; ?>
			</h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
				  <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/sports/create" id="create_new"><?php echo lang('bf_new'); ?></a>
				  <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/sports" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->

		<!-- form start -->
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		  
			<div class="box-body">
				<div class="form-group <?php echo form_error('name') ? ' error' : ''; ?>">

					<?php echo form_label(lang('sports_name') . lang('bf_form_label_required'), 'name', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-3">
						<input id='name' class="form-control" type='text' placeholder="<?php echo lang('sports_name');?>" required='required' name='name' maxlength='50' value="<?php echo set_value('name', isset($sports->name) ? $sports->name : ''); ?>" />
						<span class='help-inline'><?php echo form_error('name'); ?></span>
					</div>
				</div>
				<div class="form-group<?php echo form_error('icon') ? ' has-error' : ''; ?>">
					<?php echo form_label(lang('sports_icon'), 'icon', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-4">
						<input type="file" name="icon" id="file">
						<div class="dummyfile">
							<div class="input-group input-group">
								<input id="filename" type="text" class="form-control" name="file-name">
								<span class="input-group-btn">
								  <button id="fileselectbutton" class="btn btn-blue" type="button"><?php echo lang('bf_action_select'); ?></button>
								</span>
							</div>
						</div>	
						<span class='help-block'><?php echo form_error('icon'); ?></span>
					</div>
				</div>			  


				
				<?php 
					$data = array(
						'name' => 'active',
						'class' => 'form-control',
					);
					$options = array(
						'1' => lang('bf_active'),
						'0' => lang('bf_inactive'),
					);

					echo form_dropdown_custom( $data, $options, set_value('active', isset($sports->active) ? $sports->active : ''), lang('sports_active'). lang('bf_form_label_required'));
				?>

				<div class="box-footer">
					<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('sports_action_create'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/sports', lang('sports_cancel'), 'class="btn btn-warning"'); ?>

				</div>
			<?php echo form_close(); ?>
		</div>
	</div>	
