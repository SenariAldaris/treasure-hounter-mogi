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
 
class Bet_events_model extends MY_Model
{
	/** @var string Name of the bet_events table. */
    protected $table_name	= 'events';
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
			'field' => 'featured',
			'label' => 'lang:bet_events_featured',
			'rules' => 'max_length[1]',
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
	//   Count All Active Events
	//-----------------------------------------------
	
	public function count_all_active_events()
	{
		$this->db->where('match_date', date('Y-m-d'))
				 ->where('match_time >',date('H:i'));
		$query = $this->db->get('events');
		return $query->num_rows();

	}		
	//-----------------------------------------------	
	//   Count All Active Events by Sport
	//-----------------------------------------------
	
	public function count_all_active_events_by_sport($sport_id)
	{
		$this->db->where('match_date', date('Y-m-d'))
				 ->where('match_time >',date('H:i'))
				 ->where('sport_id',$sport_id);
		$query = $this->db->get('events');
		return $query->num_rows();

	}		
	//-----------------------------------------------	
	//   Count All Active Events by Country
	//-----------------------------------------------
	
	public function count_all_active_events_by_country($country_id,$sport_id)
	{
		$this->db->select()
				->from('events')
				->join('leagues', 'leagues.league_id = events.league_id', 'left')
				->where('match_date', date('Y-m-d'))
				 ->where('match_time >',date('H:i'))
				 ->where('leagues.country_id',$country_id)
				 ->where('leagues.sport_id',$sport_id);
		$query = $this->db->get();
		return $query->num_rows();

	}
	//-----------------------------------------------	
	//   Count All Active Events by League
	//-----------------------------------------------
	
	public function count_all_active_events_by_league($league_id,$sport_id)
	{
		$this->db->where('match_date', date('Y-m-d'))
				 ->where('match_time >',date('H:i'))
				 ->where('league_id',$league_id)
				 ->where('sport_id',$sport_id);
		$query = $this->db->get('events');
		return $query->num_rows();

	}		
	//-----------------------------------------------	
	//   Count Events By Sport
	//-----------------------------------------------
	
	public function get_all_sports()
	{
		$this->db->order_by('display_order');
		$query = $this->db->get_where('sports',array('active'=>1));
		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}		
	//-----------------------------------------------	
	//   Count Events By Country
	//-----------------------------------------------
	
	public function get_all_countries($sport_id)
	{
		$this->db->select()
			->from('countries')
			->join('leagues', 'leagues.country_id = countries.id', 'left')
			->where('leagues.active',1)
			->where('leagues.sport_id', $sport_id)
			->order_by('countries.name', 'asc')
			->group_by('countries.id');

		$query = $this->db->get();
		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}		
	//-----------------------------------------------	
	//   Count Events By League
	//-----------------------------------------------
	
	public function get_all_leagues($country_id,$sport_id)
	{

		$query = $this->db->get_where('leagues',array('country_id'=>$country_id,'sport_id'=>$sport_id,'active'=>1));

			return $query->result();

	}			
	
	
	
	//-----------------------------------------------	
	//   Get Events
	//-----------------------------------------------
	
	public function get_events()
	{
		$query = $this->db->get('events');

		return $query->result();
	}	
	//-----------------------------------------------	
	//   Get Active Events
	//-----------------------------------------------
	
	public function get_active_events()
	{
		$query = $this->db->get_where('events',array('match_time >' => date('H:i'),'match_date >' => date('Y-m-d')));

		return $query->result();
	}		
	//-----------------------------------------------	
	//   Get Featured Events
	//-----------------------------------------------
	
	public function get_featured_events()
	{
		$query = $this->db->get_where('events',array('match_time >' => date('H:i'),'match_date' => date('Y-m-d'),'featured' => 1));

		return $query->result();
	}	

