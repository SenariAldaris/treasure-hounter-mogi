	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					<a class="btn btn-xs btn-blue" href="<?php echo site_url();?>admin/settings/translate"><?php echo lang('translate_translate'); ?></a>
					<a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/settings/translate/export"><?php echo lang('translate_export_short'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->

		<?php
		if (! empty($orig) && is_array($orig)) :
			echo form_open(current_url(), 'class="form-horizontal" id="translate_form"');
		?>
			
			<div class="box-body">
				<input type="hidden" name="trans_lang" value="<?php e($trans_lang); ?>" />

						<?php if (count($orig) > 30) : ?>
						<button class="gobottom pull-right btn btn-primary"><i class="fa fa-arrow-down"></i></button>
						<?php endif; ?>
						<h3><?php echo lang('translate_file'); ?>: <span class='filename'><?php echo $lang_file; ?></span></h3>

					<div class="table-responsive">
						<table id="lang_table" class='table table-striped'>
							<thead>
								<tr>
									<th class="column-check w20"><input id="check-all" type="checkbox" /></th>
									<th class='text-left'><?php echo ucwords($orig_lang); ?></th>
									<th><?php echo ucwords($trans_lang); ?></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($orig as $key => $val) : ?>
								<tr>
									<td class='column-check w20'><input type='checkbox' name='checked[]' value="<?php echo $key; ?>" <?php echo in_array($key, $chkd) ? "checked='checked' " : ''; ?>/></td>
									<td><label class="control-label" for="lang<?php echo $key; ?>"><?php e($val); ?></label></td>
									<td style="width:60%">
										<?php if (strlen($val) < 80) : ?>
										<input type="text" class="form-control" name="lang[<?php echo $key; ?>]" id="lang<?php echo $key; ?>" value="<?php e(isset($new[$key]) ? $new[$key] : ''); ?>" />
										<?php else : ?>
										<textarea class="form-control" name="lang[<?php echo $key; ?>]" id="lang<?php echo $key; ?>"><?php e(isset($new[$key]) ? $new[$key] : ''); ?></textarea>
										<?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>	
			</div>
			
			<div class="box-footer">
				<input type="submit" name="save" class="btn btn-primary" value="<?php e(lang('bf_action_save')); ?>" />
				<a class="btn btn-warning" href="<?php
					echo site_url(SITE_AREA . '/settings/translate/index') . '/';
					e($trans_lang); ?>"><?php e(lang('bf_action_cancel')); ?></a>

						<?php 
						
						if (count($orig) > 30) :?>
						
						<button class="gotop pull-right btn btn-primary"><i class="fa fa-arrow-up"></i></button>
						
					<?php endif; ?>
			</div>
		<?php echo form_close();
			endif;?>
	</div>

<script type="text/javascript">
    //Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#lang_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
</script>	