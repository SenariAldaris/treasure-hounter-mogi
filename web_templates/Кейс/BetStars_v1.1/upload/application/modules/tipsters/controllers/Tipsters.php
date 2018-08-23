<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Tipsters Front Controller
 *
 * This class handles tipsters rankings,profiles..
 *
 * @package		Tipsters
 * @subpackage	Tipsters
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Tipsters extends Front_Controller
{

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
		
        $this->load->library('users/auth');
		$this->load->model('tipsters_model');
        $this->load->model('tips/tips_model');

		$this->load->model('users/user_model');
        $this->load->model(array
		(
		 'leagues/leagues_model',
  		 'sports/sports_model',
		 'leagues/leagues_model',
		 'countries/countries_model',
		 'competitions/competitions_model',
		 'teams/teams_model',
		 'bookmakers/bookmakers_model',
		 'tips/bet_category_model',
		 'bet_events/bet_events_model')
		);
		
		$language = $this->input->cookie('language');
        $this->lang->load('tips/tips',$language);		
    }

    public function index()
    {
		Assets::add_js('plugins/datepicker/bootstrap-datepicker.js');
		Assets::add_css('plugins/datepicker/datepicker.css');	
		Assets::add_module_js('tipsters', 'ranking.js');	
		Assets::add_js('js/codeigniter-csrf.js');		

		Template::set('last_month_ranking', $this->tips_model->last_month_ranking());
		Template::set('last_three_months_ranking', $this->tips_model->last_three_months_ranking());
		Template::set('last_six_months_ranking', $this->tips_model->last_six_months_ranking());
        Template::set('all_time_ranking', $this->tips_model->all_time_ranking());	
		Template::set('sport_counts', $this->tips_model->limit(10)->count_by_sport());
		Template::set('league_counts', $this->tips_model->limit(10)->count_by_league());
		Template::set('sports', $this->sports_model->get_sports());
        Template::set_view('ranking_full');
		Template::set_block('sidebar_left','tipsters/ranking/sidebar_left');
        Template::render('two_col_left3');
    }
///////////////////////////////////////////////////////		

	public function profile($user_id)
    {
		
	    if (empty($user_id) || ($user_id == 1)){
            Template::redirect($this->input->server('HTTP_REFERER'));
        }
		
        $this->load->helper('date');
		$this->tips_model->updateProfileView($user_id);
		// Get the user information.
		$user = $this->user_model->find($user_id);
		
		// Redirect if not valid user ID
		 if (!$user){
            Template::redirect($this->input->server('HTTP_REFERER'));
        }	
        $this->set_current_user();

		Assets::add_js('plugins/knob/jquery.knob.js');
		Assets::add_module_js('js/knob.js');
		Assets::add_js('plugins/datepicker/bootstrap-datepicker.js');
		Assets::add_css('plugins/datepicker/datepicker.css');	
		Assets::add_module_js('tipsters', 'tipsters.js');	
		Assets::add_js('js/codeigniter-csrf.js');
        Template::set('user', $user);
		Template::set('active_tips', $this->tips_model->get_active_tipster_tips($user_id));
		Template::set('archived_tips', $this->tips_model->get_archived_tipster_tips($user_id));
		
		Template::set('fav_sports', $this->tipsters_model->user_favorit_sports($user_id));
		Template::set('fav_leagues', $this->tipsters_model->user_favorit_leagues($user_id));
		

		Template::set('sports', $this->sports_model->get_sports());
		Template::set_block('sidebar_left','tipsters/sidebar_left');

        Template::render('two_col_left3');
    }
	

///////////////////////////////////////////////////////	
    public function get_user_tips_by_date()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$user_id = $this->input->post('user_id');
		$sport = $this->input->post('sport');
		$status = $this->input->post('status');
        $invalid_date = lang('tips_invalid_date');
		
        if(empty($from) && empty($to)){
            echo"<span class='text-red fs14'>$invalid_date</span></h3>";
                 exit;
        }
        else
		{
            $this->tipsters_model->get_user_tips_by_date($from , $to, $user_id, $sport, $status);
        }
		 
		
    }

///////////////////////////////////////////////////////	
    public function get_rankings_by_date()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
        $invalid_date = lang('tips_invalid_date');
		
        if(empty($from) && empty($to)){
            echo"<span class='text-red fs14'>$invalid_date</span></h3>";
                 exit;
        }
        else
		{
            $this->tipsters_model->rankings_by_date($from , $to);
        }
		 
		
    }	
///////////////////////////////////////////////////////	 	
	public function follow()
	{
		// Make sure the user is logged in.
        $this->auth->restrict();
        $this->set_current_user();
		
		$follower_id  = $this->current_user->id;
		$following_id = $this->uri->segment(3);
		$tipster = $this->tipsters_model->get_user_display_name_by_id($following_id);		
		
		//Only for Demo mode disabled function
		if(constant("ENVIRONMENT")=='demo')
		{
			Template::set_message(lang('bf_demo_mode'), 'info');
			Template::redirect($this->input->server('HTTP_REFERER'));
		}
		else 
		{				

			
			$this->tipsters_model->AddFollow($follower_id, $following_id);
			Template::set_message(sprintf(lang('tips_success_follow') , $tipster), 'success');

			Template::redirect($this->input->server('HTTP_REFERER'));
		}

	}	
///////////////////////////////////////////////////////	 	
	public function unfollow()
	{
		
		//Only for Demo mode disabled function
		if(constant("ENVIRONMENT")=='demo')
		{
			Template::set_message(lang('bf_demo_mode'), 'info');
			Template::redirect($this->input->server('HTTP_REFERER'));
		}
		else 
		{		
			$follow_id = $this->uri->segment(3);
			$tipster = $this->tipsters_model->get_user_display_name_by_id($this->uri->segment(4));
			
			$this->tipsters_model->RemoveFollow($follow_id);
			Template::set_message(sprintf(lang('tips_success_unfollow') , $tipster), 'success');
			
			Template::redirect($this->input->server('HTTP_REFERER'));
			
		}
	}	
///////////////////////////////////////////////////////	 
  

	
}