	//-----------------------------------------------	
	//   Get Events By League
	//-----------------------------------------------
	public function get_events_by_league_id($id='')
	{
        $this->db->select('id, match_id,home_team,away_team, match_date, match_time, league_id')
		->where('match_time >',date('H:i'))
		->where('league_id',$id)
		->order_by('match_date','desc');
   
		$query = $this->db->get('events');
		
        $events = array();
		
     if($query->result()){
            foreach ($query->result() as $event) {
                $events[$event->match_id] = $event->home_team  . ' - ' .$event->away_team . ' , ' . date('M j, Y', strtotime($event->match_date)) . '/' . date('H:i', strtotime($event->match_time)) ;
            }
            return $events;
        } else 
		{
            return FALSE;
        }
    } 	
	
	//-----------------------------------------------	
	//   Get Events By League
	//-----------------------------------------------
	public function get_by_league($id='')
	{
        $this->db->where('league_id',$id)
		->order_by('match_date','asc');
		$query = $this->db->get('events');
		
		return $query->result();
	}		
	//-----------------------------------------------	
	//   Get Sport ID of Event
	//-----------------------------------------------
	
	public function get_sport_by_event_id($id='')
	{
		$query = $this->db->get_where('events',array('match_id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->sport_id;
		}
		else
			return '';
	}		

	//-----------------------------------------------	
	//   Get League ID of Event
	//-----------------------------------------------
	
	public function get_league_by_event_id($id='')
	{
		$query = $this->db->get_where('events',array('match_id'=>$id));

		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->league_id;
		}
		else
			return '';
	}		

	//-----------------------------------------------	
	//   Get Match Name From Event
	//-----------------------------------------------
	
