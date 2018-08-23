<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Home controller
 *
 * The base controller which displays the homepage.
 *
 * @package		Home
 * @subpackage	Home
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Home extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('application');
		$this->load->library('Template');
		$this->load->library('Assets');
		$language = $this->input->cookie('language');
		$this->lang->load('tips/tips',$language);
		$this->lang->load('application',$language);
		$this->load->library('events');
		
        $this->load->library('installer_lib');
        if (!$this->installer_lib->is_installed()) {
            $ci =& get_instance();
            $ci->hooks->enabled = false;
            redirect('install');
        }

        $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
	}

	//--------------------------------------------------------------------

	/**
	 * Displays the homepage
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->library('users/auth');
		$this->load->helper('date');
		$this->load->helper('text');

		$this->load->model('tips/tips_model');
		$this->load->model('tipsters/tipsters_model');
		$this->load->model('tips/tips_statuses_model');
		$this->load->model('sports/sports_model');
		$this->load->model('teams/teams_model');
		$this->load->model('leagues/leagues_model');
		$this->load->model('bookmakers/bookmakers_model');
		$this->load->model('bet_events/bet_events_model');
		$this->load->model('countries/countries_model');
		$this->load->model('tips/bet_category_model');
		$this->set_current_user();
		
		Assets::add_js('plugins/knob/jquery.knob.js');		
		Assets::add_js('js/knob.js');		
		Template::set_block('topbar','home/topbar');
        Template::set_block('sidebar_left','home/sidebar_left');
		
		Template::set('status_counts', $this->tips_model->count_by_status()); 
		Template::set('sport_counts', $this->tips_model->limit(10)->count_by_sport());
		Template::set('league_counts', $this->tips_model->limit(10)->count_by_league($sport_id=''));
		
		Template::set('sports', $this->sports_model->get_sports());  
        Template::set('statuses', $this->tips_model->get_tips_statuses());	
		Template::set('bookmakers', $this->bookmakers_model->get_bookmakers());		
		
        Template::set('total_ranking', $this->tips_model->limit(5)->all_time_ranking());
		Template::set('records', $this->tips_model->limit(10)->get_recent_tips());	
		Template::set('popular_bets', $this->tips_model->limit(10)->get_popular_bets());	
		Template::set('last_minute', $this->tips_model->limit(10)->get_last_minute_bets());
		Template::set('stats', $this->tips_model->count_total_profit());		
		
		Template::render('two_col_left3');
	}//end index()

	//--------------------------------------------------------------------

	/**
	 * If the Auth lib is loaded, it will set the current user, since users
	 * will never be needed if the Auth library is not loaded. By not requiring
	 * this to be executed and loaded for every command, we can speed up calls
	 * that don't need users at all, or rely on a different type of auth, like
	 * an API or cronjob.
	 *
	 * Copied from Base_Controller
	 */
	protected function set_current_user()
	{
        if (class_exists('Auth')) {
			// Load our current logged in user for convenience
            if ($this->auth->is_logged_in()) {
				$this->current_user = clone $this->auth->user();
				
            } else {
				$this->current_user = null;
			}

			// Make the current user available in the views
            if (! class_exists('Template')) {
				$this->load->library('Template');
			}
			Template::set('current_user', $this->current_user);
		}
	}
	
	public function language($lang = false)
    {
        $folder = 'application/language/';
        $languagefiles = scandir($folder);
        if (in_array($lang, $languagefiles)) {
            $cookie = array(
                'name' => 'language',
                'value' => $lang,
                'expire' => '31536000',
            );

            $this->input->set_cookie($cookie);
        }
        redirect($this->input->server('HTTP_REFERER'));
    }	
}
/* end ./application/controllers/home.php */
