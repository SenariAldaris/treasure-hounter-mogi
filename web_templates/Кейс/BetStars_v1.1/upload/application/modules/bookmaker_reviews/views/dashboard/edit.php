<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('bookmaker_reviews_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($bookmaker_reviews->id) ? $bookmaker_reviews->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/bookmaker_reviews" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
       
				<div class="form-group">
				<?php echo form_label(lang('bookmaker_reviews_bookmaker') , 'bookmaker_id', array('class' => 'col-md-2 control-label') ); ?>
					<div class="col-sm-4">
						<input id="bookmaker_id" type="hidden" name="bookmaker_id" value="<?php echo set_value('bookmaker_id', isset($bookmaker_reviews->bookmaker_id) ? $bookmaker_reviews->bookmaker_id : ''); ?>"/>	
						<img class="h30" src="<?php echo base_url();?>uploads/bookmakers/<?php echo $this->bookmakers_model->get_bookmaker_logo_by_id($bookmaker_reviews->bookmaker_id);?>">						
					</div>
				</div>
				
				<div class="form-group<?php echo form_error('user_id') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmaker_reviews_reviewed_by') , 'user_id', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='user_id' type="hidden" type='text' required='required' name='user_id' maxlength='30' value="<?php echo set_value('user_id', isset($bookmaker_reviews->user_id) ? $bookmaker_reviews->user_id : ''); ?>" />
						<input class="form-control" type='text' value="<?php echo $this->tipsters_model->get_user_display_name_by_id($bookmaker_reviews->user_id);?>" disabled />						
						<span class='help-inline'><?php echo form_error('user_id'); ?></span>
					</div>
				</div>
				
				<div class="form-group">
				<?php echo form_label(lang('bookmaker_reviews_posted') , 'date_posted', array('class' => 'col-md-2 control-label') ); ?>
					<div class="col-sm-4">
						<input id="date_posted" type="hidden" name="date_posted" value="<?php echo set_value('date_posted', isset($bookmaker_reviews->date_posted) ? $bookmaker_reviews->date_posted : ''); ?>"/>	
						<input class="form-control" type='text' value="<?php echo relative_time(strtotime($bookmaker_reviews->date_posted));?>" disabled />						
					</div>
				</div>
				
				<div class="form-group">
				<?php echo form_label(lang('bookmaker_reviews_rating') , 'rating', array('class' => 'col-md-2 control-label') ); ?>
					<div class="col-sm-4">
						<input id="rating" type="hidden" name="rating" value="<?php echo set_value('rating', isset($bookmaker_reviews->date_posted) ? $bookmaker_reviews->rating : ''); ?>"/>	
						<input class="form-control" type='text' value="<?php echo $bookmaker_reviews->rating;?>" disabled />						
					</div>
				</div>

				<div class="form-group<?php echo form_error('description') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmaker_reviews_review') . lang('bf_form_label_required'), 'description', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-6'>
						<textarea class="textarea" name="description" id="description" class="form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
						<?php echo set_value('description', e(isset($bookmaker_reviews->description) ? $bookmaker_reviews->description : '')); ?>
						</textarea>
						
						<span class='help-inline'><?php echo form_error('description'); ?></span>
					</div>
				</div>

					<?php 
							$data = array(
								'name' => 'status',
								'class' => 'form-control',
							);
							$options = array(
								'1' => lang('bookmaker_reviews_approved'),
								'0' => lang('bookmaker_reviews_pending'),
							);

							echo form_dropdown_custom( $data, $options, set_value('status', isset($bookmaker_reviews->status) ? $bookmaker_reviews->status : ''), lang('bookmaker_reviews_status'). lang('bf_form_label_required'));
					?>
						
				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('bookmaker_reviews_action_edit'); ?>" />
		
					<?php echo anchor(SITE_AREA . '/dashboard/bookmaker_reviews', lang('bookmaker_reviews_cancel'), 'class="btn btn-yellow"'); ?>
					
					<?php if ($this->auth->has_permission('Bookmakers.Content.Delete')) : ?>

						<button type='submit' name='delete' formnovalidate class='btn btn-red' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('bookmaker_reviews_delete_confirm'))); ?>');">
							<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('bookmaker_reviews_delete_record'); ?>
						</button>
					<?php endif; ?>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>	