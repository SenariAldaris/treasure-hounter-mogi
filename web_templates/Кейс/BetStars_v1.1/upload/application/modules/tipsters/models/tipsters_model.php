<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tipsters Model
 *
 * This class handles tipsters
 *
 * @package		Tipsters
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Tipsters_model extends MY_Model {

	/** @var string Name of the users table. */
	protected $user_table    	= 'users';
	
	/** @var string Name of the tips table. */
	protected $tips_table    	= 'tips';

	
    public function get_user_tips_by_date($from ,$to ,$user_id, $sport, $status){
       $from = trim($from);
       $to = trim($to);
	   if(empty($sport))
	   {
		$sport = "!=0";
	   }
	   else
	   {
		$sport = "='$sport'";
	   }	   
	   if(empty($status))
	   {
		$status = "NOT IN (1,2)";
	   }
	   else
	   {
		$status = "='$status'";
	   }
	   $tipster = "='$user_id'";
       $condition = "between '$from' And '$to' ";
	   $invalid_date = lang('tips_invalid_date');
	   
       if(empty($from) || empty($to)){
           echo"<span class='text-red fs14'>$invalid_date</span>";
           exit;
       }
		if($from > $to){
           echo"<span class='text-red fs14'>$invalid_date</span>";
           exit;
       }
   
       $sql = "SELECT * from tips  WHERE created_on $condition AND sport_id $sport AND status $status AND created_by $tipster";        
       $query = $this->db->query($sql);
	   if($query->num_rows()>0)
	    {
			$this->load->helper('date');
		   foreach ($query->result() as $record)
		   {    
				$match_date = $this->bet_events_model->get_match_date_by_id($record->match_id);
				$match_time = $this->bet_events_model->get_match_time_by_id($record->match_id);
				$mdate = date('m/d/Y', strtotime($match_date));
				$mtime = date('H:i', strtotime($match_time));
				$match_name = $this->bet_events_model->get_match_name_by_id($record->match_id); 
				$sport_img = $this->sports_model->get_sport_icon_by_id($record->sport_id);
				$country_id = $this->leagues_model->get_league_country_by_id($record->league_id);
				$flag = $this->countries_model->get_country_flag_by_id($country_id);
				$league = $this->leagues_model->get_league_name_by_id($record->league_id);
				$url = base_url();
				$tipsurl = base_url() .'tips';
				$link = lang('tips_view_full');
				
				if($record->status == 3) 
				 { 

					$status = "<span class='text-green'><i class='fa fa-thumbs-up'></i>	
						$record->winnings
					</span>";
				
				} 
					elseif($record->status == 4) 
				{
				
					$status = "<span class='text-red'><i class='fa fa-thumbs-down'></i>	
						$record->winnings
					</span>";
				
				} 
					else 
				{
				
					$status = "<span class='text-yellow'><i class='fa fa-hand-stop-o'></i> / </span>";
				
				} ; ?>

				<tr>
					
						<td class="text-left">
							<img class="h30 mrm5" src="<?php echo base_url();?>uploads/sports/<?php e($this->sports_model->get_sport_icon_by_id($record->sport_id)); ?>"/>
							<?php $country_id = $this->leagues_model->get_league_country_by_id($record->league_id);?>
							
							<img class="h30 mtm4" src="<?php echo base_url();?>uploads/countries/<?php e($this->countries_model->get_country_flag_by_id($country_id)); ?>"/>
							<span class="fs12 mr10"><?php e($this->leagues_model->get_league_name_by_id($record->league_id)); ?>
							</span>
						</td>
						<?php $match = $this->tips_model->get_match_by_id($record->match_id);
	
							foreach($match as $rec):?>
						<td class="text-right">
							<?php e($rec->home_team); ?>	
						</td>	
						<td class="w30 pn text-right">	
							<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->home_team,$record->league_id)); ?>"/>
						</td>
						<td class="pn">
							<a href="<?php echo base_url(); ?>tips/preview/<?php echo $record->id; ?>">
								<span class="text-blue mh5">info</span>
							</a>
						</td>
						<td class="w30 pn text-left">	
							<img class="h30 mtm4" src="<?php echo base_url();?>uploads/teams/<?php e($this->teams_model->get_team_logo_by_name($rec->away_team,$record->league_id)); ?>"/>
						</td>	
						<td class="text-left">
							<?php e($rec->away_team); ?>	
						</td>
						<?php endforeach;?>
						<div class="fr">	
							<td>
								<?php if($record->status == 3) { ?>
									
									<span class="text-green"><i class="fa fa-thumbs-up"></i>	
										<?php echo $record->winnings;?>
									</span>
									
									<?php } elseif($record->status == 4) {?>
									
									<span class="text-red"><i class="fa fa-thumbs-down"></i>	
										<?php echo $record->winnings;?>
									</span>
									
									<?php } elseif($record->status == 5) {?>
									
									<span class="text-yellow"><i class="fa fa-hand-stop-on"></i>	
										<?php echo $record->winnings;?>
									</span>													
									<?php } else {?>
									
									<span class="text-blue">	
										/
									</span>
									<?php } ?>
									
							</td>		
							<td class="w150 hidden-xs">	
								<?php echo relative_time(strtotime($record->created_on)); ?>

							</td>
						</div>
						
					
					</tr>

		 <?php   }
		}
        else
		{
		   echo'<td class="text-left text-red">'. lang('tips_records_empty') .'</td>';
		}
  
		
    }	

