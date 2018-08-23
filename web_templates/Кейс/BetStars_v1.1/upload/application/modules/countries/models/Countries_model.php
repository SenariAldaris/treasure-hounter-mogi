<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Countries Model
 *
 * This class handles countries
 *
 * @package		Countries
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Countries_model extends MY_Model
{
	/** @var string Name of the countries table. */
    protected $table_name	= 'countries';
	
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
			'label' => 'lang:countries_name',
			'rules' => 'required|max_length[200]',
		),
		array(
			'field' => 'iso_alpha2',
			'label' => 'lang:countries_iso_alpha2',
			'rules' => 'required|max_length[2]',
		),
		array(
			'field' => 'iso_alpha3',
			'label' => 'lang:countries_iso_alpha3',
			'rules' => 'required|max_length[3]',
		),
		array(
			'field' => 'iso_numeric',
			'label' => 'lang:countries_iso_numeric',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'currency_code',
			'label' => 'lang:countries_currency_code',
			'rules' => 'max_length[3]',
		),
		array(
			'field' => 'currency_name',
			'label' => 'lang:countries_currency_name',
			'rules' => 'max_length[32]',
		),
		array(
			'field' => 'currrency_symbol',
			'label' => 'lang:countries_currrency_symbol',
			'rules' => 'max_length[3]',
		),
		array(
			'field' => 'flag',
			'label' => 'lang:countries_flag',
			'rules' => 'required|max_length[6]',
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
	function get_countries()
	{

		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('countries');
		return $query;
	}
	
	/*----------------------------------------------------*/	
	
	
	public function get_countries_select ()
	{
		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('countries');
		
	 
		$countries_select = array();
	 
		if ($query-> result()) 
		{
		  foreach ($query->result() as $country) 
		  {
			$countries_select[$country->id] = $country->name;
		  } 
		  return $countries_select;
		} 
		else 
		{
		  return FALSE;
		}

    }  	  
  
	/*----------------------------------------------------
				   Get country name from id
	----------------------------------------------------*/	
		
	function get_country_name_by_id($id='')
	{
		$query = $this->db->get_where('countries',array('id'=>$id));
		
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->name;
		}
		else
			return '';
	}

	/*----------------------------------------------------*/

	function get_country_flag_by_id($id='')
	{
		$query = $this->db->get_where('countries',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->flag;
		}
		else
			return '';
	}

	function get_country_flag_by_name($name)
	{
		$this->db->where_in('name',$name);
		$query = $this->db->get('countries');
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->flag;
		}
		else
			return '';
	}

	
}
