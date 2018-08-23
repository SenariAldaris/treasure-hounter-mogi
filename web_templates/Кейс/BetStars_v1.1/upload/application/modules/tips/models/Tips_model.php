<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Tips Model
 *
 * This class handles tips
 *
 * @package		Tips
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Tips_model extends MY_Model
{
    protected $table_name		= 'tips';
	protected $statuses_table   = 'tip_statuses';
	protected $user_table    	= 'users';
	protected $key				= 'id';
	protected $date_format		= 'datetime';

	protected $log_user 		= false;
	protected $set_created		= false;
	protected $set_modified 	= false;
	protected $soft_deletes		= false;


	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'sport_id',
			'label' => 'lang:tips_sport_id',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'league_id',
			'label' => 'lang:tips_league_id',
			'rules' => 'required|max_length[50]',
		),		
		array(
			'field' => 'match_id',
			'label' => 'lang:tips_match_id',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'bet_name',
			'label' => 'lang:tips_bet_name',
			'rules' => 'max_length[50]',
		),
		array(
			'field' => 'choice_name',
			'label' => 'lang:tips_choice_name',
			'rules' => 'max_length[30]',
		),		
		array(
			'field' => 'odd',
			'label' => 'lang:tips_odds',
			'rules' => 'max_length[10]',
		),
		array(
			'field' => 'stake',
			'label' => 'lang:tips_stake',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'created_by',
			'label' => 'lang:tips_created_by',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'created_on',
			'label' => 'lang:tips_created_on',
			'rules' => '',
		),
		array(
			'field' => 'result',
			'label' => 'lang:tips_result',
			'rules' => 'max_length[30]',
		),		
		array(
			'field' => 'status',
			'label' => 'lang:tips_status',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'winnings',
			'label' => 'lang:tips_winnings',
			'rules' => 'max_length[30]',
		),		
		array(
			'field' => 'views',
			'label' => 'lang:tips_views',
			'rules' => 'max_length[30]',
		),		


	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	//-----------------------------------------------	
	//   Get All Tips
	//-----------------------------------------------
	
	public function get_recent_tips()
	{
        $this->db->order_by('created_on', 'desc');
		$query = $this->db->get_where('tips',array('status' => 2));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}	
	
	public function get_popular_bets()
	{
		$this->db->select('*,count(tips.match_id) as total')
		->from('tips')
		->join('events', 'events.match_id = tips.match_id', 'left')
		->where('events.match_date >=' , date('Y-m-d'))
		->where('events.match_time >' , date('H:i'))
        ->order_by('total', 'desc')
		->group_by('events.match_id', 'desc');
		$query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;

	}
	public function get_last_minute_bets()
	{
		$this->db->select('*')
		->where('match_date',date('Y-m-d'))	
		->where('match_time >',date('H:i'))	
        ->order_by('match_time', 'asc')
		->group_by('match_id', 'desc');
		$query = $this->db->get('events');

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;

	}		
	//-----------------------------------------------	
	//   Get Tips By Sport
	//-----------------------------------------------
	
	public function get_tips_by_sport($sport_id)
	{
        
		$query = $this->db->get_where('tips',array('sport_id'=>$sport_id ,'status' => 2));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Get Tips By League
	//-----------------------------------------------
	
	public function get_tips_by_league($league_id)
	{

		$query = $this->db->get_where('tips',array('league_id'=>$league_id ,'status' => 2));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}	
	//-----------------------------------------------	
	//   Get Tip Single
	//-----------------------------------------------
	
	public function get_tip_by_id($id)
	{

		$query = $this->db->get_where('tips',array('id'=>$id));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Get Events By Id
	//-----------------------------------------------
	public function get_match_by_id($id)
	{

		$query = $this->db->get_where('results',array('match_id'=>$id));
		
		if($query->num_rows()>0)
		{
				return $query->result();
		}
			
		return FALSE;
    } 		
			
	//-----------------------------------------------	
	//   Get Related Tips
	//-----------------------------------------------
	
	public function get_related_tips($match_id, $id)
	{

		$query = $this->db->get_where('tips',array('match_id'=>$match_id,'id !='=>$id,'status'=> 2));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Get All Tipster Bets
	//-----------------------------------------------
	
	public function get_all_tipster_tips($user_id)
	{

		$query = $this->db->get_where('tips',array('created_by'=>$user_id));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Get All Active Tipster Bets
	//-----------------------------------------------
	
	public function get_active_tipster_tips($user_id)
	{

		$query = $this->db->get_where('tips',array('created_by'=>$user_id , 'status' =>  2));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Get Archived Tipster Bets
	//-----------------------------------------------
	
	public function get_archived_tipster_tips($user_id)
	{
		$this->db->order_by('created_on', 'desc')
				->where('created_by',$user_id)
				->where_not_in('status', array(1,2));
		
		$query = $this->db->get('tips');

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Count Tips By Status
	//-----------------------------------------------
	
	public function count_by_status()
	{
		$this->db->select(array(
				$this->statuses_table . '.id',
				$this->statuses_table . '.name',
				'count(1) as count',
			))
			->from($this->table_name)
			->join($this->statuses_table, $this->statuses_table . '.id = ' . $this->table_name . '.status', 'left')
			->group_by($this->table_name . '.status');


		$query = $this->db->get();

		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}
	
	//-----------------------------------------------	
	//   Count Tips By Sport
	//-----------------------------------------------
	
	public function count_by_sport()
	{
		$this->db->select(array($this->table_name . '.sport_id','count(1) as count'))
			->from($this->table_name)
			->where('status', 2)
			->order_by('sport_id', 'asc')
			->order_by('count', 'desc')
			->group_by($this->table_name . '.sport_id');

		$query = $this->db->get();
		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}	
	
	//-----------------------------------------------	
	//   Count Tips By League
	//-----------------------------------------------
	
	public function count_by_league($sport_id='')
	{
		$this->db->select(array(
				$this->table_name . '.league_id',
				'count(1) as count')
			)
			->from($this->table_name)
			->where('status', 2)
			->where('sport_id', $sport_id)
			->order_by('count', 'desc')
			->group_by($this->table_name . '.league_id');

		$query = $this->db->get();
		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}		


	//-----------------------------------------------	
	//   Get All Time Ranking
	//-----------------------------------------------
	
	public function all_time_ranking()
	{
		$this->db->select("created_by, status, avatar, country, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
		->from($this->table_name)
		->join($this->user_table, $this->user_table . '.id = ' . $this->table_name . '.created_by', 'left')
		->where($this->user_table . '.role_id !=' , 1) //exclude admin role
		->where('winnings !=', 0)
		->where('status !=', 1)
		->order_by('winnings', 'desc')
		->order_by('tips', 'desc')
		->group_by('display_name');

	  $query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}

	//-----------------------------------------------	
	//   Get Ranking For Last Six Months
	//-----------------------------------------------
	
	public function last_six_months_ranking()
	{
		$this->db->select("tips.created_on, avatar, country, created_by, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
			->from($this->table_name)
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')))
			->where($this->user_table . '.role_id !=' , 1) //exclude admin role
			->where('winnings !=', 0)
			->where('status !=', 1)
			->order_by('winnings', 'desc')
			->order_by('tips', 'desc')			
			->join($this->user_table, $this->user_table . '.id = ' . $this->table_name . '.created_by', 'left')
			->group_by('display_name');
    
	  $query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}		
	//-----------------------------------------------	
	//   Get Ranking For Last Three Months
	//-----------------------------------------------
	
	public function last_three_months_ranking()
	{
		$this->db->select("tips.created_on, avatar, country, created_by, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
			->from($this->table_name)
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')))
			->where($this->user_table . '.role_id !=' , 1) //exclude admin role
			->where('winnings !=', 0)
			->where('status !=', 1)
			->order_by('winnings', 'desc')
			->order_by('tips', 'desc')			
			->join($this->user_table, $this->user_table . '.id = ' . $this->table_name . '.created_by', 'left')
			->group_by('display_name');
    
	  $query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}		
	//-----------------------------------------------	
	//   Get Ranking For Last Month
	//-----------------------------------------------
	
	public function last_month_ranking()
	{
		$this->db->select("tips.created_on, avatar, country, created_by, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
			->from($this->table_name)
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')))
			->where($this->user_table . '.role_id !=' , 1) //exclude admin role
			->where('winnings !=', 0)
			->where('status !=', 1)
			->order_by('winnings', 'desc')
			->order_by('tips', 'desc')			
			->join($this->user_table, $this->user_table . '.id = ' . $this->table_name . '.created_by', 'left')
			->group_by('display_name');
    
	  $query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}		

	
	//-----------------------------------------------	
	//   Count All Tipster Bets
	//-----------------------------------------------
	
	public function count_all_tipster_tips($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as tips')
			)
			->from($this->table_name)
			->where_not_in('status', array(1,2))
			->where('created_by', $user_id);

		$query = $this->db->get();

        return $query->row()->tips;
	}		
	//-----------------------------------------------	
	//   Count All Active Tipster Bets
	//-----------------------------------------------
	
	public function count_all_active_tipster_tips($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as tips')
			)
			->from($this->table_name)
			->where('status ', 2)
			->where('created_by', $user_id);

		$query = $this->db->get();

        return $query->row()->tips;
	}	
	
	//-----------------------------------------------	
	//   Count All Tipster Bets For Last Six Months
	//-----------------------------------------------
	
	public function count_tipster_tips_last_six_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as tips')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')));

		$query = $this->db->get();

        return $query->row()->tips;
	}
	//-----------------------------------------------	
	//   Count All Tipster Bets For Last Three Months
	//-----------------------------------------------
	
	public function count_tipster_tips_last_three_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as tips')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')));

		$query = $this->db->get();

        return $query->row()->tips;
	}
	//-----------------------------------------------	
	//   Count All Tipster Bets For Last Month
	//-----------------------------------------------
	
	public function count_tipster_tips_last_month($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as tips')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')));

		$query = $this->db->get();

        return $query->row()->tips;
	}
	
	//-----------------------------------------------	
	//   Count All Tipster Won Bets
	//-----------------------------------------------
	
	public function count_all_tipster_won($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as won')
			)
			->from($this->table_name)
			->where('status', 3)
			->where('created_by', $user_id);

		$query = $this->db->get();

        return $query->row()->won;

	}
	
	//-----------------------------------------------	
	//  Count Tipster Won Bets For Last Six Months
	//-----------------------------------------------
	
	public function count_tipster_won_last_six_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as won')
			)
			->from($this->table_name)
			->where('status', 3)
			->where('created_by', $user_id)			
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')));

		$query = $this->db->get();

        return $query->row()->won;
	}
	//-----------------------------------------------	
	//  Count Tipster Won Bets For Last Three Months
	//-----------------------------------------------
	
	public function count_tipster_won_last_three_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as won')
			)
			->from($this->table_name)
			->where('status', 3)
			->where('created_by', $user_id)			
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')));

		$query = $this->db->get();

        return $query->row()->won;
	}
	//-----------------------------------------------	
	//  Count Tipster Won Bets For Last Month
	//-----------------------------------------------
	
	public function count_tipster_won_last_month($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as won')
			)
			->from($this->table_name)
			->where('status', 3)
			->where('created_by', $user_id)			
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')));


		$query = $this->db->get();

        return $query->row()->won;
	}	
	
	//-----------------------------------------------	
	//   Count All Tipster Lost Bets
	//-----------------------------------------------
		
	public function count_all_tipster_lost($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as lost')
			)
			->from($this->table_name)
			->where('status', 4)
			->where('created_by', $user_id);
			
		$query = $this->db->get();

        return $query->row()->lost;
	}
	
	//-----------------------------------------------	
	//   Count Tipster Lost Bets For Last Six Months
	//-----------------------------------------------
	
	public function count_tipster_lost_last_six_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as lost')
			)
			->from($this->table_name)
			->where('status', 4)
			->where('created_by', $user_id)						
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')));

		$query = $this->db->get();

        return $query->row()->lost;
	}
	//-----------------------------------------------	
	//  Count Tipster Lost Bets For Last Three Months
	//-----------------------------------------------
	
	public function count_tipster_lost_last_three_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as lost')
			)
			->from($this->table_name)
			->where('status', 4)
			->where('created_by', $user_id)			
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')));

		$query = $this->db->get();

        return $query->row()->lost;
	}
	//-----------------------------------------------	
	//  Count Tipster Lost Bets For Last Month
	//-----------------------------------------------
	
	public function count_tipster_lost_last_month($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as lost')
			)
			->from($this->table_name)
			->where('status', 4)
			->where('created_by', $user_id)			
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')));

		$query = $this->db->get();

        return $query->row()->lost;
	}
		
	//-----------------------------------------------	
	//   Count All Tipster Voided Bets
	//-----------------------------------------------
	
	public function count_all_tipster_void($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as void')
			)
			->from($this->table_name)
			->where('status', 5)
			->where('created_by', $user_id);

		$query = $this->db->get();

        return $query->row()->void;
	}	
	
	//-------------------------------------------------	
	//  Count Tipster Voided Bets For Last Six Months
	//-------------------------------------------------
	
	public function count_tipster_void_last_six_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as void')
			)
			->from($this->table_name)
			->where('status', 5)
			->where('created_by', $user_id)		
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')));

		$query = $this->db->get();

        return $query->row()->void;
	}	
	//--------------------------------------------------	
	//  Count Tipster Voided Bets For Last Three Months
	//--------------------------------------------------
	
	public function count_tipster_void_last_three_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as void')
			)
			->from($this->table_name)
			->where('status', 5)
			->where('created_by', $user_id)		
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')));

		$query = $this->db->get();

        return $query->row()->void;
	}
	//--------------------------------------------------	
	//  Count Tipster Voided Bets For Last Month
	//--------------------------------------------------
	
	public function count_tipster_void_last_month($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'count(created_by) as void')
			)
			->from($this->table_name)
			->where('status', 5)
			->where('created_by', $user_id)		
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')));

		$query = $this->db->get();

        return $query->row()->void;
	}	

	//-----------------------------------------------	
	//   Count All Tipster Stake 
	//-----------------------------------------------
	
	public function count_all_tipster_stake($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(stake) as stake')
			)
			->from($this->table_name)
			->where_not_in('status', array(1,2))
			->where('created_by', $user_id);
			
		$query = $this->db->get();

        return $query->row()->stake;
	}

	//-----------------------------------------------	
	//   Count Tipster Stake For Last Six Months
	//-----------------------------------------------
	
	public function count_tipster_stake_last_six_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(stake) as stake')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')));

		$query = $this->db->get();

        return $query->row()->stake;
	}	
	//-----------------------------------------------	
	//   Count Tipster Stake For Last Three Months
	//-----------------------------------------------
	
	public function count_tipster_stake_last_three_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(stake) as stake')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')));

		$query = $this->db->get();

        return $query->row()->stake;
	}
	//-----------------------------------------------	
	//   Count Tipster Stake For Last Month
	//-----------------------------------------------
	
	public function count_tipster_stake_last_month($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(stake) as stake')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')));
			

		$query = $this->db->get();

        return $query->row()->stake;
	}

	//-----------------------------------------------	
	//   Count All Tipster Profit 
	//-----------------------------------------------
	
	public function count_all_tipster_profit($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(winnings) as profit')
			)
			->from($this->table_name)
			->where_not_in('status', array(1,2))
			->where('created_by', $user_id);


		$query = $this->db->get();

        return $query->row()->profit;
	}	

	//-----------------------------------------------	
	//   Count Tipster Profit For Last Six Months
	//-----------------------------------------------
	
	public function count_tipster_profit_last_six_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(winnings) as profit')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')));

		$query = $this->db->get();
		
        return $query->row()->profit;
	}		
	//-----------------------------------------------	
	//   Count Tipster Profit For Last Three Months
	//-----------------------------------------------
	
	public function count_tipster_profit_last_three_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(winnings) as profit')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')));

		$query = $this->db->get();
		
        return $query->row()->profit;
	}
	//-----------------------------------------------	
	//   Count Tipster Profit For Last Month
	//-----------------------------------------------
	
	public function count_tipster_profit_last_month($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(winnings) as profit')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')));

		$query = $this->db->get();
		
        return $query->row()->profit;
	}
	
	//-----------------------------------------------	
	//   Count Tipster Average Odds
	//-----------------------------------------------
	
	public function count_all_tipster_avg_odds($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(odd) as odds')
			)
			->from($this->table_name)
			->where_not_in('status', array(1,2))
			->where('created_by', $user_id);

		$query = $this->db->get();
		
        return $query->row()->odds;
	}		
		
	//-----------------------------------------------	
	//   Count Average Odds For Last Six Months
	//-----------------------------------------------
	
	public function count_tipster_avg_odds_last_six_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(odd) as odds')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-6 month')));

		$query = $this->db->get();
		
        return $query->row()->odds;
	}		
	//-----------------------------------------------	
	//   Count Average Odds For Last Three Months
	//-----------------------------------------------
	
	public function count_tipster_avg_odds_last_three_months($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(odd) as odds')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-3 month')));

		$query = $this->db->get();
		
        return $query->row()->odds;
	}
	//-----------------------------------------------	
	//   Count Average Odds For Last Month
	//-----------------------------------------------
	
	public function count_tipster_avg_odds_last_month($user_id)
	{
		$this->db->select(array(
				$this->table_name . '.created_by',
				'sum(odd) as odds')
			)
			->from($this->table_name)
			->where('created_by', $user_id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', date("Y-m-d 00:00:00", strtotime('-1 month')));

		$query = $this->db->get();
		
        return $query->row()->odds;
	}
	//-----------------------------------------------	
	//   Count All Active Tips
	//-----------------------------------------------
	
	public function count_all_active_tips()
	{
		$this->db->where('status',2);
		$query = $this->db->get('tips');
		return $query->num_rows();

	}	
	//-----------------------------------------------	
	//   Count All Ended Tips
	//-----------------------------------------------
	
	public function count_all_ended_tips()
	{
		$this->db->where_not_in('status', array(1,2));
		$query = $this->db->get('tips');
		return $query->num_rows();

	}				
	//-----------------------------------------------	
	//   Count All Won Tips
	//-----------------------------------------------
	
	public function count_all_won_tips()
	{
		$query = $this->db->get_where('tips',array('status' => 3));

		return $query->num_rows();

	}
	//-----------------------------------------------	
	//   Count All Won Tips
	//-----------------------------------------------
	
	public function count_all_lost_tips()
	{
		$query = $this->db->get_where('tips',array('status' => 4));

		return $query->num_rows();
	}	
	//-----------------------------------------------	
	//   Count All Void Tips
	//-----------------------------------------------
	
	public function count_all_void_tips()
	{
		$query = $this->db->get_where('tips',array('status' => 5));

		return $query->num_rows();
		
	}
	//-----------------------------------------------	
	//   Count Total Units Staked
	//-----------------------------------------------
	
	public function count_total_stake()
	{
		$this->db->select(array(
				$this->table_name . '.stake',
				'sum(stake) as stake')
			)
			->from($this->table_name)
			->where_not_in('status', array(1,2));

		$query = $this->db->get();
		
        return $query->row()->stake;
		
	}
	//-----------------------------------------------	
	//   Count Total Profit
	//-----------------------------------------------
	
	public function count_total_profit()
	{
		$this->db->select(array(
				$this->table_name . '.winnings',
				'sum(winnings) as winnings')
			)
			->from($this->table_name)
			->where('status !=', 1);

		$query = $this->db->get();
		
        return $query->row()->winnings;
		
	}		
 
	//-----------------------------------------------
	
	public function get_tips_statuses()
	{

		$this->db->select('id, name');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('tip_statuses');
		return $query;
	}
	//----------------------------------------------
	
	public function get_tips_statuses_select ()
	{
		$table_name          = $this->table_name;
		$this->table_name	= 'tip_statuses';

		$options = $this->format_dropdown('id', 'name');

		$this->table_name    = $table_name;
		unset ( $table_name );

		return $options;
	} 
 
	//-----------------------------------------------
	
	public function get_tips_status_name_by_id($id='')
	{
		$query = $this->db->get_where('tip_statuses',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->name;
		}
		else
			return '';
	}
   
	//-----------------------------------------------	
    function updateTipView($id)
    {
         $this->db->set('views', 'views+1', FALSE);
         $this->db->where('id', $id);
         $this->db->update('tips');
    }	

	//-----------------------------------------------	
    function updateProfileView($user_id)
    {
         $this->db->set('profile_views', 'profile_views+1', FALSE);
         $this->db->where('id', $user_id);
         $this->db->update('users');
    }
  
	//-----------------------------------------------	
	public function get_frends_activities($following_id)
	{
        $this->db->order_by('created_on', 'desc');
		$this->db->where('status', 2);
		$this->db->where_in('created_by', $following_id);
		$this->db->group_by('created_by');
		$query = $this->db->get('tips');

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}		
	
	//-----------------------------------------------		
	
	function get_all_leagues()
	{
		$query = $this->db->get_where('leagues',array('active'=>1));
		$leagues = array();
		foreach ($query->result() as $row) {
			array_push($leagues,$row);
			$child_query = $this->db->get_where('leagues',array('sport_id'=>$row->sport_id,'active'=>1));
			foreach ($child_query->result() as $child) {
				array_push($leagues,$child);
			}

		}
		return $leagues;
	}	
	//-----------------------------------------------	
	public function get_league_top_tipsters($id)
	{
		$this->db->select("tips.created_by, tips.created_on, tips.sport_id, tips.league_id, avatar, country, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
		->from($this->table_name)
		->join($this->user_table, $this->user_table . '.id = ' . $this->table_name . '.created_by', 'left')
		->where($this->user_table . '.role_id !=' , 1) //exclude admin role
		->where('winnings !=', 0)
		->where('status !=', 1)
		->where('tips.league_id', $id)
		->order_by('winnings', 'desc')
		->order_by('tips', 'desc')
		->group_by('display_name');

		$query = $this->db->get();

			return $query->result();

	}	
	//-----------------------------------------------	
	public function count_league_tips($id)
	{
		$query = $this->db->get_where('tips',array('league_id' => $id));

		return $query->num_rows();
		
	}	
	//-----------------------------------------------	
	public function count_league_profit($id)
	{
		$this->db->select("league_id,winnings,  sum(winnings) as winnings")
		->from($this->table_name)
		->where('league_id', $id);
		$query = $this->db->get();

		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->winnings;
		}
		else
			return '';
		
	}		
}