	public function get_match_name_by_id($id)
	{
		$query = $this->db->get_where('events',array('match_id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->home_team . ' - ' . $row->away_team;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Event Date
	//-----------------------------------------------
	
	public function get_match_date_by_id($id='')
	{
		$query = $this->db->get_where('events',array('match_id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->match_date;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Event Time
	//-----------------------------------------------
	
	public function get_match_time_by_id($id='')
	{
		$query = $this->db->get_where('events',array('match_id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->match_time;
		}
		else
			return '00:00:00';
	}

	//-----------------------------------------------	
	//   Get Bet Name by Id
	//-----------------------------------------------
	
	public function get_bet_name_by_id($bet_id,$match_id)
	{
		$query = $this->db->get_where('bets',array('bet_id' => $bet_id,'match_id' => $match_id));

		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->bet_name;
		}
		else
			return '';
	}

	//-----------------------------------------------	
	//   Get Event Home Odds
	//-----------------------------------------------
	
	public function get_home_odds($id)
	{
		$this->db->select('bets.match_id,events.home_team')
		->join('events', 'events.match_id = bets.match_id', 'left')
		->where('bets.match_id',$id);
		$q = $this->db->get('bets');

		if($q->num_rows()>0)
		{
			$row = $q->row();
			$home = $row->home_team;

		}

		$query = $this->db->select('odd','match_id','choice_name');
				
		$this->db->where('choice_name',$home);
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->odd;
		}
		else
			return '';
	}

	//-----------------------------------------------	
	//   Get Event Away Odds
	//-----------------------------------------------
	
	public function get_away_odds($id)
	{
		$this->db->select('bets.match_id,events.away_team')
		->join('events', 'events.match_id = bets.match_id', 'left')
		->where('bets.match_id',$id);
		$q = $this->db->get('bets');

		$row = $q->row();
		$away = $row->away_team;

		$query = $this->db->select('odd','match_id','match_name','choice_name');
				
		$this->db->where('choice_name',$away);
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->odd;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Event Draw Odds
	//-----------------------------------------------
	
	public function get_draw_odds($id)
	{

		$query = $this->db->select('odd','match_id','choice_name');
				
		$this->db->where('choice_name','Draw');
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->odd;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Home Bet Id
	//-----------------------------------------------
	
	public function get_home_bet_id($id)
	{
		$this->db->select('bets.match_id,home_team')
		->join('events', 'events.match_id = bets.match_id', 'left')
		->where('bets.match_id',$id);
		$q = $this->db->get('bets');

		$row = $q->row();
		$home = $row->home_team;			
		
		$query = $this->db->select('bet_id','match_id','choice_name');
				
		$this->db->where('choice_name',$home);
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->bet_id;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Home Choice Id
	//-----------------------------------------------
	
	public function get_home_choice_id($id)
	{
		$this->db->select('bets.match_id,home_team')
		->join('events', 'events.match_id = bets.match_id', 'left')
		->where('bets.match_id',$id);
		$q = $this->db->get('bets');

		$row = $q->row();
		$home = $row->home_team;

		$query = $this->db->select('choice_id','match_id','choice_name');
				
		$this->db->where('choice_name',$home);
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->choice_id;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Home Bet Id
	//-----------------------------------------------
	
	public function get_draw_bet_id($id)
	{

		$query = $this->db->select('bet_id','match_id','choice_name');
				
		$this->db->where('choice_name','Draw');
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->bet_id;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Draw Choice Id
	//-----------------------------------------------
	
	public function get_draw_choice_id($id)
	{

		$query = $this->db->select('choice_id','match_id','choice_name');
				
		$this->db->where('choice_name','Draw');
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->choice_id;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Draw Bet Id
	//-----------------------------------------------
	
	public function get_away_bet_id($id)
	{
		$this->db->select('bets.match_id,away_team')
		->join('events', 'events.match_id = bets.match_id', 'left')
		->where('bets.match_id',$id);
		$q = $this->db->get('bets');

		$row = $q->row();
		$away = $row->away_team;
			
		$query = $this->db->select('bet_id','match_id','choice_name');
				
		$this->db->where('choice_name',$away);
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->bet_id;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Away Choice Id
	//-----------------------------------------------
	
	public function get_away_choice_id($id)
	{
		$this->db->select('bets.match_id,away_team')
		->join('events', 'events.match_id = bets.match_id', 'left')
		->where('bets.match_id',$id);
		$q = $this->db->get('bets');

		$row = $q->row();
		$away = $row->away_team;

		$query = $this->db->select('choice_id','match_id','choice_name');
				
		$this->db->where('choice_name',$away);
		$this->db->where('match_id',$id);
		$this->db->where_in('bet_name',array('Match Result','Match Winner','Match Winner 2'));

		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->choice_id;
		}
		else
			return '';
	}		
	//-----------------------------------------------	
	//   Get Most Betted Events
	//-----------------------------------------------
	
	public function get_most_betted_events()
	{
		$this->db->select('*, count(tips.match_id) as events')
		->join('events', 'events.match_id = tips.match_id', 'left')
        ->order_by('events', 'desc')
		->group_by('events.match_id', 'desc');
		$query = $this->db->get_where('tips',array('status' => 2));

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;

	}
	//-----------------------------------------------	
	//   Get Most Betted Events
	//-----------------------------------------------
	
	public function get_outright_bets($league_id)
	{
		$this->db->where('league_id', $league_id)
		->where('bet_name', 'Outright Winner')
		->order_by('odd','asc');
		$query = $this->db->get('bets');

		if($query->num_rows()>0)
		{
			return $query->result();
		}

		return FALSE;

	}
	//-----------------------------------------------	
	//   Get Most Betted Events
	//-----------------------------------------------	
	public function get_outright_bet_id($league_id)
	{
		$this->db->where('league_id',$league_id)
		->where('bet_name', 'Outright Winner');
		
		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->bet_id;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Most Betted Events
	//-----------------------------------------------	
	public function get_outright_match_id($league_id)
	{
		$this->db->where('league_id',$league_id)
		->where('bet_name', 'Outright Winner');
		
		$query = $this->db->get('bets');
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->match_id;
		}
		else
			return '';
	}	
	//-----------------------------------------------	
	//   Get Active Leagues
	//-----------------------------------------------
	
	public function get_live_leagues_by_sport_id($id)
	{
		$this->db->select('leagues.league_id,leagues.league_name,country_id,leagues.sport_id,events.league_id')
			->from('leagues')
			->join('events', 'events.league_id = leagues.league_id', 'left')
			->where('match_date',date('Y-m-d'))	
			->where('match_time >',date('H:i'))			
			->where('leagues.sport_id', $id)
			->group_by('leagues.league_id')
			//->order_by('leagues.sport_id')
			->order_by('leagues.id');


		$query = $this->db->get();

		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}

	//-----------------------------------------------	
	//   Get Active Events
	//-----------------------------------------------
	public function get_live_events_by_league($league_id)
	{
		$this->db->select('leagues.league_id,events.league_id,home_team,away_team,match_date,match_time,match_id')
			->from('events')
			->join('leagues', 'leagues.league_id = events.league_id', 'left')
			->join('sports', 'sports.id = events.sport_id', 'left')
			->where('events.league_id', $league_id)
			->where('sports.active',1)
			->where('match_date ',date('Y-m-d'))
			->where('match_time >',date('H:i'))			
			->order_by('leagues.id');
			//->order_by('match_date','asc')
			//->order_by('match_time','asc');


		$query = $this->db->get();

		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Get Active Events by League
	//-----------------------------------------------
	public function get_upcoming_events_by_league($league_id)
	{
		$this->db->select('leagues.league_id,events.league_id,home_team,away_team,match_date,match_time,match_id')
			->from('events')
			->join('leagues', 'leagues.league_id = events.league_id', 'left')
			->where('events.match_date >',date('Y-m-d'))
			//->where('match_time >',date('H:i'))
			->where('events.league_id', $league_id)
			->order_by('match_date','asc')
			->order_by('match_time','asc');

		$query = $this->db->get();

		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}
	//-----------------------------------------------	
	//   Get Upcoming Events by Team
	//-----------------------------------------------
	public function get_upcoming_events_by_team($team,$league_id,$date)
	{
		$this->db->select('events.sport_id,leagues.league_id,events.league_id,home_team,away_team,match_date,match_time,match_id')
			->from('events')
			->join('leagues', 'leagues.league_id = events.league_id', 'left')
			->where('events.match_date !=',$date)
			->where('events.match_date >', date('Y-m-d'))
			->where('home_team',$team)
			->or_where('away_team',$team)
			->where('events.league_id', $league_id)
			->where('events.match_date !=',$date)
			->where('events.match_date >', date('Y-m-d'))
			->order_by('match_date','asc')
			->order_by('match_time','asc');

		$query = $this->db->get();

		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;
	}	
/////////////////////////////////////////////////////////////
	public function delete_old_events()
	{	
		$this->db->where('match_date <', date('Y-m-d'));
		$this->db->delete('events');
	}
/////////////////////////////////////////////////////////////	
	public function delete_old_bets()
	{	
		$this->db->where('match_date <', date('Y-m-d'));
		$this->db->delete('bets');
	}
/////////////////////////////////////////////////////////////
	public function get_last_update()
	{
		$query = $this->db->get('last_update');
	
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->time;
		}
	}	
/////////////////////////////////////////////////////////////	
	public function set_update()
	{
		$this->db->set('time', date('Y-m-d H:i:s'));
		$query = $this->db->insert('last_update');

	}
/////////////////////////////////////////////////////////////	
	public function delete_update()
	{
		$this->db->where('time <', date('Y-m-d H:i:s'));
		$this->db->delete('last_update');

	}
/////////////////////////////////////////////////////////////	
	public function update_results()
	{
		
		$this->db->select('sport_id ,league_id,match_id,home_team,away_team,match_date,match_time');
		$query = $this->db->get('events');
		
		foreach ($query->result() as $row) {
		
			$q = $this->db->get_where('results', array('match_id' => $row->match_id));
				if($q->num_rows()>0) {}
					
				else
				{
					$this->db->insert('results',$row);
				}	
		}
		

	}		
/////////////////////////////////////////////////////////////
//               UPDATE LEAGUES
/////////////////////////////////////////////////////////////	
	public function update_leagues()
	{
		$this->load->model('sports/sports_model');

		$active_sports =  $this->sports_model->get_active_sports();
		
		$xml = simplexml_load_file('fxml/download.xml') or die("Error: Cannot create object");

		foreach ($xml as $sport) 
		{
			$sport_name = str_replace(' ','_',$sport->attributes()->name);
			$sport_id = $sport->attributes()->id;
		
			if(in_array($sport_id,$active_sports))
			{
				foreach ($sport as $event)  
				{
			

					$league_name = $event->attributes()->name;
					$league_id = $event->attributes()->id;


					//  LEAGUES DATA
					$leagues_data = array(
					'sport_name' => str_replace(' ','_',$sport_name),
					'sport_id' => $sport_id,
					'league_id' => $league_id,
					'league_name' => $league_name
					);

					// Check if the LEAGUE exist in DB, If Not insert it
					
					$q = $this->db->get_where('leagues', array('league_id' =>$league_id));
					
					if($q->num_rows()>0) {}
					
					else
					{														
						$this->db->trans_start();
						$this->db->unique_checks=0;
						$sql = $this->db->insert('leagues', $leagues_data);
						mysqli_multi_query($this->db->conn_id, $sql);
						$this->db->unique_checks=1;
						$this->db->trans_complete();
					}

					//  .LEAGUES DATA
				}
			}
		}
	}	
/////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//               UPDATE BETS
/////////////////////////////////////////////////////////////	

	public function update_bets()
	{
		$this->load->model('sports/sports_model');
		$active_sports =  $this->sports_model->get_active_sports();
		$selected_bets =  array('Outright Winner','Handicap','Total Goals','Total Points','Total Sets',
								'Corect Score','Over/Under','Double Chance','Match Winner','Match Result',
								'Match Result 2','Half Time/Full Time','First Team To Score','Time of First Goal','Sets Handicap',
								'Qualifying Winner','Winner','Head-to-Head Qualifying','Head-to-Head'
								);
		$xml = simplexml_load_file('fxml/download.xml') or die("Error: Cannot create object");

		foreach ($xml as $sport) 
		{
			$sport_name = str_replace(' ','_',$sport->attributes()->name);
			$sport_id = $sport->attributes()->id;
			
			if(in_array($sport_id,$active_sports))
			{
				foreach ($sport as $event)  
				{

					$league_id = $event->attributes()->id;

					foreach ($event as $match) 
					{
						
						$match_name = $match->attributes()->name;
						$match_id = $match->attributes()->id;
						$match_start_date_str = str_replace('T', ' ', $match->attributes()->start_date);
						$match_start_date = strtotime($match_start_date_str);
						
						$match_date = date('Y-m-d',strtotime($match_start_date_str));
						$match_time = date('H:i',strtotime($match_start_date_str));

						$timezone = $this->config->item('site.default_timezone');
						// Instantiate the DateTime object, setting it's date, time and time zone.
						$datetime = new DateTime($match_time);
						// Set the DateTime object's time zone to convert the time appropriately.
						$target_timezone = new DateTimeZone($timezone);
						$datetime->setTimeZone($target_timezone);
						// Outputs a date/time string based on the time zone you've set on the object.
						$match_time = $datetime->format('H:i');
						

						foreach ($match as $bets) 
						{
							foreach ($bets as $bet) 
							{
							
								$bet_name = $bet->attributes()->name;
								$bet_id = $bet->attributes()->id;
								
								if(in_array($bet_name,$selected_bets))
								{
								
									$away = substr($match_name, strpos($match_name, " - ") +2); 
								
									$str = explode(" - ", $match_name, 2);
									$home = $str[0];
							
									foreach ($bet as $choice) 
									{
									
										// team numbers are surrounded by %, we strip them
										$choice_name = str_replace(array('%1%','%2%'), array($home,$away), $choice->attributes()->name);
										$choice_id = $choice->attributes()->id;
										// get the float value of odss
										$odd = (float)$choice->attributes()->odd;

										//  BETS DATA
										$bets_data = array(
										'bet_id' => $bet_id,
										'bet_name' => $bet_name,
										'choice_id' => $choice_id,
										'choice_name' => trim($choice_name),
										'odd' => $odd,
										'league_id' => $league_id,
										'match_id' => $match_id,
										'match_date' => $match_date
										);

										// Check if the Bet exist in DB, If Not insert it
										
										$this->db->select('choice_name')
										->where('match_id',$match_id)
										->where('bet_name' , $bet_name)
										->where('choice_name' , $choice_name);
										
										$q = $this->db->get('bets');
										if($q->num_rows()>0)
										{
										}
										else
										{
											$this->db->trans_start();
											$this->db->unique_checks=0;
											$sql = $this->db->insert('bets', $bets_data);
											mysqli_multi_query($this->db->conn_id, $sql);
											$this->db->unique_checks=1;
											$this->db->trans_complete();
										}
										// .BETS DATA
									} // .Choice
								} // .Selected Bets
							} // .Bet					
						} // .Bets
					} // .Match
				} // .Selected Sports
			} //.Events
		} // .Sports
	}	

/////////////////////////////////////////////////////////////
//               UPDATE EVENTS
/////////////////////////////////////////////////////////////		

	public function update_events()
	{
		$this->load->model('sports/sports_model');
		$active_sports =  $this->sports_model->get_active_sports();
		
		$xml = simplexml_load_file('fxml/download.xml') or die("Error: Cannot create object");

		foreach ($xml as $sport) 
		{
			$sport_name = str_replace(' ','_',$sport->attributes()->name);
			$sport_id = $sport->attributes()->id;
			
			if(in_array($sport_id,$active_sports))
			{
				foreach ($sport as $event)  
				{

					$league_name = $event->attributes()->name;
					$league_id = $event->attributes()->id;

					foreach ($event as $match) 
					{

					
						$match_name = $match->attributes()->name;
						$match_id = $match->attributes()->id;
						$match_start_date_str = str_replace('T', ' ', $match->attributes()->start_date);
						$match_start_date = strtotime($match_start_date_str);
						
						$match_date = date('Y-m-d',strtotime($match_start_date_str));
						$match_time = date('H:i',strtotime($match_start_date_str));

						$timezone = $this->config->item('site.default_timezone');
						// Instantiate the DateTime object, setting it's date, time and time zone.
						$datetime = new DateTime($match_time);
						// Set the DateTime object's time zone to convert the time appropriately.
						$target_timezone = new DateTimeZone($timezone);
						$datetime->setTimeZone($target_timezone);
						// Outputs a date/time string based on the time zone you've set on the object.
						$match_time = $datetime->format('H:i');

						if(strpos($match_name, " - "))
						{
							$away = substr($match_name, strpos($match_name, " - ") +2); 
						
							$str = explode(" - ", $match_name, 2);
							$home = $str[0];

							//  EVENTS DATA
							$events_data = array(
							'sport_id' => $sport_id,
							'league_id' => $league_id,
							'match_id' => $match_id,
							'home_team' => trim($home),
							'away_team' => trim($away),
							'match_date' => $match_date,
							'match_time' => $match_time
							);

							// Check if the Event exist in DB, If Not insert it

							$q = $this->db->get_where('events',array('match_id' => $match_id));
							if($q->num_rows()>0)
							{
							}
							else
							{
								$this->db->trans_start();
								$this->db->unique_checks=0;
								$sql = $this->db->insert('events', $events_data);
								mysqli_multi_query($this->db->conn_id, $sql);
								$this->db->unique_checks=1;
								$this->db->trans_complete();
								
							} //  .EVENTS DATA	
						}
					
					}
				}	
			}
		}
	}
	
/////////////////////////////////////////////////////////////////////////	
}