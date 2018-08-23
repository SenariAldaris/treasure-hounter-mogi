<div class="box box-widget">
	<div class="box-body">
		<?php echo form_open(current_url(), 'class="form-inline"'); ?>
		
			<div class="row">
				<div class="col-sm-4">

						<label class="control-label col-sm-6" for='trans_lang' style="line-height: 34px;"><?php e(lang('translate_current_lang')); ?></label>
						<div class="col-sm-6">
							<select name="trans_lang" id="trans_lang" class="form-control">
								<?php foreach ($languages as $lang) : ?>
								<option value="<?php e($lang); ?>"<?php echo isset($trans_lang) && $trans_lang == $lang ? ' selected="selected"' : ''; ?>><?php e(ucfirst($lang)); ?></option>
								<?php endforeach; ?>
								<option value="other"><?php e(lang('translate_other')); ?></option>
							</select>
						</div>

				</div>	
				<div class="col-sm-5" id='new_lang_field' style='display: none;'>
					<div class="form-group">
						<label class="control-label col-sm-6" for='new_lang'style="line-height: 34px;"><?php e(lang('translate_new_lang')); ?></label>
						<div class="col-sm-6">
							<input class="form-control" type="text" name="new_lang" id="new_lang" value="<?php echo set_value('new_lang'); ?>" />
						</div>
					</div>
				</div>	
				<input type="submit" name="select_lang" class="btn  btn-primary" value="<?php e(lang('translate_select')); ?>" />

			</div>	
		<?php echo form_close(); ?>
	</div>	
</div>
<!-- Core -->

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

		
			<h3><?php echo lang('translate_core'); ?> <span class="subhead"><?php echo count($lang_files) . ' ' . lang('bf_files'); ?></span></h3>
			<div class="divider-4 mtn mbn"></div>
			<?php
			$linkUrl = site_url(SITE_AREA . "/settings/translate/edit/{$trans_lang}");
			$cnt = 1;
			$brk = 3;
			foreach ($lang_files as $file) :
				if ($cnt == 1) :
			?>
			<div class="row">
				
				<?php
				endif;
				++$cnt;
				?>
				<div class="col-sm-4">
					<ul class="nav nav-stacked">
						<li><a class='text-blue' href='<?php echo "{$linkUrl}/{$file}"; ?>'><?php e($file); ?></a></li>
					</ul>
				</div>
				<?php
				if ($cnt > $brk) :
				?>

			</div>
			<?php
					$cnt = 1;
				endif;
			endforeach;
			if ($cnt != 1) :
			?>
			</div>
			<?php endif; ?>


		
		
			<h3><?php echo lang('translate_modules').((! empty($modules) && is_array($modules))?' <span class="subhead">'.count($modules).' '.lang('bf_files').'</span>':''); ?></h3>
			<div class="divider-4 mtn mbn"></div>
			<?php
			if (! empty($modules) && is_array($modules)) :
				$linkUrl = site_url(SITE_AREA . "/settings/translate/edit/{$trans_lang}");
				$cnt = 1;
				$brk = 3;
				foreach ($modules as $file) :
					if ($cnt == 1) :
			?>
			<div class="row">
				<?php
					endif;
					$cnt++;
				?>
				<div class="col-sm-4">
					<ul class="nav nav-stacked">
						<li><a class='text-blue' href='<?php echo "{$linkUrl}/{$file}"; ?>'><?php e($file); ?></a></li>
					</ul>
				</div>
				<?php if ($cnt > $brk) : ?>
			</div>
			<?php
						$cnt = 1;
					endif;
				endforeach;
				if ($cnt != 1) :
				?>
            </div>
			<?php
				endif;
			else :
			?>
			<div class="alert alert-info fade in">
				<a class="close" data-dismiss="alert">&times;</a>
				<?php echo lang('translate_no_modules'); ?>
			</div>
			<?php endif; ?>
		</div>	
	</div>	