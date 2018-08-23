<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Leagues Model
 *
 * This class handles leagues
 *
 * @package		Leagues
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Leagues_model extends MY_Model
{
	/** @var string Name of the leagues table. */
    protected $table_name	= 'leagues';
	
	protected $key			= 'id';
	protected $date_format	= 'datetime';

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
			'field' => 'league_name',
			'label' => 'lang:leagues_name',
			'rules' => 'max_length[255]',
		),	
		array(
			'field' => 'sport_id',
			'label' => 'lang:leagues_sport',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'country_id',
			'label' => 'lang:leagues_country',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'active',
			'label' => 'lang:leagues_active',
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


	/*----------------------------------------------------*/
    /* Admin only Activation function.
     * @param int $league_id The league ID to activate.
     * @return boolean True on success, false on error.
	/*----------------------------------------------------*/
	
   public function league_activation($league_id = false)
    {
        if ($league_id === false) {
            $this->error = lang('leagues_err_no_id');
            return false;
        }

        if ($this->activate($league_id, 'id', false)) {
            return $league_id;
			
        }

            $this->error = lang('leagues_err_league_is_active');
        return false;
    }
	
	/*----------------------------------------------------*/
    /* Admin only Deactivation function.
     * @param int $league_id The league ID to deactivate.
     * @return boolean True on success, false on error.
	/*----------------------------------------------------*/

    public function league_deactivation($league_id = false)
    {
        if ($league_id === false) {
            $this->error = lang('us_err_no_id');
            return false;
        }

        if ($this->deactivate($league_id, 'id', false)) {
            return $league_id;
        }

            $this->error = lang('leagues_err_league_is_inactive');
        return false;
    }	

	/*----------------------------------------------------*/
	/*-------       Dectivate League    ------------------*/
	/*----------------------------------------------------*/	
	
	public function deactivate($leagueId)
    {

        $this->db->update(
            $this->table_name,
            array('active' => 0),
            array('id' => $leagueId)
        );

        if ($this->db->affected_rows() != 1) {
            return false;
        }

        return true;
    }	
	
	/*----------------------------------------------------*/
	/*----------------------------------------------------*/	
	public function activate($leagueId = false)
    {
        $this->db->update(
            $this->table_name,
            array('active' => 1),
            array('id' => $leagueId)
        );

        if ($this->db->affected_rows() != 1) {
            return false;
        }

        return true;
    }
	
	/*--------------------------------------------------*/
	/*-------        Get league name from id    --------*/
	/*--------------------------------------------------*/
	
	function get_live_leagues()
	{
        $this->db->select('leagues.league_id, leagues.league_name, leagues.sport_id')
		->join('events', 'events.league_id  = leagues.league_id', 'left')
		->order_by('sport_id', 'asc')
		->order_by('league_id', 'asc')
		->order_by('match_time', 'asc')
		->order_by('match_date', 'asc');
		$query = $this->db->get_where('leagues',array('match_date >'=> date('Y-m-d'),'match_time >'=> date('H:i')));
		return $query->result();
	}

	/*--------------------------------------------------*/
	/*-------        Get league name from id    --------*/
	/*--------------------------------------------------*/	
	
		function get_league_name_by_id($id)
		{
			$query = $this->db->get_where('leagues',array('league_id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->league_name;
			}
			else
				return '';
		}

	/*--------------------------------------------------*/
	/*-------        Get country from id           -----*/
	/*--------------------------------------------------*/	
	
		function get_league_country_by_id($id)
		{
			$query = $this->db->get_where('leagues',array('league_id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->country_id;
			}
			else
				return '';
		}
	/*--------------------------------------------------*/
	/*-------        Get Sport from id             -----*/
	/*--------------------------------------------------*/	
	
		function get_league_sport_id_by_id($id)
		{
			$query = $this->db->get_where('leagues',array('league_id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->sport_id;
			}
			else
				return '';
		}
				
	/*--------------------------------------------------*/
	/*-------        Get Leagues By Sport          -----*/
	/*--------------------------------------------------*/	

	public function get_leagues_by_sport_id($id)
	{
        $this->db->select('leagues.league_id, leagues.league_name, leagues.sport_id');
		$this->db->join('events', 'events.league_id  = leagues.league_id', 'left');
		$query = $this->db->get_where('leagues',array('leagues.sport_id'=>$id,'match_date >='=> date('Y-m-d'),'match_time >'=> date('H:i')));
		
        $leagues = array();
		
		if($query->result())
		{
            foreach ($query->result() as $league) {
                $leagues[$league->league_id] = $league->league_name;
            }
            return $leagues;
        } 
		else 
		{
            return FALSE;
        }
    } 		
	/*--------------------------------------------------*/
	/*-------        Count League Tips             -----*/
	/*--------------------------------------------------*/	
	
	function count_league_tips($id)
	{
		$this->db->select('tips.league_id , count(1) as count')
			->from('tips')
			->where('status', 2)
			->where('league_id', $id)
			->order_by('count', 'desc')
			->group_by('tips.league_id');

		$query = $this->db->get();
		
		if ($query->num_rows())
		{
			$row = $query->row();
				return $row->count;
		}

		return FALSE;
	}
	/*--------------------------------------------------*/
	/*-------        Get All Leagues By Sport          -----*/
	/*--------------------------------------------------*/	

	public function get_all_leagues_by_sport_id($id)
	{
        $this->db->select('league_id, league_name, sport_id');
		$query = $this->db->get_where('leagues',array('sport_id'=>$id));
		
        $leagues = array();
		
		if($query->result())
		{
            foreach ($query->result() as $league) {
                $leagues[$league->league_id] = $league->league_name;
            }
            return $leagues;
        } 
		else 
		{
            return FALSE;
        }
    } 		
}