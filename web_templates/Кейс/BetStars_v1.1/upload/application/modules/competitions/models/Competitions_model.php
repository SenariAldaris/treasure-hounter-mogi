<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Competitions Model
 *
 * This class handles competitions
 *
 * @package		Competitions
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Competitions_model extends MY_Model
{
	/** @var string Name of the competitions table. */
    protected $table_name	= 'competitions';
	
	protected $key			= 'id';
	protected $date_format	= 'datetime';
	
	/** @var string Name of the users table. */
	protected $user_table   = 'users';
	
	/** @var string Name of the tips table. */
	protected $tips_table   = 'tips';

	protected $log_user 	= false;
	protected $set_created	= false;
	protected $set_modified = false;
	protected $soft_deletes	= false;


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
			'field' => 'name',
			'label' => 'lang:competitions_field_name',
			'rules' => 'required|max_length[255]',
		),
		array(
			'field' => 'sport_id',
			'label' => 'lang:competitions_field_sport',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'championship_id',
			'label' => 'lang:competitions_field_championship',
			'rules' => 'max_length[11]',
		),		
		array(
			'field' => 'league_id',
			'label' => 'lang:competitions_field_league',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'description',
			'label' => 'lang:competitions_field_description',
			'rules' => 'required',
		),
		array(
			'field' => 'start_date',
			'label' => 'lang:competitions_field_start_date',
			'rules' => 'required',
		),
		array(
			'field' => 'end_date',
			'label' => 'lang:competitions_field_end_date',
			'rules' => 'required',
		),
		array(
			'field' => 'price_pool',
			'label' => 'lang:competitions_field_price_pool',
			'rules' => 'required|max_length[5]',
		),
		array(
			'field' => 'rewards',
			'label' => 'lang:competitions_field_rewards',
			'rules' => 'required|max_length[20]',
		),
		array(
			'field' => 'sponsored_by',
			'label' => 'lang:competitions_field_sponsored_by',
			'rules' => 'required|max_length[3]',
		),
		array(
			'field' => 'min_tips',
			'label' => 'lang:competitions_field_min_tips',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'winner',
			'label' => 'lang:competitions_field_winner',
			'rules' => 'max_length[11]',
		),		
		array(
			'field' => 'active',
			'label' => 'lang:competitions_field_active',
			'rules' => 'max_length[1]',
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
	//   Get Competitions
	//-----------------------------------------------
		
	public function get_competitions()
	{

		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('competitions');
		return $query;
	}
	
	//-----------------------------------------------	
	//   Get Competitions Selects
	//-----------------------------------------------
	
	public function get_competitions_select ()
	{
		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('competitions');
		
	 
		$competitions = array();
	 
		if ($query-> result()) 
		{
		  foreach ($query->result() as $competition) 
		  {
			$competitions[$competition->id] = $competition->name;
		  } 
		  return $competitions;
		} 
		else 
		{
		  return FALSE;
		}

    }  
	
	//-----------------------------------------------	
	//   Get Competition By Id
	//-----------------------------------------------
	
	public function get_competition_by_id($id)
	{

		$query = $this->db->get_where('competitions',array('id'=>$id));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}	
	
	//-----------------------------------------------	
	//   Get Competition Name
	//-----------------------------------------------
	
	public function get_competition_name_by_id($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->name;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Competition Name
	//-----------------------------------------------
	
	public function get_competition_name_and_date_by_id($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->name . '  ( ' . date('M d,Y',strtotime($row->start_date)) . '-' . date('M d,Y',strtotime($row->end_date)) . ' )';
		}
		else
			return '';
	}			
	//-----------------------------------------------	
	//   Get Competition Rewards
	//-----------------------------------------------
	
	public function get_competition_rewards($id='')
	{

		$query = $this->db->get_where('competition_rewards',array('competition_id'=>$id));

		return $query;
	}
	
	
	//-----------------------------------------------	
	//   Get Competition Number of Rewards
	//-----------------------------------------------
	
	public function get_competition_num_rewards($id='')
	{

		$query = $this->db->get_where('competitions',array('id'=>$id));

		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->rewards;
		}
		else
			return '';
	}	

	//-----------------------------------------------	
	//   Get Competition Mim tips
	//-----------------------------------------------
	
	public function get_currency($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->currency;
		}
		else
			return '';
	}		
	//-----------------------------------------------	
	//   Get Competition Start Date
	//-----------------------------------------------
	
	public function get_competition_start_date($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->start_date;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Competition End Date
	//-----------------------------------------------
	
	public function get_competition_end_date($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->end_date;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Competition Sport
	//-----------------------------------------------
	
	public function get_competition_sport($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->sport_id;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Competition League
	//-----------------------------------------------
	
	public function get_competition_league($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->league_id;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Competition Mim tips
	//-----------------------------------------------
	
	public function get_competition_min_tips($id='')
	{
		$query = $this->db->get_where('competitions',array('id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->min_tips;
		}
		else
			return '';
	}		
	//-----------------------------------------------	
	//   Competition Ranking
	//-----------------------------------------------
	
	public function competition_rankings($start,$end)
	{

	    $start = trim($start);
        $end = trim($end);	

		$this->db->select("tips.created_by, tips.created_on, tips.sport_id, tips.league_id, avatar, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
		->from($this->tips_table)
		->join($this->user_table, $this->user_table . '.id = ' . $this->tips_table . '.created_by', 'left')
		->where($this->user_table . '.role_id !=' , 1) //exclude admin role
		->where('winnings !=', 0)
		->where_not_in('status', array(1,2))
		->where('tips.created_on >=', $start)
		->where('tips.created_on <=', $end)
		->order_by('winnings', 'desc')
		//->order_by('tips', 'desc')
		->group_by('display_name');

		$query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;
	}
	
	
	public function competition_winner($start,$end)
	{

	    $start = trim($start);
        $end = trim($end);	

		$this->db->select("tips.created_by, tips.created_on, tips.sport_id, tips.league_id, avatar, display_name, users.id, sum(winnings) as winnings, count(1) as tips")
		->from($this->tips_table)
		->join($this->user_table, $this->user_table . '.id = ' . $this->tips_table . '.created_by', 'left')
		->where($this->user_table . '.role_id !=' , 1) //exclude admin role
		->where('winnings !=', 0)
		->where_not_in('status', array(1,2))
		->where('tips.created_on >=', $start)
		->where('tips.created_on <=', $end)
		->order_by('winnings', 'desc')
		//->order_by('tips', 'desc')
		->group_by('display_name')
		->limit(1);

		$query = $this->db->get();

		return $query->row()->created_by;
		
	}
	//-----------------------------------------------	
	//   Count Tipster Tips By Period 
	//   this is for competitions ranking
	//-----------------------------------------------
	
	public function count_tipster_tips_by_period($id,$from,$to)
	{
		$this->db->select(array(
				$this->tips_table . '.created_by',
				'count(created_by) as tips')
			)
			->from($this->tips_table)
			->where('created_by', $id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', $from)
			->where('tips.created_on <=', $to);

		$query = $this->db->get();

        return $query->row()->tips;
	}
	//-----------------------------------------------	
	//   Count Tipster Won Tips By Period 
	//   this is for competitions ranking
	//-----------------------------------------------
	
	public function count_tipster_won_by_period($id,$from,$to)
	{
		$this->db->select(array(
				$this->tips_table . '.created_by',
				'count(created_by) as won')
			)
			->from($this->tips_table)
			->where('created_by', $id)
			->where('status', 3)
			->where('tips.created_on >=', $from)
			->where('tips.created_on <=', $to);

		$query = $this->db->get();

        return $query->row()->won;
	}	
	//-----------------------------------------------	
	//   Count Tipster Lost Tips By Period 
	//   this is for competitions ranking
	//-----------------------------------------------
	
	public function count_tipster_lost_by_period($id,$from,$to)
	{
		$this->db->select(array(
				$this->tips_table . '.created_by',
				'count(created_by) as lost')
			)
			->from($this->tips_table)
			->where('created_by', $id)
			->where('status', 4)
			->where('tips.created_on >=', $from)
			->where('tips.created_on <=', $to);

		$query = $this->db->get();

        return $query->row()->lost;
	}
	//-----------------------------------------------	
	//   Count Tipster Void Tips By Period 
	//   this is for competitions ranking
	//-----------------------------------------------
	
	public function count_tipster_void_by_period($id,$from,$to)
	{
		$this->db->select(array(
				$this->tips_table . '.created_by',
				'count(created_by) as void')
			)
			->from($this->tips_table)
			->where('created_by', $id)
			->where('status', 5)
			->where('tips.created_on >=', $from)
			->where('tips.created_on <=', $to);

		$query = $this->db->get();

        return $query->row()->void;
	}
	//-----------------------------------------------	
	//   Count Tipster Stake By Period 
	//   this is for competitions ranking
	//-----------------------------------------------
	
	public function count_tipster_stake_by_period($id,$from,$to)
	{
		$this->db->select(array(
				$this->tips_table . '.created_by',
				'sum(stake) as stake')
			)
			->from($this->tips_table)
			->where('created_by', $id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', $from)
			->where('tips.created_on <=', $to);

		$query = $this->db->get();

        return $query->row()->stake;
	}
	//-----------------------------------------------	
	//   Count Tipster Odds By Period 
	//   this is for competitions ranking
	//-----------------------------------------------
	
	public function count_tipster_odds_by_period($id,$from,$to)
	{
		$this->db->select(array(
				$this->tips_table . '.created_by',
				'sum(odd) as odds')
			)
			->from($this->tips_table)
			->where('created_by', $id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', $from)
			->where('tips.created_on <=', $to);

		$query = $this->db->get();

        return $query->row()->odds;
	}	
	//-----------------------------------------------	
	//   Count Tipster Profit By Period 
	//   this is for competitions ranking
	//-----------------------------------------------
	
	public function count_tipster_profit_by_period($id,$from,$to)
	{
		$this->db->select(array(
				$this->tips_table . '.created_by',
				'sum(winnings) as profit')
			)
			->from($this->tips_table)
			->where('created_by', $id)
			->where_not_in('status', array(1,2))
			->where('tips.created_on >=', $from)
			->where('tips.created_on <=', $to);

		$query = $this->db->get();

        return $query->row()->profit;
	}		
	//-----------------------------------------------	
	//   Get Competition Rewards
	//-----------------------------------------------
	
	public function get_rewards($id='',$place)
	{

		$query = $this->db->get_where('competition_rewards',array('competition_id'=>$id, 'place'=> $place));

		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->reward;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Competition Winner
	//-----------------------------------------------
	
	public function get_competition_winner($id='')
	{

		$query = $this->db->get_where('competitions',array('id'=>$id));

		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->winner;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Tipster Competitions Won
	//-----------------------------------------------
	
	public function get_tipster_competitions_won($id='')
	{

		$query = $this->db->get_where('competitions',array('winner'=>$id));

		return $query->num_rows();
	}	
	//-----------------------------------------------	
	//   Get Tipster of the month Won
	//-----------------------------------------------
	
	public function get_tipster_of_the_month_won($id='')
	{

		$query = $this->db->get_where('competitions',array('winner'=>$id,'type'=>1));

		return $query->num_rows();
	}
	//-----------------------------------------------	
	//   Get Tipster of the year Won
	//-----------------------------------------------
	
	public function get_tipster_of_the_year_won($id='')
	{

		$query = $this->db->get_where('competitions',array('winner'=>$id,'type'=> 2));

		return $query->num_rows();
	}
	//-----------------------------------------------	
	//   Get Tipster other competitions Won
	//-----------------------------------------------
	
	public function get_tipster_other_won($id='')
	{

		$query = $this->db->get_where('competitions',array('winner'=>$id,'type'=> 3));

		return $query->num_rows();
	}		
}