///////////////////////////////////////////////	
	function AddFollow($follower_id, $following_id)
	{
        $this->db->where('follower_id', $follower_id);
        $this->db->where('following_id', $following_id);
		$query = $this->db->get('tipster_follow');

		$data = array(
			'follower_id' => $follower_id,
			'following_id' => $following_id
			);
			
		$this->db->insert('tipster_follow', $data);
       
    }
///////////////////////////////////////////////		
	function RemoveFollow($follow_id)
	{

        $this->db->where('follow_id', $follow_id);
        $this->db->delete('tipster_follow');

    }
///////////////////////////////////////////////	
    function is_following($follower_id,$following_id) 
	{
	  $this->db->where('follower_id', $follower_id);
	  $this->db->where('following_id', $following_id);
	  $this->db->order_by('follow_id','DESC');
	  $query = $this->db->get('tipster_follow');
	  return $query;
          
     } 
///////////////////////////////////////////////	
    function count_followers($user_id) 
	{

		$this->db->select(array('follower_id','count(follower_id) as followers'))
		->from('tipster_follow')
		->where('following_id', $user_id);
		
		$query = $this->db->get();
        return $query->row()->followers;	
	}
///////////////////////////////////////////////	
    function count_followings($user_id) 
	{

		$this->db->select(array('following_id','count(following_id) as followings'))
		->from('tipster_follow')
		->where('follower_id', $user_id);
		
		$query = $this->db->get();
        return $query->row()->followings;	
	}
