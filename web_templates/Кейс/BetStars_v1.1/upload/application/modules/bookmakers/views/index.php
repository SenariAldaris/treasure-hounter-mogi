
<div class="box">
	<div class="box-body pbn">
		<h4 class="head text-left fs14 pl20"><?php echo lang('bookmakers_area_title'); ?></h4>	

		
					
		<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class='table-responsive'>
			<table class='table table-striped'>
				<thead class="bg-black">
					<tr>
						<th class="pn w300"><?php echo lang('bookmakers_bookmaker'); ?></th>
						<th class="pn"><?php echo lang('bookmakers_rating'); ?></th>
						<th class="pn"><?php echo lang('bookmakers_bonus_offer'); ?></th>
						<th class="pn"><?php echo lang('bookmakers_bonus_code'); ?></th>
						<th class="pn"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($records as $record) : 
					
					$noReviews = $this->bookmaker_reviews_model->noReviews($record->id);
					$rating = $this->bookmaker_reviews_model->rating($record->id);?>
					
					<tr>
						<td class="text-left"><img src="<?php echo base_url();?>uploads/bookmakers/<?php echo $this->bookmakers_model->get_bookmaker_logo_by_id($record->id); ?> " class="h40 mr20"/>
						<a href="<?php echo base_url();?>bookmakers/view/<?php echo $record->id;?>"><?php echo $record->name;?></a></td>
						
						

					<?php   if ($noReviews >0) :?>

							<td><span class='text-blue fs16'><?php echo round($record->rating, 2);?> / 5</td>
							
						<?php else: ?>
						
						   <td><?php echo lang('bookmakers_no_reviews');?></td>
						   
						<?php endif; ?>


						<td><?php echo $record->bonus_offer;?></td>
						<td><?php echo $record->bonus_code;?></td>
						<td><a href="<?php echo $record->url;?>" target="_blank" class="btn btn-clean"><?php echo lang('bookmakers_sign_up'); ?></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>	
		<?php

		endif; ?>
	</div>	
</div>	

<?php echo $this->bookmakers_model->get_bookmaker_banner_full();?>