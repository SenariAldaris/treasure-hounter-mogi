<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('bookmakers_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($bookmakers->id) ? $bookmakers->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/bookmakers/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/bookmakers" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
    		<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>

            

				<div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_name') . lang('bf_form_label_required'), 'name', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='name' class="form-control" type='text' required='required' name='name' maxlength='30' value="<?php echo set_value('name', isset($bookmakers->name) ? $bookmakers->name : ''); ?>" />
						<span class='help-inline'><?php echo form_error('name'); ?></span>
					</div>
				</div>
				
					<div class="form-group<?php echo form_error('logo') ? ' error' : ''; ?>">
						<?php echo form_label(lang('bookmakers_logo') . lang('bf_form_label_required'), 'logo', array('class' => 'col-sm-2 control-label col-sm-2')); ?>
						<div class="col-sm-3">
							<input type="file" name="logo" id="file">
							<div class="dummyfile">
								<div class="input-append">
									<input id="filename" type="text" class="input form-control" name="file-name">
									<a id="fileselectbutton" class="btn btn-blue">Select</a>
								</div>
							</div>
							<span class='help-inline'><?php echo form_error('logo'); ?></span>
						</div>
					</div>
				
				<div class="form-group<?php echo form_error('url') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_url') . lang('bf_form_label_required'), 'url', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='url' class="form-control" type='text' required='required' name='url' maxlength='50' value="<?php echo set_value('url', isset($bookmakers->url) ? $bookmakers->url : ''); ?>" />
						<span class='help-inline'><?php echo form_error('url'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('bonus_offer') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_bonus_offer'), 'bonus_offer', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='bonus_offer' class="form-control" type='text' name='bonus_offer' maxlength='30' value="<?php echo set_value('bonus_offer', isset($bookmakers->bonus_offer) ? $bookmakers->bonus_offer : ''); ?>" />
						<span class='help-inline'><?php echo form_error('bonus_offer'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('bonus_code') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_bonus_code'), 'bonus_code', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='bonus_code' class="form-control" type='text' name='bonus_code' maxlength='255' value="<?php echo set_value('bonus_code', isset($bookmakers->bonus_code) ? $bookmakers->bonus_code : ''); ?>" />
						<span class='help-inline'><?php echo form_error('bonus_code'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('review') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_review') . lang('bf_form_label_required'), 'review', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-8'>
						<textarea class="textarea" name="review" id="review" placeholder="Bookmaker Review" style="width: 100%; height: 100%; font-size: 14px; line-height: 24px; border: 1px solid #dddddd; padding: 10px;"></textarea>
						
						<span class='help-inline'><?php echo form_error('review'); ?></span>
					</div>
				</div>
        
				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('bookmakers_action_create'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/bookmakers', lang('bookmakers_cancel'), 'class="btn btn-warning"'); ?>
					
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>