///////////////////////////////////////////////	
    function get_followings($user_id) 
	{
		$query = $this->db->get_where('tipster_follow',array('follower_id'=>$user_id));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
///////////////////////////////////////////////		
	public function get_frends_activities($frends)
	{
		$this->db->from('tips')
		->where('status', 2)
		->where_in('created_by', $frends);
		$query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}	
///////////////////////////////////////////////		
	function get_user_display_name_by_id($id='')
	{
		$query = $this->db->get_where('users',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->display_name;
		}
		else
			return '';
	}
///////////////////////////////////////////////		
	function get_user_avatar_by_id($id='')
	{
		$query = $this->db->get_where('users',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->avatar;
		}
		else
			return '';
	}
///////////////////////////////////////////////		
	function get_role_name_by_id($id='')
	{
		$query = $this->db->get_where('roles',array('role_id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->role_name;
		}
		else
			return '';
	}		

///////////////////////////////////////////////		
	public function user_favorit_sports($user_id)
	{
		$this->db->select(array(
				'sport_id',
				'count(1) as count')
			)
			->from('tips')
			->where_not_in('status', array(1,2))
			->where('created_by', $user_id)
			->order_by('count', 'desc')
			->limit(3)
			->group_by('sport_id');

		$query = $this->db->get();
		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}	
///////////////////////////////////////////////	
	public function user_favorit_leagues($user_id)
	{
		$this->db->select(array(
				'league_id',
				'count(1) as count')
			)
			->from('tips')
			->where_not_in('status', array(1,2))
			->where('created_by', $user_id)
			->order_by('count', 'desc')
			->limit(3)
			->group_by('league_id');

		$query = $this->db->get();
		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}	
///////////////////////////////////////////////		
	function get_tipsters()
	{
		$this->db->select('id, display_name');
		$this->db->where('role_id !=', 1);
		$query = $this->db->get('users');
		
	 
		$tipsters = array();
	 
		if ($query-> result()) 
		{
		  foreach ($query->result() as $tipster) 
		  {
			$tipsters[$tipster->id] = $tipster->display_name;
		  } 
		  return $tipsters;
		} 
		else 
		{
		  return FALSE;
		}
	}	
///////////////////////////////////////////////		
	public function rankings_by_date($from,$to)
	{

	    $from = trim($from);
        $to = trim($to);	
		$invalid_date = lang('tips_invalid_date');
		if(empty($from) || empty($to)){
           echo"<span class='text-red fs14'>$invalid_date</span>";
           exit;
		}
		if($from > $to){
           echo"<span class='text-red fs14'>$invalid_date</span>";
           exit;
		}
	   
		$this->db->select("tips.created_by, tips.created_on, tips.sport_id, tips.league_id, avatar, country, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
		->from($this->tips_table)
		->join($this->user_table, $this->user_table . '.id = ' . $this->tips_table . '.created_by', 'left')
		->where($this->user_table . '.role_id !=' , 1) //exclude admin role
		->where('winnings !=', 0)
		->where('status !=', 1)
		->where('tips.created_on >=', $from)
		->where('tips.created_on <=', $to)
		->order_by('winnings', 'desc')
		->order_by('tips', 'desc')
		->group_by('display_name');

		$query = $this->db->get();
		
	    if($query->num_rows()>0)
	    {?>
		
		
							
						
								<tr class="bg-black">
									<th class="bg-black w20 pn">#</th>
									<th class="bg-black pn"><?php echo lang('tips_tipster'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_total'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_won'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_lost'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_voided'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_avg_stake'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_avg_odds'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_profit'); ?></th>
									<th class="bg-black pn"><?php echo lang('tips_yield'); ?></th>
								</tr>

				
			<?php $pos =1;	
		    foreach ($query->result() as $record)
		    {?>


				<tr>
					
					<td class="w20"><?php echo $pos++ ?></td>
					<td class="text-left"><a href="#"><img class="h30 mr10" src="<?php echo base_url();?>uploads/tipsters/<?php echo $record->avatar;?>" alt="" class="img-responsive" /></a>
					<img class="h30 mr10" src="<?php echo base_url();?>uploads/countries/<?php echo $this->countries_model->get_country_flag_by_id($record->country);?>" alt="">									
						<a href="<?php echo base_url();?>tipsters/profile/<?php echo $record->id; ?>">
							<?php echo $record->display_name; ?>
						</a>
					</td>

					<td><?php echo $this->competitions_model->count_tipster_tips_by_period($record->id,$from,$to);?></td>
					<td>
					
						<span class="text-green"><i class="fa fa-thumbs-up"></i>	
							<?php echo $this->competitions_model->count_tipster_won_by_period($record->id,$from,$to);?>
						</span>
					</td>
					<td>
						<span class="text-red"><i class="fa fa-thumbs-down"></i>
							<?php echo $this->competitions_model->count_tipster_lost_by_period($record->id,$from,$to);?>
						</span>	
					</td>
					<td>
						<span class="text-yellow"><i class="fa fa-hand-stop-o"></i>
							<?php echo $this->competitions_model->count_tipster_void_by_period($record->id,$from,$to);?>
						</span>	
					</td>
				
					<?php $user_tips = $this->competitions_model->count_tipster_tips_by_period($record->id,$from,$to);
						  $user_stake = $this->competitions_model->count_tipster_stake_by_period($record->id,$from,$to);
						  $user_profit = $this->competitions_model->count_tipster_profit_by_period($record->id,$from,$to);	
						  $user_odds = $this->competitions_model->count_tipster_odds_by_period($record->id,$from,$to);	
						  
						  $avg_stake = $user_stake/$user_tips;
						  $avg_odds  = $user_odds/$user_tips;
					?>											  
					
					
					<td><?php echo round($avg_stake, 2);?></td>
					<td><?php echo round($avg_odds, 2);?></td>

						<?php if ($user_profit < 0 ):  ?>	
							<td><span class="text-red"><?php echo round($user_profit, 2);?></span></td>
							<?php else : ?>
							<td><span class="text-green">+<?php echo round($user_profit, 2); ?></span></td>
							
						<?php endif; ?>

						<?php  $yield1 = ($user_profit-$user_stake)/$user_stake;
							   $yield =  $yield1*100;
						  
						if ($yield < 0 ):  ?>
							<td class="text-center"><span class="text-red"><?php echo round($yield, 2);?> %</span></td>
								
							<?php else : ?>
							<td class="text-center"><span class="text-green">+<?php echo round($yield, 2); ?> %</span></td>
						<?php endif; ?>							
				
				</tr>
					
					

		<?php }
		}
        else
		{
		   echo'<div class="alert alert-block alert-info fade in mbn">
					<a class="close" data-dismiss="alert">&times;</a>
					<h4 class="alert-heading fs14">
					'.lang('tips_no_results').'
					</h4>
				</div>';
		}
	}

///////////////////////////////////////////////	


///////////////////////////////////////////////	
	
}	