<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Rewards Model
 *
 * This class handles rewards
 *
 * @package		Rewards
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Rewards_model extends MY_Model
{
	/** @var string Name of the competition_rewards table. */
    protected $table_name	= 'competition_rewards';
	
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
			'field' => 'competition_id',
			'label' => 'lang:rewards_field_competition_id',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'place',
			'label' => 'lang:rewards_field_place',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'reward',
			'label' => 'lang:rewards_field_reward',
			'rules' => 'required|max_length[11]',
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
	//   Get Rewards
	//-----------------------------------------------
		
	public function get_competitions()
	{
		$this->db->order_by('reward', 'asc');
		$query = $this->db->get('competition_rewards');
		return $query;
	}
	
	//-----------------------------------------------	
	//   Get Rewards Selects
	//-----------------------------------------------
	
	public function get_competitions_select ()
	{
		$this->db->order_by('reward', 'desc');
		$this->db->group_by('competition_id', 'asc');
		$query = $this->db->get('competition_rewards');
		
	 
		$rewards = array();
	 
		if ($query-> result()) 
		{
		  foreach ($query->result() as $reward) 
		  {
			$rewards[$reward->place] = $reward->reward;
		  } 
		  return $rewards;
		} 
		else 
		{
		  return FALSE;
		}

    }  	
	
	
}