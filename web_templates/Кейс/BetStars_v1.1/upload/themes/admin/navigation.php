      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <ul class="sidebar-menu">
			<li class="treeview">
              <a class="bg-blue" href="#">
                <i class="fa fa-share"></i> <span>BETTING MANAGMENT</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu menu-open" style="display: block;">
				<li><a href="<?php echo base_url();?>admin/dashboard/countries"><span>Countries</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/sports"><span>Sports</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/leagues"><span>Leagues</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/bet_events"><span>Events</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/teams"><span>Teams</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/results"><span>Results</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/tips"><span>Tips</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/bookmakers"><span>Bookmakers</span></a></li>
				<?php 	$CI = get_instance();
						$CI->load->database();
						$query = $CI->db->get_where('bookmaker_reviews',array('status'=>0));
						$no = $query->num_rows();
				?>
				<li><a href="<?php echo base_url();?>admin/dashboard/bookmaker_reviews">
					<span>Bookmaker Reviews ( <?php echo $no;?> )</span></a>
				</li>	
				<li><a href="<?php echo base_url();?>admin/dashboard/competitions"><span>Competitions</span></a></li>
				<li><a href="<?php echo base_url();?>admin/dashboard/rewards"><span>Rewards</span></a></li>				
              </ul>
            </li>	
			<li class="header"></li>			

			<li class="treeview">
				<a class="bg-blue" href="#">
					<i class="fa fa-share"></i> <span>ACCESS MANAGMENT</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">			  
					
					<li><a href="<?php echo base_url();?>admin/settings/users"><span>Users</span></a></li>
					<li><a href="<?php echo base_url();?>admin/settings/roles"><span>Roles</span></a></li>
					<li><a href="<?php echo base_url();?>admin/settings/permissions"><span>Permissions</span></a></li>
				</ul>	
			</li>	
			<li class="header"></li>
			<li class="treeview">
				<a class="bg-blue" href="#">
					<i class="fa fa-share"></i> <span>SYSTEM MANAGMENT</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">			
					<li><a href="<?php echo base_url();?>admin/settings/emailer"><span>Email Settings</span></a></li>
					<li><a href="<?php echo base_url();?>admin/settings/database"><span>Database</span></a></li>
					<li><a href="<?php echo base_url();?>admin/settings/translate"><span>Translations</span></a></li>
					<li><a href="<?php echo base_url();?>admin/settings/logs"><span>Logs</span></a></li>
					<li><a href="<?php echo base_url();?>admin/settings/settings"><span>Settings</span></a></li>
					<li><a href="<?php echo base_url();?>admin/settings/sysinfo"><span>System Info</span></a></li>
				</ul>
			</li>		
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->