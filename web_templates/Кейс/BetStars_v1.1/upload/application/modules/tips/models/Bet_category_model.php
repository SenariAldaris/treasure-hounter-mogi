<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Bet Category Model
 *
 * This class handles bet categories
 *
 * @package		Bet Category
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Bet_category_model extends MY_Model
{
	/** @var string Name of the bet_category table. */
    protected $table_name	= 'bets';	
	protected $key			= 'id';
	protected $date_format	= 'datetime';

	protected $log_user 	= false;
	protected $set_created	= false;
	protected $set_modified = false;
	protected $soft_deletes	= false;

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
	//   Get Bet Name
	//-----------------------------------------------
	
	public function get_bet_name_by_id($id)
	{
		$query = $this->db->get_where('bets',array('bet_id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->bet_name;
		}
		else
			return '';
	}
	//-----------------------------------------------	
	//   Get Choice Name
	//-----------------------------------------------
	
	public function get_choice_name_by_id($id)
	{
		$query = $this->db->get_where('bets',array('choice_id'=>$id));


		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->choice_name;
		}
		else
			return '';
	}
	//-----------------------------------------------
	//			Get Bet Types By Event
	//-----------------------------------------------
	public function get_bets_by_match_id($id)
	{
        $this->db->select('bet_name,bet_id');
		$query = $this->db->get_where('bets',array('match_id'=>$id));
		
        $bet_types = array();
		
     if($query->result()){
            foreach ($query->result() as $bet_type) {
                $bet_types[$bet_type->bet_id] = $bet_type->bet_name;
            }
            return $bet_types;
        } else 
		{
            return FALSE;
        }
    } 		
	
	//-----------------------------------------------
	//			 Get Bets By Type
	//-----------------------------------------------
	public function get_bet_choice_by_bet_id($bet_id,$match_id)
	{
		$this->db->select('choice_name,choice_id,odd')
				 ->where('match_id' ,$match_id)
				 ->where('bet_id' ,$bet_id);
		$query = $this->db->get('bets');
		
        $bet_choices = array();
		
     if($query->result()){
            foreach ($query->result() as $bet_choice) {
                $bet_choices[$bet_choice->choice_id] = $bet_choice->choice_name . '   / odds -' . $bet_choice->odd;
            }
            return $bet_choices;
        } else 
		{
            return FALSE;
        }
    } 
	//-----------------------------------------------
	//			 Get Odds
	//-----------------------------------------------

    public function get_match_odds($bet, $choice_id, $match_id)
    {


        $this->db->select('odd')
		->where('bet_id',$bet)
		->where('choice_id',$choice_id)
		->where('match_id',$match_id);
		
		$query = $this->db->get('bets');
		
        $match_odds = array();
		
     if($query->result()){
            foreach ($query->result() as $match_odd) {
                $match_odds[$match_odd->odd] = $match_odd->odd;				
            }

		return $match_odds;

        } else 
		{
            return FALSE;
        }
	}		
//-----------------------------------------------		
}