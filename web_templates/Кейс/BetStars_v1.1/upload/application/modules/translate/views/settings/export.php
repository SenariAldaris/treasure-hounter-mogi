
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
				
		<div class="box-body">
		
			<p class="intro"><?php echo lang('translate_export_note'); ?></p>
		
			<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>

					<div class="form-group">
						<label for="export_lang" class="control-label col-sm-2"><?php echo lang('translate_language'); ?></label>
						<div class="col-sm-4">
							<select name="export_lang" class="form-control" id="export_lang">
								<?php foreach ($languages as $lang) : ?>
								<option value="<?php e($lang); ?>" <?php echo isset($trans_lang) && $trans_lang == $lang ? 'selected="selected"' : '' ?>><?php e(ucfirst($lang)); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?php echo lang('translate_include'); ?></label>
						<div class="col-sm-4">
							<div class="checkbox">
								<label for="include_core">
									<input type="checkbox" id="include_core" name="include_core" value="1" checked="checked" />
									<?php echo lang('translate_include_core'); ?>
								</label>
								<label for="include_mods">
									<input type="checkbox" id="include_mods" name="include_mods" value="1" />
									<?php echo lang('translate_include_mods'); ?>
								</label>
							</div>
						</div>
					</div>

				<div class="box-footer">
					<input type="submit" name="export" class="btn btn-blue" value="<?php e(lang('translate_export_short')); ?>" />
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>	