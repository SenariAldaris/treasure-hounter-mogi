<?php

$num_columns	=6;
$can_delete	= $this->auth->has_permission('Tips.Delete');
$can_edit		= $this->auth->has_permission('Tips.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
	<div class="box box-widget">
		<div class="box-header with-border">
			<h3 class="box-title"><?php if (isset($toolbar_title)) : ?><?php echo $toolbar_title; ?><?php endif; ?></h3>
			<div class="box-tools pull-right">
				<div class="btn-group">				  
					 <a class="btn btn-xs btn-green" href="<?php echo site_url();?>admin/dashboard/tips" id="list"><?php echo lang('bf_list'); ?></a>
				</div>
			</div>
		</div><!-- /.box-header -->

		<?php echo form_open($this->uri->uri_string()); ?>
			<div class="box-body">
			
				<ul class="nav nav-tabs">
					<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('tips_tab_active')); ?></li>
					<li<?php echo $filter_type == 'draft' ? ' class="active"' : ''; ?>><?php echo anchor("{$index_url}draft/", lang('tips_tab_draft')); ?></li>
					<li<?php echo $filter_type == 'inactive' ? ' class="active"' : ''; ?>><?php echo anchor("{$index_url}inactive/", lang('tips_tab_inactive')); ?></li>
					<li class="<?php echo $filter_type == 'sport_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('tips_tab_sports');
							echo isset($filter_sport) ? ": {$filter_sport}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu">
							<?php foreach ($sports as $sport) : ?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/tips/index/sport_id-<?php echo $sport->id;?>">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($sport->icon); ?>"/>
									<?php echo $sport->name; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</li>
					<li class="<?php echo $filter_type == 'league_id' ? 'active ' : ''; ?>dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							echo lang('tips_tab_leagues');
							echo isset($filter_league) ? ": {$filter_league}" : '';
							?>
							<span class="caret light-caret"></span>
						</a>
						<ul class="dropdown-menu" style="height:600px;overflow:auto;">
							<?php foreach ($leagues as $league) : 
								$country_flag = $this->countries_model->get_country_flag_by_id($league->country_id);
							    $sport_id = $this->leagues_model->get_league_sport_id_by_id($league->sport_id);
								$sport_icon = $this->sports_model->get_sport_icon_by_id($league->sport_id);?>
							<li>
								<a href="<?php echo base_url();?>admin/dashboard/tips/index/league_id-<?php echo $league->league_id;?>">
									<img class="h30 mtm2 mrm2" src="<?php echo base_url();?>uploads/sports/<?php e($sport_icon); ?>"/>
									<img class="h30 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($country_flag); ?>"/>
									<?php echo $league->league_name; ?>
								</a>	
							</li>
							<?php endforeach; ?>
						</ul>
					</li>
				</ul>				
			
				<div class="table-responsive">
					<table id="tips_table" class='table table-striped'>
						<thead>
							<tr>
								<?php if ($can_delete && $has_records) : ?>
								<th class="column-check"><input id="check-all" type="checkbox" /></th>
								<?php endif;?>
								

								<th><?php echo lang('tips_championship'); ?></th>
								<th></th>
								<th></th>
								<th><?php echo lang('tips_event_id'); ?></th>
								<th></th>
								<th></th>
								<th><?php echo lang('tips_created_by'); ?></th>


							</tr>
						</thead>

						<tbody>
							<?php
							if ($has_records) :
								foreach ($records as $record) :
							?>
							<tr>
								<?php if ($can_delete) : ?>
								<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
								<?php endif;?>
								

							
								<td class="text-left">
									<img class="h30 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
									<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);
									$country_flag = $this->countries_model->get_country_flag_by_id($country_id);?>
									<img class="h30 mtm2" src="<?php echo base_url();?>uploads/countries/<?php e($country_flag); ?>"/>
									<span class="fs12 mr10">
										<?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?>
									</span>
								</td>
								
								<?php if($record->bet_name == 'Outright Winner'):?>
								<td class="text-right">
									<?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?>
								</td>	
								<td></td>
								<td class="pn">
									<a href="<?php echo base_url('admin/dashboard'); ?>/tips/edit/<?php echo $record->id; ?>">
										<span class="text-blue mh5">edit</span>
									</a>	
								</td>
								<td></td>
								<td></td>
								<?php else: ?>	
								
								<?php if ($can_edit) : ?>								
								<?php $match = $this->tips_model->get_match_by_id($record->match_id);
							
								foreach($match as $rec):?>

								<td class="text-right">
									<?php e($rec->home_team); ?>	
								</td>	
								<td class="w30 pn text-right">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->home_team,$record->league_id)); ?>"/>
								</td>
								<td class="pn">
									<a href="<?php echo base_url('admin/dashboard'); ?>/tips/edit/<?php echo $record->id; ?>">
										<span class="text-blue mh5">edit</span>
									</a>	
								</td>
								<td class="w30 pn text-left">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->away_team,$record->league_id)); ?>"/>
								</td>	
								<td class="text-left">
									<?php e($rec->away_team); ?>	
								</td>	

								<?php endforeach;?>
								<?php else : ?>
								<?php $match = $this->tips_model->get_match_by_id($record->match_id);
							
								foreach($match as $rec):?>

								<td class="text-right">
									<?php e($rec->home_team); ?>	
								</td>	
								<td class="w30 pn text-right">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->home_team,$record->league_id)); ?>"/>
								</td>
								<td class="pn">
									<a href="<?php echo base_url('admin/dashboard'); ?>/tips/edit/<?php echo $record->id; ?>">
										<span class="text-blue mh5">edit</span>
									</a>	
								</td>
								<td class="w30 pn text-left">	
									<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->away_team,$record->league_id)); ?>"/>
								</td>	
								<td class="text-left">
									<?php e($rec->away_team); ?>	
								</td>	

								<?php endforeach;?>
								<?php endif; ?>	
								
								<?php endif; ?>	
								<td><?php echo $this->tipsters_model->get_user_display_name_by_id($record->created_by); ?></td>

							</tr>
							<?php
								endforeach;
							else:
							?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'><?php echo lang('tips_records_empty'); ?></td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>	
			</div>	
			<?php if ($has_records) : ?>
			<div class="box-footer">
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-red' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('tips_delete_confirm'))); ?>')" />
						<?php echo $this->pagination->create_links();?>
					</td>
				</tr>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		<?php echo form_close(); ?>
	</div>
	
	
<script type="text/javascript">
    //Check and uncheck all functionality
	$("#check-all").click(function () {
        $('#tips_table tbody input[type="checkbox"]').prop('checked', this.checked);
    });
</script>	