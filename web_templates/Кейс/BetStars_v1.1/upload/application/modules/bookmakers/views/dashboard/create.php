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
				
				<div class="form-group<?php echo form_error('logo') ? ' has-error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_logo'), 'logo', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-4">
						<input type="file" name="logo" id="file">
						<div class="dummyfile">
							<div class="input-group input-group">
								<input id="filename" type="text" class="form-control" name="file-name">
								<span class="input-group-btn">
								  <button id="fileselectbutton" class="btn btn-blue" type="button"><?php echo lang('bf_action_select'); ?></button>
								</span>
							</div>
						</div>	
						<span class='help-block'><?php echo form_error('logo'); ?></span>
					</div>
				</div>

				
				<div class="form-group<?php echo form_error('url') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_url') . lang('bf_form_label_required'), 'url', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-8'>
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
					<div class='col-sm-10'>
						<textarea class="textarea" name="review" id="review" placeholder="Bookmaker Review" style="height: 600px; font-size: 14px; line-height: 24px; border: 1px solid #dddddd; padding: 10px;">
						<?php echo set_value('review', isset($bookmakers->review) ? $bookmakers->review : ''); ?>
						</textarea>
						
						<span class='help-inline'><?php echo form_error('review'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('banner') ? ' has-error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_banner'), 'banner', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-4">
						<input type="file" name="banner" id="file2">
						<div class="dummyfile">
							<div class="input-group input-group">
								<input id="filename2" type="text" class="form-control" name="file-name">
								<span class="input-group-btn">
								  <button id="fileselectbutton2" class="btn btn-blue" type="button"><?php echo lang('bf_action_select'); ?></button>
								</span>
							</div>
						</div>	
						<span class='help-block'><?php echo form_error('banner'); ?></span>
					</div>
				</div>
				
				<div class="form-group<?php echo form_error('banner_url') ? ' error' : ''; ?>">
					<?php echo form_label(lang('bookmakers_banner_url') . lang('bf_form_label_required'), 'banner_url', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-8'>
						<input id='banner_url' class="form-control" type='text' required='required' name='banner_url' maxlength='50' value="<?php echo set_value('banner_url', isset($bookmakers->banner_url) ? $bookmakers->banner_url : ''); ?>" />
						<span class='help-inline'><?php echo form_error('banner_url'); ?></span>
					</div>
				</div>				
				
				<?php 
					$data = array(
						'name' => 'banner_type',
						'class' => 'form-control',
					);
					$options = array(
						'0' => lang('bookmakers_banner_type'),
						'1' => lang('bookmakers_sidebar'),
						'2' => lang('bookmakers_full'),
					);

					echo form_dropdown_custom( $data, $options, set_value('banner_type', isset($bookmakers->banner_type) ? $bookmakers->banner_type : ''), lang('bookmakers_banner_type'));
				?>
				<div id="side">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="banner_type"></label>
						<div class="col-sm-10">
							<?php echo lang('bookmakers_add_code'); ?>
							<span class='help-inline'><code>echo $this->bookmakers_model->get_bookmaker_banner_sidebar();</code></span>
						</div>
					</div>
				</div>
				<div id="full">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="banner_type"></label>
						<div class="col-sm-10">
							<?php echo lang('bookmakers_add_code'); ?>
							<span class='help-inline'><code>echo $this->bookmakers_model->get_bookmaker_banner_full();</code></span>
						</div>
					</div>
				</div>

				
				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('bookmakers_action_edit'); ?>" />
		
					<?php echo anchor(SITE_AREA . '/dashboard/bookmakers', lang('bookmakers_cancel'), 'class="btn btn-yellow"'); ?>
					
					<?php if ($this->auth->has_permission('Bookmakers.Content.Delete')) : ?>

						<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('bookmakers_delete_confirm'))); ?>');">
							<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('bookmakers_delete_record'); ?>
						</button>
					<?php endif; ?>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>	