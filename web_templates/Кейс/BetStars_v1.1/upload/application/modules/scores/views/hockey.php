<?php
$href = $html->find('.table_scores a');
if($href){
	foreach ($href as $m){
		strip_tags($m->class = 'no-link');
	}	
}
$expand = $html->find('.table_scores td span.expanderSign');
if($expand){
	foreach ($expand as $m){
		$m->outertext = '';
	}	
}


?>

<div class="box">
	<div class="box-header bg-white">

		<h4 class="head text-left pl20 fs14">
			<img class="h30 mtm1" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id(13)); ?>"/>
			<?php echo lang('bet_events_hockey_scores'); ?>
		
			<form id="sport_form" class="form-inline">
				<span class="pull-right mr20 hidden-xs" style="position: absolute;right: 0;top: 25px;">

						<div class="form-group <?php echo form_error('sport_id') ? ' has-error' : ''; ?>">
							<label class="control-label mr20"><?php echo lang('bet_events_filter_by_sport');?></label>
							<select name="sport" id="sport" class="form-control">
								<option value=""><?php echo lang('bet_events_select_sport');?></option>
								<option value="football">Football</option>
								<option value="basketball">Basketball</option>
								<option value="handball">Handball</option>
								<option value="hockey">Ice Hockey</option>

							</select>
						</div>
					<button type="submit" id="sport_filter" class="btn btn-white"><?php echo lang('bet_events_filter'); ?></button>
					<button class="gobottom pull-right btn btn-white ml10"><i class="fa fa-arrow-down"></i></button>
				</span>
			</form>
		
		</h4>

	</div>	
		
	<div class="box-body">
		<div class="table-responsive">
			<table id="events_table" class="table table-striped" role="grid">


			<?php foreach ($html->find('.table_scores') as $table):?>

					<thead class="bg-lblue">
						<tr>
							<th class="text-left">
							<img class="h30 mtm1" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id(13)); ?>"/>
							<?php foreach ($table->find('thead th span') as $country2):
							
							$country = $country2->plaintext;
							$league = substr($country, strpos($country, ":") + 1);
							$flag = substr($country, 0, strpos($country, ':'));?>
							
							<img class="h30 mtm4 mr10" src="<?php echo base_url();?>uploads/countries/<?php echo str_replace(' ','',$flag);?>.png"/>
								<span class="bg-grey text-black p5"><?php echo str_replace(' ','',$flag);?></span> - 
								<span class="bg-grey text-black p5"><?php echo $league;?></span>
								<?php endforeach ;?>
							</th>

							<th><?php echo lang('bet_events_home'); ?></th>
							<th><?php echo lang('bet_events_result'); ?></th>
							<th><?php echo lang('bet_events_away'); ?></th>
							<th><?php echo lang('bet_events_status'); ?></th>

						</tr>
					</thead>

					<tbody>		
						<?php foreach ($table->find('tbody tr.tr1, tr.tr2') as $tr):?>
						<tr>
	
							<td>
								<?php foreach ($tr->find('td.td2') as $date):?>
								<span class=""><?php echo $date->plaintext;?></span>
								<?php endforeach ;?>
							</td>
							
								<?php foreach ($tr->find('td.td3') as $home):?>
								<?php echo $home; ?>
								<?php endforeach ;?>
								
							<td class="w100">
								<?php foreach ($tr->find('td.td4') as $result):?>
								<span class="text-blue"><?php echo $result->plaintext; ?></span>
								<?php endforeach ;?>
							</td>	
							
								<?php foreach ($tr->find('td.td5') as $away):?>
								<?php echo $away; ?>
								<?php endforeach ;?>
							
								
							<td class="w200">
								<?php foreach ($tr->find('td.td1') as $status):?>
								<span class="text-blue"><?php echo $status->plaintext; ?></span>
								<?php endforeach ;?>
							</td>							

						</tr>	

					</tbody>
					
					<?php endforeach ;?>

				<?php endforeach ;?>
				
			</table>

		</div>	
	</div>	
</div>

<script type="text/javascript">
  // Define site_url variable for use in the js file
  var site_url = "<?php echo site_url(); ?>";
  
  setInterval("refresh();",20000); 
 
    function refresh(){
        window.location = location.href;
    }
	
</script>