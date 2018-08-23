<img src="<?php echo base_url();?>uploads/bookmakers/free-bet-Sky-Bet.png" class="img-responsive"/>


	<div class="box mt20">
		<div class="box-body pbn">
			<?php $total_active = $this->bet_events_model->count_all_active_events();?>
			<h4 class="head fs14 mb10"><?php echo lang('bet_events_active_events'); ?>
				<span class="pull-right mr10">(<?php echo $total_active;?>)</span>
			</h4>
	
<?php $json_data = '{"rnk":{"spo":"Basketball","cat":"International","uid":"138","hea":{"pos":"Pos","tea":"Team","co1":"W","co2":"L","co3":"Diff."},"lea":[{"lna":"Group A","lro":[{"pos":"1","cha":"N","tea":"Fenerbahce Ulker","co1":"7","co2":"2","co3":"+58"},{"pos":"2","cha":"N","tea":"BC Khimki Moscow","co1":"5","co2":"4","co3":"+67"},{"pos":"3","cha":"U","tea":"Real Madrid BC","co1":"4","co2":"5","co3":"+33"},{"pos":"4","cha":"D","tea":"Bayern Munich","co1":"4","co2":"5","co3":"-23"},{"pos":"5","cha":"D","tea":"Crvena Zvezda Telekom","co1":"4","co2":"5","co3":"+19"},{"pos":"6","cha":"N","tea":"Strasbourg IG","co1":"3","co2":"6","co3":"+9"}]},{"lna":"Group B","lro":[{"pos":"1","cha":"N","tea":"BC Olympiakos Piraeus","co1":"8","co2":"1","co3":"+58"},{"pos":"2","cha":"N","tea":"Laboral Kutxa Vitoria","co1":"5","co2":"4","co3":"+57"},{"pos":"3","cha":"N","tea":"Efes Anadolu Istanbul","co1":"5","co2":"4","co3":"+33"},{"pos":"4","cha":"N","tea":"KK Cedevita Zagreb","co1":"4","co2":"5","co3":"-17"},{"pos":"5","cha":"N","tea":"Ea7-Emporio Armani Milano","co1":"3","co2":"6","co3":"-8"},{"pos":"6","cha":"N","tea":"Limoges Csp","co1":"2","co2":"7","co3":"-57"}]},{"lna":"Group C","lro":[{"pos":"1","cha":"U","tea":"BC Lokomotiv Kuban Krasnodar","co1":"7","co2":"2","co3":"+45"},{"pos":"2","cha":"D","tea":"Regal FC Barcelona","co1":"6","co2":"3","co3":"+59"},{"pos":"3","cha":"N","tea":"BC Panathinaikos","co1":"5","co2":"4","co3":"+79"},{"pos":"4","cha":"N","tea":"BC Zalgiris Kaunas","co1":"5","co2":"4","co3":"+24"},{"pos":"5","cha":"U","tea":"Pinar Karsiyaka","co1":"2","co2":"7","co3":"+5"},{"pos":"6","cha":"D","tea":"Stelmet Zielona Gora","co1":"2","co2":"7","co3":"-38"}]},{"lna":"Group D","lro":[{"pos":"1","cha":"N","tea":"CSKA Moscow","co1":"8","co2":"1","co3":"+63"},{"pos":"2","cha":"N","tea":"Unicaja Malaga","co1":"7","co2":"2","co3":"+49"},{"pos":"3","cha":"N","tea":"Brose Baskets Bamberg","co1":"5","co2":"4","co3":"+29"},{"pos":"4","cha":"N","tea":"Darusafaka Dogus","co1":"4","co2":"5","co3":"-1"},{"pos":"5","cha":"N","tea":"Maccabi Tel-Aviv","co1":"3","co2":"6","co3":"+8"},{"pos":"6","cha":"N","tea":"Banco Di Sardegna Sassari","co1":"0","co2":"9","co3":"-68"}]}]}}';			
			
$json = json_decode($json_data);



?>



<table class="table striped">
	<thead>
			<?php $leaCount = $json->rnk->lea;  
		foreach ($json->rnk->lea as $l) {?>
		<tr class="row-compet">
			<td class="row-header-division" colspan="6"><?php echo $l->lna;?></td>
		</tr>
		<tr>
			<th class="headPosition"><?php echo $json->rnk->hea->pos;?></th>
			<th class="team"><?php echo $json->rnk->hea->tea;?></th> 
			<th class="day"><?php echo $json->rnk->hea->co1;?></th>
			<th><?php echo $json->rnk->hea->co2;?></th>
			<th><?php echo $json->rnk->hea->co3;?></th>
		</tr>
	</thead>
	<tbody>


		 
		<?php foreach ($l->lro as $lr) { ?>
		<tr>
			<td class="position"><span class="<?php echo $lr->cha;?>" /><?php echo $lr->pos;?></td>
			<td class="team"><?php echo $lr->tea;?></td>
			<td class="day"><?php echo $lr->co1;?></td>
			<td class="points"><?php echo $lr->co2;?></td>
			<td><?php echo $lr->co3;?></td>
		</tr>
		<?php } }?>
	</tbody>

</table>

			
			
<?php  ?>			
			
			
			
			

		</div>

	</div>	

	
	<img src="<?php echo base_url();?>uploads/bookmakers/bet365_banner.gif" class="img-responsive"/>
	
	<script src="http://localhost/bs/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script>
	jQuery(document).ready(function(){jQuery("#jquery-accordion-menu").jqueryAccordionMenu(); jQuery(".colors a").click(function(){if($(this).attr("class") !="default"){$("#jquery-accordion-menu").removeClass(); $("#jquery-accordion-menu").addClass("jquery-accordion-menu").addClass($(this).attr("class"));}else{$("#jquery-accordion-menu").removeClass(); $("#jquery-accordion-menu").addClass("jquery-accordion-menu");}});}); 
	</script>