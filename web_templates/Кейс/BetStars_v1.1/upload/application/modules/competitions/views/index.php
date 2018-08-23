	<div class="box">
		<div class="box-body">
			<h4 class="head text-left mb10 pl20 fs14"><?php echo lang('competitions_competitions');?></h4>	

			
			
			<ul class="nav nav-tabs mb15">
				<li class="active"><a href="#active" data-toggle="tab" aria-expanded="true"><?php echo lang('competitions_active'); ?></a></li>
				<li class=""><a href="#inactive" data-toggle="tab" aria-expanded="true"><?php echo lang('competitions_ended'); ?></a></li>
			</ul>
			<div class="tab-content">	
				<div class="tab-pane active fade in" id="active">
					<?php if (isset($active) && is_array($active) && count($active)) : ?>
					<div class='table-responsive'>
						<table class='table table-striped'>
							<thead class="bg-black">
								<tr>						
									<th class="pn"><?php echo lang('competitions_field_name'); ?></th>
									<th class="pn"><?php echo lang('competitions_field_start_date'); ?></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('competitions_field_end_date'); ?></th>
									<th class="pn"><?php echo lang('competitions_field_price_pool'); ?></th>
									<th class="pn"><?php echo lang('competitions_field_sponsored_by'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($active as $active_record) :
								?>
								<tr>

									<td class="text-left pl20">
										<?php if($active_record->sport_id != 0):?>
										<img class="h24 mtm2 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($active_record->sport_id)); ?>"/>
										<?php endif; ?>
										<?php if($active_record->league_id != 0):?>
										<?php $country_id = $this->leagues_model->get_league_country_by_id($active_record->league_id);?>
										<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
										<?php endif; ?>										
										<a href="<?php echo base_url();?>competitions/view/<?php e($active_record->id); ?>"><?php e($active_record->name); ?>
									</td>
									<td>
										<?php echo date('M d,Y', strtotime($active_record->start_date)); ?>
									</td>
									<td>	
										<span class="mh10">-</span>
									</td>
									<td>
										<?php echo date('M d,Y', strtotime($active_record->end_date)); ?>
									</td>
									<td><?php e($active_record->price_pool); ?><span class="ml5"><?php echo $active_record->currency;?></span></td>

									<td><img class="h30" src="<?php echo base_url();?>uploads/bookmakers/<?php e($this->bookmakers_model->get_bookmaker_logo_by_id($active_record->sponsored_by)); ?>"/></td>


								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php endif; ?>
				</div>

				<div class="tab-pane fade in" id="inactive">
					<?php if (isset($inactive) && is_array($inactive) && count($inactive)) : ?>
					<div class='table-responsive'>
						<table class='table table-striped'>
							<thead class="bg-black">
								<tr>						
									<th class="pn"><?php echo lang('competitions_field_name'); ?></th>

									<th class="pn"><?php echo lang('competitions_field_start_date'); ?></th>
									<th class="pn"></th>
									<th class="pn"><?php echo lang('competitions_field_end_date'); ?></th>
									<th class="pn"><?php echo lang('competitions_field_sponsored_by'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($inactive as $inactive_record) :
								?>
								<tr>


									<td>
									<?php if($inactive_record->sport_id != 0):?>
										<img class="h30" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($inactive_record->sport_id)); ?>"/>
										<?php endif; ?>
										<a href="<?php echo base_url();?>competitions/view/<?php e($inactive_record->id); ?>"><?php e($inactive_record->name); ?>
									</td>

									<td>
										<?php echo date('M d,Y', strtotime($inactive_record->start_date)); ?>
									</td>
									<td>	
										<span class="mh10">-</span>
									</td>
									<td>
										<?php echo date('M d,Y', strtotime($inactive_record->end_date)); ?>
									</td>
									<td><img class="h30" src="<?php echo base_url();?>uploads/bookmakers/<?php e($this->bookmakers_model->get_bookmaker_logo_by_id($inactive_record->sponsored_by)); ?>"/></td>


								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php endif; ?>
				</div>
				
		</div>
	</div>	
	
	<?php echo $this->bookmakers_model->get_bookmaker_banner_full();?>