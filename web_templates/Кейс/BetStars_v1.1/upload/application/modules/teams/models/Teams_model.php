<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Teams Model
 *
 * This class handles teams
 *
 * @package		Teams
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Teams_model extends MY_Model
{
	/** @var string Name of the teams table. */
    protected $table_name	= 'teams';
	
	protected $key			= 'team_id';
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
			'field' => 'name',
			'label' => 'lang:teams_name',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'logo',
			'label' => 'lang:teams_logo',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'league_id',
			'label' => 'lang:teams_league',
			'rules' => 'required|max_length[10]',
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
	function get_teams()
	{
		$this->db->select('team_id, name, logo,sport_id');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('teams');
		return $query;
	}

	/*--------------------------------------------------*/
	/*-------        Get team name by id        --------*/
	/*--------------------------------------------------*/	
	
		function get_team_name_by_id($id='')
		{
			$query = $this->db->get_where('teams',array('id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->name;
			}
			else
				return '';
		}	
	
	/*--------------------------------------------------*/
	/*-------    Get team logo by id               -----*/
	/*--------------------------------------------------*/	
		
		function get_team_logo_by_id($id)
		{
			$query = $this->db->get_where('teams',array('id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->logo;
			}
			else
				return '';

		}	
	/*--------------------------------------------------*/
	/*-------    Get team logo by name             -----*/
	/*--------------------------------------------------*/	
		
		function get_team_logo_by_name($name,$league_id)
		{
			$query = $this->db->get_where('teams',array('name'=>$name,'league_id'=>$league_id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->logo;
			}
			else
				return '';

		}	
	
	/*--------------------------------------------------*/
	/*-------        Get Teams by League id        -----*/
	/*--------------------------------------------------*/	
		
	function get_teams_by_league_id($id)
	{
        $this->db->where('leagues',$id);
		$query = $this->db->get('teams');		
		return $query;
	}		
	/*--------------------------------------------------*/
	/*-------        Get Team  League id           -----*/
	/*--------------------------------------------------*/	
		
	function get_team_league_id($id)
	{
        $query = $this->db->get_where('teams',array('team_id'=>$id));
		if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->league_id;
			}
			else
				return '';
	}			
}