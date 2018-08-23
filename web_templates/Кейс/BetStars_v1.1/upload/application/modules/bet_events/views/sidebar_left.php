<?php echo $this->bookmakers_model->get_bookmaker_banner_sidebar();?>


	<div class="box mt20">
		<div class="box-body pbn">
			<?php $total_active = $this->bet_events_model->count_all_active_events();?>
			<h4 class="head fs14 mb10"><?php echo lang('bet_events_active_events'); ?>
				<span class="pull-right mr10">(<?php echo $total_active;?>)</span>
			</h4>



			<ul class="list-group list-group-unbordered" id="accordion">
			
				<?php $all_sports = $this->bet_events_model->get_all_sports();
		
					foreach ($all_sports as $sport) :?>	
									

						<li class="list-group-item bg-grey mb5">
                            <a class="ml10" data-toggle="collapse" data-parent="#accordion" href="#sport<?php echo $sport->id;?>">
								<img class="h30 mtm2" src="<?php echo base_url();?>uploads/sports/<?php echo $this->sports_model->get_sport_icon_by_id($sport->id); ?>"/> 
							   <span class="text-black">
								<?php echo strtoupper($this->sports_model->get_sport_name_by_id($sport->id)); ?>
							   </span>
							</a>
							<?php $sport_count = $this->bet_events_model->count_all_active_events_by_sport($sport->id);?>
							<span class="pull-right mr10">(<?php  echo $sport_count; ?>)</span>
						</li>	

					<div id="sport<?php echo $sport->id;?>" class="collapse">

                        <ul class="list-group list-group-unbordered" id="accordion2">

								<?php $countries = $this->bet_events_model->get_all_countries($sport->id);
								if(isset($countries) && is_array($countries) && count($countries)):			   
								foreach ($countries as $country) :?>

								
											<li class="list-group-item list-group-unbordered">
											<a class="ml10" data-toggle="collapse" data-parent="#accordion2" href="#league<?php echo $country->league_id;?>">
												<img class="h24 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country->country_id)); ?>"/>
												<?php echo $country->name; ?>
											</a>	
											<?php $country_count = $this->bet_events_model->count_all_active_events_by_country($country->country_id,$country->sport_id);?>
											<span class="pull-right mr10 text-black">(
											  <?php echo $country_count; ?>
											)</span>
											</li>
							
									<div id="league<?php echo $country->league_id;?>" class="collapse">
										<div class="panel-body">

											<?php $leagues = $this->bet_events_model->get_all_leagues($country->country_id,$sport->id);
									   
											if(isset($leagues) && is_array($leagues) && count($leagues)):
											foreach ($leagues as $league) :?>

											<li class="list-group-item no-border ml10 fs12">

												<a class="ml10" href="<?php echo base_url();?>events/by_league/<?php echo $league->league_id;?>">
													<?php echo $this->leagues_model->get_league_name_by_id($league->league_id) ?>
												</a>
												<?php $league_count = $this->bet_events_model->count_all_active_events_by_league($league->league_id,$league->sport_id);?>
												
												<span class="pull-right text-blue">(<?php echo $league_count; ?>)</span>
											
											</li>
									
											<?php endforeach; endif;?>

										</div>
									</div>
									
								
								<?php endforeach; endif;?>
		
						</ul>
					</div>			
					
				<?php endforeach;?>
			</ul>									
												

							
		</div>

		
	</div>


<?php echo $this->bookmakers_model->get_bookmaker_banner_sidebar();?>
