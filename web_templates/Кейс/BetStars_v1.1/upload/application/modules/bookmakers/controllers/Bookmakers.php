<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Bookmakers Front Controller
 *
 * This class handles bookmakers on the front page
 *
 * @package		Bookmakers
 * @subpackage	Bookmakers
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Bookmakers extends Front_Controller
{
    protected $permissionCreate = 'Bookmakers.Create';
    protected $permissionDelete = 'Bookmakers.Delete';
    protected $permissionEdit   = 'Bookmakers.Edit';
    protected $permissionView   = 'Bookmakers.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('bookmakers_model');
		$this->load->model('bookmaker_reviews/bookmaker_reviews_model');
		$this->load->model('tips/tips_model');
		$this->load->model('sports/sports_model');
		$this->load->model('leagues/leagues_model');
		$this->load->model('countries/countries_model');
		$this->load->model('tipsters/tipsters_model');
		
		$language = $this->input->cookie('language');
		$this->lang->load('bookmakers',$language);	
		$this->lang->load('tips/tips',$language);			
		
		$this->load->library('form_validation');
		$this->load->helper('date');
		$this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
		Template::set('statuses', $this->tips_model->get_tips_statuses());	
		Template::set('status_counts', $this->tips_model->count_by_status()); 
		Template::set('sport_counts', $this->tips_model->limit(10)->count_by_sport());
		Template::set('league_counts', $this->tips_model->limit(10)->count_by_league());	
		
        $this->set_current_user();

    }

    /**
     * Display a list of Bookmakers data.
     *
     * @return void
     */
    public function index()
    {
        $records = $this->bookmakers_model->get_all_bookmakers();
        Template::set('records', $records);
		Template::set_block('sidebar_left','tips/sidebar_left');
        Template::render('two_col_left3');
    }
	
    public function view()
    {

		$bookmaker_id = $this->uri->segment(3);
        $records = $this->bookmakers_model->get_bookmaker_by_id($bookmaker_id);
		$reviews = $this->bookmaker_reviews_model->bookmaker_Reviews($bookmaker_id);
        Template::set('records', $records);
		Template::set('reviews', $reviews);
		Assets::add_js('plugins/validate/jquery.validate.min.js');
		Assets::add_js('plugins/validate/additional-methods.min.js');
		Assets::add_module_js('bookmakers' , 'validate.js');	

		Template::set_block('sidebar_left','tips/sidebar_left');
        Template::render('two_col_left3');
    }

	public function review()
	{
        $bookmaker_id = $this->uri->segment(3);
        $user_id = $this->current_user->id;

		$data = array(
			'user_id' => $user_id,
			'rating' => $this->input->post('rating'),
            'bookmaker_id' => $bookmaker_id,
            'description' => $this->input->post('description')
		);
		
		$review_id = $this->bookmaker_reviews_model->addReview($data);
		redirect('bookmakers/view/'.$bookmaker_id);
    }
	
	
	public function vote_up()
	{

		$review_id = $this->uri->segment(3);
		$bookmaker_id = $this->uri->segment(4);
		$user_id = $this->current_user->id;
		$this->bookmaker_reviews_model->vote($bookmaker_id,$review_id,$user_id,1);
		redirect('bookmakers/view/'.$bookmaker_id);
		
	}
	public function vote_down()
	{

		$review_id = $this->uri->segment(3);
		$bookmaker_id = $this->uri->segment(4);
		$user_id  = $this->current_user->id;
		$this->bookmaker_reviews_model->vote($bookmaker_id,$review_id,$user_id,-1);
		redirect('bookmakers/view/'.$bookmaker_id);
	}

	
}