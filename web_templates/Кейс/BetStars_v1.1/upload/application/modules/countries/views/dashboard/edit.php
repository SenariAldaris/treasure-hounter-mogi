<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('countries_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($countries->id) ? $countries->id : '';

?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/dashboard/countries/create" id="create_new"><?php echo lang('bf_new'); ?></a>
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/countries" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		
			<div class="box-body">	
            

				<div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_name') . lang('bf_form_label_required'), 'name', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='name' class="form-control" type='text' required='required' name='name' maxlength='200' value="<?php echo set_value('name', isset($countries->name) ? $countries->name : ''); ?>" />
						<span class='help-inline'><?php echo form_error('name'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('iso_alpha2') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_iso_alpha2') . lang('bf_form_label_required'), 'iso_alpha2', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='iso_alpha2' class="form-control" type='text' required='required' name='iso_alpha2' maxlength='2' value="<?php echo set_value('iso_alpha2', isset($countries->iso_alpha2) ? $countries->iso_alpha2 : ''); ?>" />
						<span class='help-inline'><?php echo form_error('iso_alpha2'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('iso_alpha3') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_iso_alpha3') . lang('bf_form_label_required'), 'iso_alpha3', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='iso_alpha3' class="form-control" type='text' required='required' name='iso_alpha3' maxlength='3' value="<?php echo set_value('iso_alpha3', isset($countries->iso_alpha3) ? $countries->iso_alpha3 : ''); ?>" />
						<span class='help-inline'><?php echo form_error('iso_alpha3'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('iso_numeric') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_iso_numeric') . lang('bf_form_label_required'), 'iso_numeric', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='iso_numeric' class="form-control" type='text' required='required' name='iso_numeric' maxlength='11' value="<?php echo set_value('iso_numeric', isset($countries->iso_numeric) ? $countries->iso_numeric : ''); ?>" />
						<span class='help-inline'><?php echo form_error('iso_numeric'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('currency_code') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_currency_code'), 'currency_code', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='currency_code' class="form-control" type='text' name='currency_code' maxlength='3' value="<?php echo set_value('currency_code', isset($countries->currency_code) ? $countries->currency_code : ''); ?>" />
						<span class='help-inline'><?php echo form_error('currency_code'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('currency_name') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_currency_name'), 'currency_name', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='currency_name' class="form-control" type='text' name='currency_name' maxlength='32' value="<?php echo set_value('currency_name', isset($countries->currency_name) ? $countries->currency_name : ''); ?>" />
						<span class='help-inline'><?php echo form_error('currency_name'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('currrency_symbol') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_currrency_symbol'), 'currrency_symbol', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='currrency_symbol' class="form-control" type='text' name='currrency_symbol' maxlength='3' value="<?php echo set_value('currrency_symbol', isset($countries->currrency_symbol) ? $countries->currrency_symbol : ''); ?>" />
						<span class='help-inline'><?php echo form_error('currrency_symbol'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('flag') ? ' error' : ''; ?>">
					<?php echo form_label(lang('countries_flag') . lang('bf_form_label_required'), 'flag', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='flag' class="form-control" type='text' required='required' name='flag' maxlength='6' value="<?php echo set_value('flag', isset($countries->flag) ? $countries->flag : ''); ?>" />
						<span class='help-inline'><?php echo form_error('flag'); ?></span>
					</div>
				</div>
			</div>
			<div class='box-footer'>
				<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('countries_action_edit'); ?>" />
				<?php echo anchor(SITE_AREA . '/dashboard/countries', lang('countries_cancel'), 'class="btn btn-yellow"'); ?>
				
				<?php if ($this->auth->has_permission('Countries.Content.Delete')) : ?>
					<button type='submit' name='delete' formnovalidate class='btn btn-red' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('countries_delete_confirm'))); ?>');">
						<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('countries_delete_record'); ?>
					</button>
				<?php endif; ?>
			</div>
		<?php echo form_close(); ?>
	</div>