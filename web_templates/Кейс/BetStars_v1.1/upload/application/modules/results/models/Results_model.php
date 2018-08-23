<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Bet_Events Model
 *
 * This class handles bet events
 *
 * @package		Bet Events
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Results_model extends MY_Model
{
	/** @var string Name of the bet_events table. */
    protected $table_name	= 'results';
	protected $key			= 'id';
	protected $date_format	= 'datetime';
	
	/** @var string Name of the tips table. */
	protected $tips_table	= 'tips';
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
	protected $return_insert_id = false;

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
			'label' => 'lang:bet_events_sport_id',
			'rules' => 'required|max_length[10]',
		),
		array(
			'field' => 'league_id',
			'label' => 'lang:bet_events_league_id',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'date',
			'label' => 'lang:bet_events_date',
			'rules' => 'required',
		),
		array(
			'field' => 'time',
			'label' => 'lang:bet_events_time',
			'rules' => 'required',
		),
		array(
			'field' => 'active',
			'label' => 'lang:bet_events_active',
			'rules' => 'max_length[1]',
		),
		array(
			'field' => 'event',
			'label' => 'lang:bet_events_event_full',
			'rules' => 'max_length[100]',
		),		
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= true;

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
	//   Get Result By match
	//-----------------------------------------------
	public function get_result_by_match_name($match_name,$sport_id)
	{
		$query = $this->db->get_where('results',array('match_name'=>$match_name,'sport_id'=>$sport_id));		
		return $query->result();
    } 		
	//-----------------------------------------------	
	//   Get Results
	//-----------------------------------------------
	public function get_results_by_team($team,$sport_id)
	{
		$team = trim($team);
        $this->db->or_having(array('home_team' => $team,'away_team' => $team))
	    ->where('match_date <',date('Y-m-d'))
		->where('sport_id',$sport_id)
		->order_by('match_date','desc')
		->order_by('match_time','asc');
		$query = $this->db->get('results');

		return $query->result();

	}	
	//-----------------------------------------------	
	//   Get Head To Head Results
	//-----------------------------------------------
	public function get_head_to_head_results_h($home,$away,$sport_id)
	{

		$this->db->where('home_team',$home)
		->where('away_team',$away)
		->where('match_date <',date('Y-m-d'))
		->where('sport_id',$sport_id)
		->order_by('match_date','desc')
		->order_by('match_time','asc');
		$query = $this->db->get('results');

		return $query->result();

	}
	public function get_head_to_head_results_a($home,$away,$sport_id)
	{

		$this->db->where('home_team',$away)
		->where('away_team',$home)
		->where('match_date <',date('Y-m-d'))
		->where('sport_id',$sport_id)
		->order_by('match_date','desc')
		->order_by('match_time','asc');
		$query = $this->db->get('results');

		return $query->result();

	}		
///////////////////////////////////////////////////////////////////////	
	public function update_results()
	{
		
		$this->db->select('sport_id ,league_id,match_id,home_team,away_team,match_date,match_time');
		$query = $this->db->get('events');
		
		foreach ($query->result() as $row) {
		

			$q = $this->db->get_where('results', array('league_id' =>$row->league_id,'match_id' => $row->match_id));
				
			if($q->num_rows()>0) {}
			
			else
			{			
				$this->db->insert('results',$row);
			}
	
		}		
	}

//////////////////////////////////////////////////////	
	public function update_teams1()
	{		
		$this->db->select('sport_id,league_id,home_team');
		$query = $this->db->order_by('league_id')->get('events');
		
		foreach ($query->result() as $row) 
		{
	
			$q = $this->db->get_where('teams',array('name'=> $row->home_team,'league_id' => $row->league_id,'sport_id' => $row->sport_id));
			

			$data['name'] = $row->home_team;
			$data['league_id'] = $row->league_id;
			$data['sport_id'] = $row->sport_id;
				
			if($q->num_rows()> 0 ) { }
			
			else
			{
				$this->db->insert('teams',$data);
			}
					
		}		
	}
//////////////////////////////////////////////////////	
	public function update_teams2()
	{	
		$this->db->select('sport_id,league_id,away_team');
		$query = $this->db->order_by('league_id')->get('events');
		
		foreach ($query->result() as $row) 
		{

			$q = $this->db->get_where('teams',array('name'=> $row->away_team,'league_id' => $row->league_id,'sport_id' => $row->sport_id));
			
			$data['name'] = $row->away_team;
			$data['league_id'] = $row->league_id;
			$data['sport_id'] = $row->sport_id;
				
			if($q->num_rows()> 0 ) { }
			
			else
			{
				$this->db->insert('teams',$data);
			}
					
		}		
	}
//////////////////////////////////////////////////////	
	public function update_teams3()
	{	
		$this->db->select('league_id,bet_name,choice_name');
		$this->db->where('bet_name' , 'Outright Winner');
		$query = $this->db->get('bets');
		
		foreach ($query->result() as $row) 
		{
		
			$this->load->model('leagues/leagues_model');
			$sport_id = $this->leagues_model->get_league_sport_id_by_id($row->league_id);
			

			$q = $this->db->get_where('teams',array('name'=> $row->choice_name,'league_id' => $row->league_id,'sport_id' => $sport_id));
			
			if($q->num_rows()> 0) {}
			
			else
			{
				$data['name'] = $row->choice_name;
				$data['league_id'] = $row->league_id;
				$data['sport_id'] = $sport_id;
				
				$this->db->insert('teams',$data);
			}		
		}		
	}	
//////////////////////////////////////////////////////	
	public function clean_up_teams()
	{
			
		$sql = "DELETE FROM teams  
		WHERE team_id IN (SELECT * 
					 FROM (SELECT team_id FROM teams 
						   GROUP BY sport_id, league_id, name HAVING (COUNT(*) > 1)
						  ) AS A
					)";        
       $query = $this->db->query($sql);			
	}				
	//-----------------------------------------------	
	//   Get Result By match id
	//-----------------------------------------------	
	public function get_result_by_match_id($match_id)
	{
		$this->db->where('match_id',$match_id);
		
		$query = $this->db->get('results');
		
		return $query->result();
	}	
	//-----------------------------------------------	
	//   Get Events By League
	//-----------------------------------------------
	public function get_by_league($id='')
	{
        $this->db->where('league_id',$id)
		->where('match_date <',date('Y-m-d'))
		->order_by('match_date','desc')
		->order_by('match_time','asc');
		$query = $this->db->get('results');
		
		return $query->result();
	}		

/////////////////////////////////////////////////////////////////////////	
}