<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Bookmakers Model
 *
 * This class handles bookmakers
 *
 * @package		Bookmakers
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Bookmakers_model extends MY_Model
{
	/** @var string Name of the bookmakers table. */
    protected $table_name	= 'bookmakers';
	
	/** @var string Name of the bookmaker_reviews table. */
	protected $reviews_table = 'bookmaker_reviews';
	
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
			'label' => 'lang:bookmakers_name',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'logo',
			'label' => 'lang:bookmakers_logo',
			'rules' => 'required|max_length[30]',
		),		
		array(
			'field' => 'url',
			'label' => 'lang:bookmakers_url',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'review',
			'label' => 'lang:bookmakers_review',
			'rules' => '',
		),
		array(
			'field' => 'bonus_code',
			'label' => 'lang:bookmakers_bonus_code',
			'rules' => 'max_length[30]',
		),
		array(
			'field' => 'bonus_offer',
			'label' => 'lang:bookmakers_bonus_offer',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'description',
			'label' => 'lang:bookmakers_bonus_offer',
			'rules' => 'max_length[255]',
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
	/*----------------------------------------------------*/	
		
	public function get_all_bookmakers()
	{
		$this->db->select();
		$this->db->select_avg('rating',' rating')
			->from($this->table_name)
			->join($this->reviews_table, $this->reviews_table . '.bookmaker_id = ' . $this->table_name . '.id', 'left');
		$this->db->group_by($this->table_name .'.id');
		$this->db->order_by('rating', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	/*----------------------------------------------------*/
	/*----------------------------------------------------*/	
	public function get_bookmakers()
	{

		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('bookmakers');
		return $query;
	}
	/*----------------------------------------------------*/
	/*----------------------------------------------------*/	
	
	public function get_bookmaker_by_id($id)
	{
		$this->db->select('id, name, logo, review');
		$query = $this->db->get_where('bookmakers',array('id'=>$id));
		return $query;
	}
	/*--------------------------------------------------*/
	/*-------        Get league name from id    --------*/
	/*--------------------------------------------------*/	
	
		function get_bookmaker_name_by_id($id='')
		{
			$query = $this->db->get_where('bookmakers',array('id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->name;
			}
			else
				return '';
		}

	////////////////  Get bookmaker logo from id    /////////

		function get_bookmaker_logo_by_id($id='')
		{
			$query = $this->db->get_where('bookmakers',array('id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->logo;
			}
			else
				return '';
		}		
		
	public function get_bookmakers_select ()
	{
		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('bookmakers');
		
	 
		$bookmakers = array();
	 
		if ($query->result()) 
		{
		  foreach ($query->result() as $bookmaker) 
		  {
			$bookmakers[$bookmaker->id] = $bookmaker->name;
		  } 
		  return $bookmakers;
		} 
		else 
		{
		  return FALSE;
		}

    }  
	//////////////////////////////////////////////////////////////////
	
	public function get_bookmaker_banner_sidebar()
	{
		$this->db->select('id,banner,banner_url,banner_type')
				->where('banner_type',1)
				->order_by('id','RANDOM')
				->limit(1);
		$query = $this->db->get('bookmakers');
		
		if($query->num_rows()>0)
		{

			foreach ($query->result() as $record) 
			{
		
				echo '<a target="_blank" href="'.$record->banner_url .'"><img class="img-responsive" src="' .base_url() .'uploads/bookmakers/'. $record->banner . '"></a>';
				
			}	
		}
		else 
		{
		  return FALSE;
		}

	}		

	//////////////////////////////////////////////////////////////////
	
	public function get_bookmaker_banner_full()
	{
		$this->db->select('id,banner,banner_url,banner_type')
				->where('banner_type',2)
				->order_by('id','RANDOM')
				->limit(1);
		$query = $this->db->get('bookmakers');
		
		if($query->num_rows()>0)
		{

			foreach ($query->result() as $record) 
			{
		
				echo '<a target="_blank" href="'.$record->banner_url .'"><img class="img-responsive" src="' .base_url() .'uploads/bookmakers/'. $record->banner . '"></a>';
				
			}	
		}
		else 
		{
		  return FALSE;
		}

	}		

	//////////////////////////////////////////////////////////////////
}