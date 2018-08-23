<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Competitions Front Controller
 *
 * This class handles competitions on the front page
 *
 * @package		Competitions
 * @subpackage	Competitions
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Competitions extends Front_Controller
{
    protected $permissionCreate = 'Competitions.Create';
    protected $permissionDelete = 'Competitions.Delete';
    protected $permissionEdit   = 'Competitions.Edit';
    protected $permissionView   = 'Competitions.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('competitions/competitions_model');
		$this->load->model('sports/sports_model');
		$this->load->model('leagues/leagues_model');
		$this->load->model('bookmakers/bookmakers_model');
		$this->load->model('countries/countries_model');
		$this->load->model('tipsters/tipsters_model');
		$this->load->model('tips/tips_model');		
		
		$language = $this->input->cookie('language');
		$this->lang->load('competitions',$language);		
		$this->lang->load('tips/tips',$language);	
		Template::set('statuses', $this->tips_model->get_tips_statuses());	
		Template::set('status_counts', $this->tips_model->count_by_status()); 
		Template::set('sport_counts', $this->tips_model->limit(10)->count_by_sport());
		Template::set('league_counts', $this->tips_model->limit(10)->count_by_league());			
		
    }

    /**
     * Display a list of Competitions data.
     *
     * @return void
     */
    public function index()
    {

        $active = $this->competitions_model->where('active',1)->find_all();
		$inactive = $this->competitions_model->where('active',0)->find_all();
        Template::set('active', $active);  
		Template::set('inactive', $inactive);		
        Template::set_block('sidebar_left','competitions/sidebar_left');
        Template::render('two_col_left');
    }
	
	
    public function view($id)
    {
	    $records = $this->competitions_model->get_competition_by_id($id);
        Template::set('records', $records); 
        Template::set_block('sidebar_left','competitions/view/sidebar_left');
        Template::render('two_col_left');
    }    
}