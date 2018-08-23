<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('bookmakers_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;?>





<?php $bookmaker_id = $this->uri->segment(3);
$rating = $this->bookmaker_reviews_model->get_rating($bookmaker_id);
$noReviews = $this->bookmaker_reviews_model->noReviews($bookmaker_id);?>



<div class="box">
	<div class="box-body">
		<h4 class="head text-left fs14 mb20 pl20">			
			<img src="<?php echo base_url();?>uploads/bookmakers/<?php echo $this->bookmakers_model->get_bookmaker_logo_by_id($bookmaker_id); ?> " class="h30"/>
			<?php echo lang('bookmakers_review'); ?>
			<div class="pull-right mr10 ph10 bg-grey text-black">
				<span class="mr10"><?php echo lang('bookmakers_rated');?>:</span><?php echo round($rating,2);?> /5
				<span class="ml10"><?php echo lang('bookmakers_based_on');?></span> <?php echo $noReviews;?> <?php echo lang('bookmakers_reviews');?>
			</div>	
		</h4>	

		<?php foreach ($records->result() as $record) :?>

			<?php echo $record->review;?>

		<?php endforeach; ?>
		
		<div class="divider-4"></div>
			<h4 class="text-left text-blue fs14 mb20 pl20"><?php echo lang('bookmakers_tipsters_reviews'); ?></h4>
		<div class="divider-4"></div>
		
	<?php //$reviews = $this->bookmakers_model->bookmaker_Reviews($bookmaker_id);
	
	if(isset($reviews) && is_array($reviews) && count($reviews))
	{
	
		foreach ($reviews as $row)
		{

			$user_id = $row->user_id;
			$name = $this->tipsters_model->get_user_display_name_by_id($user_id);
			$date_posted = relative_time(strtotime($row->date_posted));
			$desc = $row->description;


			if (!empty($current_user))
			{
				$user_id = $current_user->id;  
				$user_votes = $this->bookmaker_reviews_model->user_votes($row->review_id,$user_id);
				if ($user_votes->num_rows() > 0)
				{
					$url = base_url('bookmakers');
					$vote_sum = $this->bookmaker_reviews_model->vote_sum($row->review_id);
					$review_id = $row->review_id;
					$bookmaker_id = $row->bookmaker_id;
															
					echo "<div class='row'>";
					
					echo"<div class='col-sm-1'>
					
							<div class='btn-group-vertical text-center'>
							
								<a href='$url/vote_up/$review_id/$bookmaker_id' class='mb5 btn btn-green disabled'><i class='fa fa-thumbs-up'></i></a>
								<span class='mt5 mb5'>$vote_sum</span>
								<a href='$url/vote_down/$review_id/$bookmaker_id'class='mt5 btn btn-red disabled'><i class='fa fa-thumbs-down'></i></a>
							 </div>
						</div>";
				}
				else
				{
					$url = base_url('bookmakers');
					$vote_sum = $this->bookmaker_reviews_model->vote_sum($row->review_id);
					$review_id = $row->review_id;
					$bookmaker_id = $row->bookmaker_id;
					
					echo "<div class='row'>";
					
					echo"<div class='col-sm-1'>
					
						<div class='btn-group-vertical text-center'>
						
							<a href='$url/vote_up/$review_id/$bookmaker_id' class='mb5 btn btn-green'><i class='fa fa-thumbs-up'></i></a>
							<span class='mt5 mb5'>$vote_sum</span>
							<a href='$url/vote_down/$review_id/$bookmaker_id'class='mt5 btn btn-red'><i class='fa fa-thumbs-down'></i></a>
						 </div>
					 </div>";

				}
			}
			else
			{
				$url = base_url('bookmakers');
				
				$vote_sum = $this->bookmaker_reviews_model->vote_sum($row->review_id);
				$review_id = $row->review_id;
				$bookmaker_id = $row->bookmaker_id;
				
			    echo "<div class='row'>";
				
				echo"<div class='col-sm-1'>
				
						<div class='btn-group-vertical text-center'>
						
							<a href='$url/vote_up/$review_id/$bookmaker_id' class='mb5 btn btn-green disabled'><i class='fa fa-thumbs-up'></i></a>
							<span class='mt5 mb5'>$vote_sum</span>
							<a href='$url/vote_down/$review_id/$bookmaker_id'class='mt5 btn btn-red disabled'><i class='fa fa-thumbs-down'></i></a>
						</div>
					</div>";
			}

			$tipsters_url = base_url('tipsters');
			$by = lang('bookmakers_reviewed_by');
			$rated = lang('bookmakers_rated');
			
			echo "<div class='col-sm-11 mb10'>";
			echo "<h4 class='fs14 br-b lh20 pb10 mb10'>$by: <a href='$tipsters_url/profile/$row->user_id'>$name </a>
			<div class='pull-right fs12'>$date_posted 
			<span class='ml20'>$rated:</span> <span class='text-blue ml10'>$row->rating  / 5 </span></div></h4>";
			
			echo "<div class='description block'>$desc</div>";
			echo "</div>"; // ./row
			echo "</div>"; // ./row
			

			echo "<div class='divider-4'></div>";
		}
	
	
	}
	else 
	{ ?>
	
		<div class='alert alert-info mt20'><?php echo lang('bookmakers_no_reviewes_yet');?></div>
		
	<?php };

	if (!empty($current_user))
	{
	 
		$user_id = $current_user->id;  
		$query = $this->bookmaker_reviews_model->user_Reviews($user_id, $bookmaker_id);
		$no_of = $query->num_rows();
		
		if ($no_of > '0')
		{ 
			echo lang('bookmakers_already_reviewed');
		 }
		else
		{
			$user_id = $current_user->id;
			$name = $this->tipsters_model->get_user_display_name_by_id($user_id);?>
			   
			<h4 class='text-left fs14 head pl20 mb20'><?php echo lang('bookmakers_add_review');?></h4>
			<?php echo form_open('bookmakers/review/'.$bookmaker_id.'/'.$user_id , " id='form' class='form-horizontal'");?>
			
				
					<div class='col-sm-5'>
				
						<div class='form-group'>
							<label class='control-label col-sm-3'><?php echo lang('bookmakers_tipster');?></label>
							<div class='col-sm-8'>
								<input type='text' name='name' class='form-control' value='<?php echo $name;?>' disabled />
							</div>
						</div>
						
						<div class="form-group<?php echo form_error('rating') ? ' has-error' : ''; ?>">

							<label class='control-label col-sm-3'><?php echo lang('bookmakers_rating');?></label>
							<div class='col-sm-8'>
								<select name='rating' id='rating' class='form-control'>
									<option value=''><?php echo lang('bookmakers_select_rating');?></option>
									<option value='5'>5. Best</option>
									<option value='4'>4. Good</option>
									<option value='3'>3. Fair</option>
									<option value='2'>2. Bad</option>
									<option value='1'>1. Worst</option>
								</select>
							</div>
						</div>
				
						<div class='form-group'>
							<div class='col-sm-8 col-sm-push-3'>
								<input type='submit' name='submit' value='Submit Review' class='btn btn-blue btn-block'>
							</div>
						</div>										
					</div>
				
					
					
					<div class='col-sm-7'>
						<div class="form-group<?php echo form_error('description') ? ' has-error' : ''; ?>">
							<label class='control-label mb10 ptn'><?php echo lang('bookmakers_elaborate');?></label>
							<textarea name='description' id='description' style='height:120px;width:100%;padding: 10px;'></textarea>		
						</div>
					</div>
               
			<?php echo form_close();
		}
	}
	else
	{
		echo "<h4 class='text-blue'>Not logged in!</h4>You have to be logged in to submit a review. ";
		echo "<a href='".base_url('login')."' class='btn btn-blue'>Login</a>";
		

	};?>

	
	</div>	
</div>	

<script type="text/javascript">

	// Define error messages for jquery validation
	var rating_req = '<?php echo lang('bookmakers_choose_rating');?>'
	var description_forgot = '<?php echo lang('bookmakers_desc_forgot');?>'
	var description_req = '<?php echo lang('bookmakers_min_words');?>'

</script>