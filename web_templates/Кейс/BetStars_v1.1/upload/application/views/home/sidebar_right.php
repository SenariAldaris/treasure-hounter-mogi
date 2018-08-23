	
	<!-- TIPS STATS -->
	<div class="col-sm-6">
	
		<div class="box">
			<div class="box-body">					
						
				<h4 class="head fs14 mb20"><?php echo lang('tips_tips_stats');?></h4>							
				
				
				<?php $total = $this->tips_model->count_all_ended_tips();
				
					$won = $this->tips_model->count_all_won_tips();
					$lost = $this->tips_model->count_all_lost_tips();
					$void = $this->tips_model->count_all_void_tips();
					
					if($total > 0) :
					
					$t_won = $won/$total*100;
					$t_lost = $lost/$total*100;
					$t_void = $void/$total*100;
					
					else:

					$t_won = 0;
					$t_lost = 0;
					$t_void = 0;
					
					endif;
				?>

				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_total');?></span>
					<span class="progress-number mr10"><?php echo $total;?></span>
					<div class="progress active">
						<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" 
							aria-valuemax="100" style="width: 100%">
							<span class="sr-only">100% Complete (success)</span>
						</div>
					</div>
				</div><!-- /.progress-group -->
										  
				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_tips_won');?><span class="text-green ml20"><?php echo round($t_won, 2);?> % </span></span>
					<span class="progress-number mr10"><b><?php echo $won;?></b>/<?php echo $total;?></span>
					<div class="progress active">
					  <div class="progress-bar progress-bar-success progress-bar-striped" style="width: <?php echo round($t_won, 2);?>%">
						<span class="sr-only"><?php echo round($t_won, 2);?>% Complete (success)</span>
					  </div>
					</div>
				</div><!-- /.progress-group -->
				 
				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_tips_lost');?><span class="text-red ml20"><?php echo round($t_lost, 2);?> % </span></span>
					<span class="progress-number mr10"><b><?php echo $lost;?></b>/<?php echo $total;?></span>
					<div class="progress active">
					  <div class="progress-bar progress-bar-red progress-bar-striped" style="width:<?php echo round($t_lost, 2);?>%">
						<span class="sr-only"><?php echo round($t_lost, 2);?>% Complete (success)</span>
					  </div>
					</div>
				</div><!-- /.progress-group -->
				 
				<div class="progress-group">
					<span class="progress-text"><?php echo lang('tips_tips_voided');?><span class="text-yellow ml20"><?php echo round($t_void, 2);?> % </span></span>
					<span class="progress-number mr10"><b><?php echo $void;?></b>/<?php echo $total;?></span>
					<div class="progress active mbn">
					  <div class="progress-bar progress-bar-yellow  progress-bar-striped" style="width: <?php echo round($t_void, 2);?>%">
						<span class="sr-only"><?php echo round($t_void, 2);?>% Complete (success)</span>
					  </div>
					</div>
				</div><!-- /.progress-group -->

			</div>
		</div>
	
	</div>
	
	<!-- /.TIPS STATS -->
	
	

	
	
	<!-- POPULAR BOOKIES -->
	<div class="col-sm-6">
	
		<div class="box">
		
			<div class="box-body pbn">
				<h4 class="head fs14"><?php echo lang('tips_popular_bookies'); ?></h4>	
			
				<ul class="list-group list-group-unbordered">
					<?php if(isset($bookie_counts) && is_array($bookie_counts) && count($bookie_counts)):
					
					foreach ($bookie_counts as $record) : ?>			
					<li class="list-group-item">
						<img src="<?php echo base_url();?>uploads/bookmakers/<?php echo $this->bookmakers_model->get_bookmaker_logo_by_id($record->bookmaker_id); ?> " class="h30 mr10"/>
						<a href=""><?php echo $this->bookmakers_model->get_bookmaker_name_by_id($record->bookmaker_id) ?></a>
						
						<span class="pull-right text-blue mr10">(
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
						<span class="pull-right mr10">Bets</span>
					</li>
					<?php endforeach; endif;?>
				</ul>
			</div>
			<!-- Box Footer -->
			<div class="box-footer bg-white">
				<a href="<?php echo base_url();?>bookmakers" class="btn btn-clean btn-block"><?php echo lang('tips_view_all_bookies'); ?></a>
			</div>
		</div>		
	
	</div>
	<!-- /.POPULAR BOOKIES -->