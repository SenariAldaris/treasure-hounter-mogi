<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Bookmaker Reviews Model
 *
 * This class handles bookmaker reviews
 *
 * @package		Bookmaker Reviews
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Bookmaker_reviews_model extends MY_Model
{
	/** @var string Name of the bookmaker_reviews table. */
    protected $table_name	= 'bookmaker_reviews';
	
	protected $key			= 'review_id';
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
			'field' => 'user_id',
			'label' => 'lang:bookmaker_reviews_user_id',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'rating',
			'label' => 'lang:bookmaker_reviews_rating',
			'rules' => 'required|max_length[3]',
		),		
		array(
			'field' => 'date_posted',
			'label' => 'lang:bookmaker_reviews_date_posted',
			'rules' => 'required|max_length[20]',
		),
		array(
			'field' => 'description',
			'label' => 'lang:bookmaker_reviews_description',
			'rules' => 'max_length[1000]',
		),		
		array(
			'field' => 'bookmaker_id',
			'label' => 'lang:bookmaker_reviews_bookmaker_id',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'status',
			'label' => 'lang:bookmaker_reviews_status',
			'rules' => 'max_length[3]',
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

	///////////////////////////////////////////////////////////////////////////

	function all_reviews_by_bookmakers()
	{
        $this->db->where('status', '0');
        $this->db->groupby('bookmaker_id');
        $query = $this->db->get('bookmaker_reviews');
        return $query;
    }
	
	////////////////////   Get number of reviews  //////////////////////
	
	function allReviews($no)
	{
        $this->db->where('status', '0');
        $this->db->orderby('date_posted','desc');
        $query = $this->db->get('bookmaker_reviews',$no);
        return $query;
    }	
	
	/////////////////////   Vote on review  ////////////////////////
	
    function vote($bookmaker_id, $review_id, $user_id,$score)
	{
	   $query = $this->user_votes($review_id,$user_id);
	   if ($query->num_rows() > 0)
	   {
		 return "";
	   }
	   else
	   {
		 $data = array(
		  'review_id' => $review_id,
				'user_id' => $user_id,
				'score' => $score
			  );
		 $this->db->insert('reviews_log', $data);
	   }
	}
		
	////////////////////   Get user votes   ////////////////////////
	
    function user_votes($review_id,$user_id) // random
	{
		$this->db->where('review_id', $review_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('reviews_log');
		return $query;
    }
	
	/////////////////   Get votes  ///////////////////////////////
	
    function vote_sum($review_id) // random
	{
		$this->db->where('review_id', $review_id);
		$query = $this->db->get('reviews_log');
		$total = 0;
		foreach ($query->result() as $row)
		{
		$total +=$row->score;
		}
        return $total;
    }	
	
	///////////////////  Get user reviews   ///////////////////////	
	
	function user_Reviews($user_id,$bookmaker_id)
	{
          $this->db->where('bookmaker_id', $bookmaker_id);
          $this->db->where('user_id', $user_id);
          $query = $this->db->get('bookmaker_reviews');
          return $query;
    }
	
	/////////////  Get bookmaker reviews   ///////////////////////
	
	function bookmaker_Reviews($bookmaker_id)
	{
          $this->db->where('status', 1);
          $this->db->where('bookmaker_id', $bookmaker_id);
          $query = $this->db->get('bookmaker_reviews');
          return $query->result();
    }		
	
	//////////////////// Pending reviews   ////////////////////////
	
	function pending_Reviews()
	{
        $this->db->order_by('status', 0);
        $query = $this->db->get('bookmaker_reviews');
        return $query;
    } 
		
	//////////////// Get bookmaker nunber of reviews ///////////////////
	
	function noReviews($bookmaker_id)
    {
		$this->db->where('status', 1);
        $this->db->where('bookmaker_id', $bookmaker_id);
        $query = $this->db->get('bookmaker_reviews');
		return $query->num_rows();

    }

	////////////////  Add bookmaker review /////////////////////////////	
	
	function addReview($data)
	{
		$this->db->insert('bookmaker_reviews', $data);
		if ($this->db->affected_rows() == '1')
		{
			$review_id = mysql_insert_id();
			return $review_id;
		}
		return FALSE;
	}
	
	///////////////// Update bookmaker review  ///////////////////////////
	
	function UpdtReview($update,$review_id)
	{
        $this->db->where('review_id', $review_id);
        $this->db->update('bookmaker_reviews', $update);

    }
	///////////////// Delete bookmaker reviews  ///////////////////////////
	
	function DeleteReviews()
	{
        $this->db->where('status', 2);
        $this->db->delete('bookmaker_reviews');

    }	
	///////////////////////////////////////////////////////////////////////////	
	// deprecated use bellow
	
    function rating($bookmaker_id)
    {
		$this->db->where('status', 1);
        $this->db->where('bookmaker_id', $bookmaker_id);
        $query = $this->db->get('bookmaker_reviews');
		$total = '0';
		$no_of = $query->num_rows();
		if($no_of > 0)
		{
			foreach ($query->result() as $row)
			{
			$total += $row->rating;
			} 
			$rating = number_format(($total/$no_of),1);
		}
		else
		{
			$rating = 0;
		}
		return $rating;
    }
	
	////////////// Get bookmaker rating ////////////////////////////
	
    public function get_rating($bookmaker_id)
    {


       $this->db-> select_avg('rating','rating');
       $this->db->where('bookmaker_id', $bookmaker_id);

       $query = $this->db->get('bookmaker_reviews');
	   
          foreach ($query->result() as $row)
          {
           $rating = $row->rating;
          }
		  
          return $rating;
    }


	//////////////////////////////////////////////////////////////////
}