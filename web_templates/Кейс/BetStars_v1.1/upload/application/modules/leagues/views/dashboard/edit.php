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

$id = isset($leagues->league_id) ? $leagues->league_id : '';
?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/leagues" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->
		
		<div class="box-body">	
			<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>

				<div class="form-group">				
					<?php echo form_label(lang('leagues_name') . lang('bf_form_label_required'), 'league_name', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-4">
						<input id='league_name' type='hidden' name='league_name' value="<?php echo $leagues->league_name; ?>"/>
						<input id='league_name' class="form-control" type='text' name='league_name' value="<?php echo $leagues->league_name; ?>" disabled />
					</div>
				</div>
				
				<div class="form-group">
					<?php echo form_label(lang('leagues_sport') . lang('bf_form_label_required'), 'sport_id', array('class' => 'col-sm-2 control-label')); ?>
					<div class="col-sm-4">
						<input id='sport_id' type='hidden' name='sport_id' value="<?php echo $leagues->sport_id; ?>"/>
						<?php $sport = $this->sports_model->get_sport_name_by_id($leagues->sport_id); ?>
						<input id='league_name' class="form-control" type='text' name='league_name' value="<?php echo $sport; ?>" disabled />
					</div>
				</div>
				
				
				<?php $options =  $countries;
					echo form_dropdown_custom('country_id', $options, set_value('country_id', isset($leagues->country_id) ? $leagues->country_id : ''), lang('leagues_country'). lang('bf_form_label_required'),  'class="form-control"');
				?>


	            <div class="col-sm-12">
					<div class='box-footer'>
						<input type='submit' name='save' class='btn btn-blue' value="<?php echo lang('leagues_action_edit'); ?>" />
						<?php echo anchor(SITE_AREA . '/dashboard/leagues', lang('leagues_cancel'), 'class="btn btn-yellow"'); ?>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	
<script type="text/javascript">
	var site_url = '<?php echo site_url();?>';
</script>		