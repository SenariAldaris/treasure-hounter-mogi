<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Sports Model
 *
 * This class handles sports
 *
 * @package		Sports
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Sports_model extends MY_Model
{
	/** @var string Name of the sports table. */
    protected $table_name	= 'sports';
	
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
			'field' => 'name',
			'label' => 'lang:sports_name',
			'rules' => 'required|unique[sports.name,sports.id]|max_length[50]',
		),
		array(
			'field' => 'icon',
			'label' => 'lang:sports_icon',
			'rules' => 'required[sports.icon,sports.id]|max_length[30]',
		),
		array(
			'field' => 'active',
			'label' => 'lang:sports_active',
			'rules' => 'max_length[10]',
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

	/*----------------------------------------------------
				   Get All Active Sports
	----------------------------------------------------*/		
	function get_sports()
	{
		$this->db->select('id, name,icon,active');
		$this->db->where('active', 1);
		$this->db->order_by('display_order', 'asc');
		$query = $this->db->get('sports');
		return $query;
	}

	function get_tips_sports()
	{
		$this->db->select('sports.id, name,icon,sports.active');
		$this->db->from('sports');
		$this->db->join('events', 'events.sport_id  = sports.id', 'left');
		$this->db->where('sports.active', 1);
		$this->db->where('match_date >=',date('Y-m-d'));
		$this->db->where('match_time >', date('H:i'));
		$this->db->group_by('sports.id');
		$this->db->order_by('display_order', 'asc');
		$query = $this->db->get();
		return $query;
	}	
	
	
	/*----------------------------------------------------
				   Get sport name from id
	----------------------------------------------------*/	
		
		function get_sport_name_by_id($id='')
		{
			$query = $this->db->get_where('sports',array('id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->name;
			}
			else
				return '';
		}
		
	/*----------------------------------------------------
				   Get sport icon from id
	----------------------------------------------------*/	
		
		function get_sport_icon_by_id($id='')
		{
			$query = $this->db->get_where('sports',array('id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->icon;
			}
			else
				return '';
		}
		function get_sport_icon_by_name($sport)
		{
			$query = $this->db->get_where('sports',array('name'=>$sport));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->icon;
			}
			else
				return '';
		}

	/*----------------------------------------------------
	----------------------------------------------------*/		
	function get_active_sports()
	{
		$this->db->select('id');
		$this->db->where('active', 1);
		$query = $this->db->get('sports');
		$array = array();

		foreach($query->result() as $row)
		{
			$array[] = $row->id; 
		}

		return $array;
	}	
}