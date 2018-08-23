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

				<div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_name') . lang('bf_form_label_required'), 'name', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='name' class="form-control" type='text' required='required' name='name' value="<?php echo set_value('name', isset($competitions->name) ? $competitions->name : ''); ?>" />
						<span class='help-block'><?php echo form_error('name'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('sport_id') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_sport'), 'sport', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<select name="sport_id" id="sport_id" class="form-control">
							<option value="0"><?php echo lang('competitions_select_sport');?></option>
							<?php foreach ($sports->result() as $row) {
								$sel = ($row->id==set_value('sport_id'))?'selected="selected"':'';
								?>
								<option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $row->name;?></option>
							<?php }?>
						</select>
						<span class='help-block'><?php echo form_error('sport_id'); ?></span>
					</div>
				</div>

				<div class="league">
					<div class="form-group<?php echo form_error('league_id') ? ' has-error' : ''; ?>">
						<label class="col-md-2 control-label"><?php echo lang('competitions_field_league');?></label>
						<div class="col-md-4">
							<select name="league_id" id="league_id" class="form-control select2">
								
							</select>
							<span class='help-block'><?php echo form_error('league_id'); ?></span>
						</div>
					</div>
				</div>
						
				<div class="form-group<?php echo form_error('description') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_description') . lang('bf_form_label_required'), 'description', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => 'form-control', 'value' => set_value('description', isset($competitions->description) ? $competitions->description : ''), 'required' => 'required')); ?>
						<span class='help-block'><?php echo form_error('description'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('start_date') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_start_date') . lang('bf_form_label_required'), 'start_date', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='start_date' class="form-control" type='text' required='required' name='start_date'  value="<?php echo set_value('start_date', isset($competitions->start_date) ? $competitions->start_date : ''); ?>" />
						<span class='help-block'><?php echo form_error('start_date'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('end_date') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_end_date') . lang('bf_form_label_required'), 'end_date', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='end_date' class="form-control" type='text' required='required' name='end_date'  value="<?php echo set_value('end_date', isset($competitions->end_date) ? $competitions->end_date : ''); ?>" />
						<span class='help-block'><?php echo form_error('end_date'); ?></span>
					</div>
				</div>

				<div class="form-group<?php echo form_error('price_pool') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_price_pool') . lang('bf_form_label_required'), 'price_pool', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='price_pool' class="form-control" type='text' required='required' name='price_pool' maxlength='5' value="<?php echo set_value('price_pool', isset($competitions->price_pool) ? $competitions->price_pool : ''); ?>" />
						<span class='help-block'><?php echo form_error('price_pool'); ?></span>
					</div>
				</div>
				
				<div class="form-group<?php echo form_error('currency') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_currency') . lang('bf_form_label_required'), 'currency', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='currency' class="form-control" type='text' required='required' name='currency' maxlength='100' value="<?php echo set_value('currency', isset($competitions->currency) ? $competitions->currency : ''); ?>" />
						<span class='help-block'><?php echo form_error('currency'); ?></span>
					</div>
				</div>	
				
				<div class="form-group<?php echo form_error('rewards') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_rewards') . lang('bf_form_label_required'), 'rewards', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='rewards' class="form-control" type='text' required='required' name='rewards' maxlength='100' value="<?php echo set_value('rewards', isset($competitions->rewards) ? $competitions->rewards : ''); ?>" />
						<span class='help-block'><?php echo form_error('rewards'); ?></span>
					</div>
				</div>


				<?php $options = $bookmakers;

					echo form_dropdown_custom( 'sponsored_by', $options, set_value('sponsored_by', isset($competitions->sponsored_by) ? $competitions->sponsored_by : ''), lang('competitions_field_sponsored_by'). lang('bf_form_label_required'), 'class="form-control"');
				?>
				
				<div class="form-group<?php echo form_error('min_tips') ? ' error' : ''; ?>">
					<?php echo form_label(lang('competitions_field_min_tips') . lang('bf_form_label_required'), 'min_tips', array('class' => 'control-label col-sm-2')); ?>
					<div class='col-sm-4'>
						<input id='min_tips' class="form-control" type='text' required='required' name='min_tips' maxlength='30' value="<?php echo set_value('min_tips', isset($competitions->min_tips) ? $competitions->min_tips : ''); ?>" />
						<span class='help-block'><?php echo form_error('min_tips'); ?></span>
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

					echo form_dropdown_custom( $data, $options, set_value('active', isset($competitions->active) ? $competitions->active : ''), lang('competitions_field_active'). lang('bf_form_label_required'));
				?>
			
				<div class='box-footer'>
					<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('competitions_action_create'); ?>" />
					<?php echo anchor(SITE_AREA . '/dashboard/competitions', lang('competitions_cancel'), 'class="btn btn-warning"'); ?>
					
				</div>
			<?php echo form_close(); ?>

		</div>	
	</div>
	
<script type="text/javascript">
	var site_url = '<?php echo site_url();?>';
</script>	