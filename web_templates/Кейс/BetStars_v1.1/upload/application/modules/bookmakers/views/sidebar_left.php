<div class="box">
	
        <div class="box-body pbn">
			<h4 class="head text-center fs14"><?php echo lang('bookmakers_popular_bookies'); ?></h4>	

        
			<ul class="list-group list-group-unbordered">
				<?php if(isset($bookie_counts) && is_array($bookie_counts) && count($bookie_counts)):
				
				foreach ($bookie_counts as $record) : ?>			
				<li class="list-group-item">
					<img src="<?php echo base_url();?>uploads/bookmakers/<?php echo $this->bookmakers_model->get_bookmaker_logo_by_id($record->bookmaker_id); ?> " class="h30 mr10"/>

					<a href="<?php echo base_url();?>bookmakers/view/<?php echo $record->bookmaker_id;?>"><?php echo $this->bookmakers_model->get_bookmaker_name_by_id($record->bookmaker_id) ?></a>
                    
					<span class="pull-right text-blue">(
				      <?php $count = 0;
						    foreach ($bookie_counts as $r)
						    {
							    if ($record->bookmaker_id == $r->bookmaker_id)
							    {
								  $count = $r->count;
							    }
						    }
						  echo $count; ?>
					)</span>
					<span class="pull-right mr10"><?php echo lang('bookmakers_bets'); ?></span>
				</li>
				<?php endforeach; endif;?>
			</ul>
		</div>
		<!-- Box Footer -->
		<div class="box-footer clearfix"></div>
	</div>