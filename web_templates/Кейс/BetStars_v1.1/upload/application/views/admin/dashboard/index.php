	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
		</div><!-- /.box-header -->
	</div>		
		
<?php

$roleCount = array();
foreach ($role_counts as $r) {
    $roleCount[$r->role_name] = $r->count;
}

?>

<?php $last_update = $this->bet_events_model->get_last_update();?>

	<div class="row">
	
	
		<div class="col-md-6">
			<div class="box">			
				<div class="box-body">
					<h4 class="head fs14 mb10"><?php echo lang('bf_bs_version');?></h4>	

					<ul class="list-group list-group-unbordered">

					
						<li class="list-group-item">
							<?php $current_version =  BS_VERSION;?>
							<?php $latest_version = file_get_contents('http://codauris.com/demo/bs/version.php')?>

							<span class="pl20"><?php echo lang('bf_bs_current_version');?></span>
						   
							<span class="text-blue pull-right mr10">								
								<?php echo $current_version;?>
							</span>
					    </li>
						
						<?php if($latest_version > $current_version):?>
						<li class="list-group-item">
							<span class="pl20 mr20"><?php echo lang('bf_bs_latest_version');?></span>
							
							<span class="text-blue pull-right mr10">								
								<span class="mr30"><?php echo $latest_version;?></span>
								<a class="btn btn-clean" href="http://codauris.com/demo/bs/updates">
									<?php echo lang('bf_bs_get_updates');?>
								</a>
							</span>
					    </li>
						<?php else:?>
						<li class="list-group-item">
							<span class="pl20"><?php echo lang('bf_bs_latest_version');?></span>
							
							<span class="text-blue pull-right mr10">								
								<?php echo lang('bf_bs_version_up_to_date');?>
							</span>
					    </li>
						<?php endif;?>						
					</ul>  

				</div>
			</div>
		</div>		
	

		<div class="col-md-6">
			<div class="box">
				<div class="box-body">
					<h4 class="head fs14 mb10"><?php echo lang('bf_last_db_update');?></h4>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<span class="pl20"><?php echo lang('bf_date');?></span>
							<span class="text-blue pull-right mr10"><?php echo date('M d, Y', strtotime($last_update));?></span>
						</li>
						<li class="list-group-item">
							<span class="pl20"><?php echo lang('bf_time');?></span>
							<span class="text-blue pull-right mr10"><?php echo date('H:i:s', strtotime($last_update));?></span>
						</li>						
					</ul>	
				</div>
			</div>
		</div>

	</div>

	
	<div class="box">
		<div class="box-body">
			<h4 class="head fs14 mb10"><?php echo lang('tips_summary');?></h4>	


			<?php $total_stake = $this->tips_model->count_total_stake();
				  $total_profit = $this->tips_model->count_total_profit();
				  
				  if($total_stake > 0 ):
				  $total_yield = ($total_profit-$total_stake)/$total_stake*100;
				  else:
				  $total_yield = 0;
				  $total_stake = 0;
				  
				  endif;?>
			

			<div class="col-sm-4 prn">
				<div class="description-block">
					<span class="description-text-big mb10"><?php echo lang('tips_total_stake');?></span>
					<h5 class="description-header fs18 text-blue"><?php echo $total_stake;?></h5>
				</div><!-- /.description-block -->
			</div><!-- /.col -->
			
			<div class="col-sm-4 phn">
				<div class="description-block ">
					<span class="description-text-big mb10"><?php echo lang('tips_total_profit');?></span>
					<?php if ($total_profit <= 0 ):  ?>
						<h5 class="description-header fs18 text-red"><?php echo round($total_profit, 2);?></h5>							
					<?php else : ?>
						<h5 class="description-header fs18 text-green">+<?php echo round($total_profit, 2);?></h5>
					<?php endif; ?>
				</div><!-- /.description-block -->
			</div><!-- /.col -->
			
			<div class="col-sm-4 pln">
				<div class="description-block">
					<span class="description-text-big mb10"><?php echo lang('tips_total_yield');?></span>
					<?php if ($total_yield < 0 ):  ?>
						<h5 class="description-header fs18 text-red"><?php echo round($total_yield, 2);?> %</h5>						
					<?php else : ?>
						<h5 class="description-header fs18 text-green">+<?php echo round($total_yield, 2);?> %</h5>
					<?php endif; ?>
				</div><!-- /.description-block -->
			</div>
		</div>


	</div><!-- /.box -->
	
		
	<div class="row">
		<div class="col-md-6">
			<div class="box">
			
				<div class="box-body">
					<h4 class="head fs14 mb10"><?php echo lang('bf_total_users');?></h4>	
		
			
					<?php if (isset($role_counts) && is_array($role_counts) && count($role_counts)) : ?>
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<span class="pl20"><?php echo lang('role_account_type'); ?></span>
							
								<span class="pull-right mr10"># <?php echo lang('bf_users'); ?></span>
							</li>
							<?php foreach ($roles as $role) : ?>
							<li class="list-group-item">
								<span class="pl20"><?php echo $role->role_name; ?></span>
								<span class="text-blue pull-right mr10">
								<?php echo isset($roleCount[$role->role_name]) ? $roleCount[$role->role_name] : 0; ?>
								</span>
							</li>
							<?php endforeach; ?>
						</ul>

						<?php else : ?>
						<p><?php echo lang('role_no_roles'); ?></p>
						<?php endif; ?>
			
			
				</div>
			</div>

		</div>
		
		
		
		
		<div class="col-md-6">
			<div class="box">
			
				<div class="box-body">
					<h4 class="head fs14 mb10"><?php echo lang('bf_total_tips');?></h4>	
		
			
					<ul class="list-group list-group-unbordered">
						<?php if(isset($status_counts) && is_array($status_counts) && count($status_counts)):
								
							foreach ($status_counts as $record) :?>		
					
						<li class="list-group-item">


							<span class="pl20"><?php echo $record->name; ?></span>

						   
							<span class="text-blue pull-right mr10">
								 <?php $count = 0;
									foreach ($status_counts as $r)
									{
										if ($record->id == $r->id)
										{
											 $count = $r->count;
										}
									}
								 echo $count; ?>
							</span>

					   </li>
					   
					   <?php endforeach; 
					endif;?>
					</ul>  
			
			
				</div>
			</div>

		</div>	
		
		
		
		
		
		
		
		
		
		
		
	</div>	