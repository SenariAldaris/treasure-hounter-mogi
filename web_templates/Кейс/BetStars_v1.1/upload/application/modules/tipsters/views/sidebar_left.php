	<div class="box box-widget widget-user">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<div class="widget-user-header bg-aqua-active">
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
		</div>
		<div class="widget-user-image">
		  <img class="img-circle" src="<?php echo base_url();?>uploads/tipsters/<?php echo $user->avatar;?>" alt="User Avatar">
		</div>
		<div class="box-footer pbn">
			<h3><a href="#"><?php echo $user->display_name;?></a></h3>
			<div class="divider-4 mtn"></div>
			<div class="row">

				<div class="col-sm-6 border-right">
				  <div class="description-block mbn mtn">
					<h5 class="description-header"><?php echo $this->tipsters_model->count_followers($user->id);?></h5>
					<span class="description-text"><?php echo lang('tips_followers');?></span>
				  </div><!-- /.description-block -->
				</div><!-- /.col -->
				<div class="col-sm-6">
				  <div class="description-block mbn mtn">
					<h5 class="description-header"><?php echo $this->tipsters_model->count_followings($user->id);?></h5>
					<span class="description-text"><?php echo lang('tips_following');?></span>
				  </div><!-- /.description-block -->
				</div><!-- /.col -->
			</div><!-- /.row -->

			<div class="follow-btn">
				<!-- Show Follow Button Only If User Is Logged In And It's Not His Profile -->
				<?php if (!empty($current_user) && ($current_user->id != $user->id))
                {
					$follower_id  =  $current_user->id;
					$following_id =  $user->id;
					$follow = $this->tipsters_model->is_following($follower_id,$following_id);
					$no = $follow->num_rows();
					
					if ($no == 1) //Check if is follower
					{ 
					  foreach ($follow->result() as $row)
					  {	//Unfollow if already following	
						echo anchor('tipsters/unfollow/'.$row->follow_id ."/". $user->id, lang('tips_unfollow') , 'class="follow btn btn-block btn-lblue"');
					  }
					}
					else
					{	//Follow if not following	
						echo anchor('tipsters/follow/'.$user->id, lang('tips_follow_me'), 'class="btn btn-block btn-lblue"');
					}
				} ;?>
				
			</div>

			<ul class="nav nav-stacked">
			
				<li><?php echo lang('tips_country');?><span class="pull-right"><img class="w30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($user->country);?>" alt=""> <?php echo $this->countries_model->get_country_name_by_id($user->country);?></span></li>
				<li><?php echo lang('tips_member_since');?><span class="pull-right text-red"><?php echo date('M j, Y', strtotime($user->created_on));?></span></li>				
				<li><?php echo lang('tips_profile_views');?><span class="pull-right"><?php echo $user->profile_views;?></span></li>			
		    </ul>
			
		</div>
	</div>

