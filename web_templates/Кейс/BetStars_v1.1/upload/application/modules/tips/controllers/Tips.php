<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Tips Front Controller
 *
 * This class handles tips on front page
 *
 * @package		Tips
 * @subpackage	Tips
 * @author		codauris
 * @link		http://codauris.tk
 */

class Tips extends Front_Controller
{

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

		$this->load->helper('date');
		$this->load->model('tips/tips_statuses_model');
        $this->load->model('tips_model');
		$this->load->model('tips/bet_category_model');
		$this->load->model('tipsters/tipsters_model');
		$language = $this->input->cookie('language');
        $this->lang->load('tips',$language);
		$this->lang->load('bet_events/bet_events',$language);
		$this->lang->load('bookmakers/bookmakers',$language);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        $this->load->model(array
		(
		 'leagues/leagues_model',
  		 'sports/sports_model',
		 'countries/countries_model',
		 'teams/teams_model',
		 'results/results_model',
		 'bookmakers/bookmakers_model',
		 'bet_events/bet_events_model')
		 );
		
		Template::set('statuses', $this->tips_model->get_tips_statuses());	
		Template::set('status_counts', $this->tips_model->count_by_status()); 
		Template::set('sport_counts', $this->tips_model->limit(10)->count_by_sport());
		Template::set('league_counts', $this->tips_model->limit(10)->count_by_league());	

    }
    /**
     * Display a list of Tips data.
     *
     * @return void
     */
    public function index($filter = 'all', $offset = 0)
    {
        // Fetch sports for the filter and the list.
        $sports = $this->sports_model->select('sports.id, name, icon,display_order')
								  ->join('tips', 'tips.sport_id = sports.id','left')
                                  ->where('sports.active', 1)
								  ->where('tips.status', 2)
                                  ->order_by('display_order', 'asc')
                                  ->find_all();
        $getsports = array();
        foreach ($sports as $sport) {
            $getsports[$sport->id] = $sport;
        }
        Template::set('sports', $getsports);
		
        // Fetch leagues for the filter and the list.
        $leagues = $this->leagues_model->select('sport_name, league_name, leagues.sport_id,leagues.league_id,country_id')
								  ->join('tips', 'tips.league_id = leagues.league_id','left')
                                  ->where('leagues.active', 1)
								  ->where('tips.status', 2)
                                  ->order_by('sport_id', 'asc')
                                  ->order_by('leagues.id', 'asc')
                                  ->find_all();
        $getleagues = array();
        foreach ($leagues as $league) {
            $getleagues[$league->league_id] = $league;
        }
        Template::set('leagues', $getleagues);

		$where = array('tips.status' => 2);

		// Filters
		if (preg_match('{sport_id-([0-9]*)}', $filter, $matches)) {
            $filterType = 'sport_id';
            $sportId = (int) $matches[1];
        }		
        elseif (preg_match('{league_id-([0-9]*)}', $filter, $matches)) {
            $filterType = 'league_id';
            $leagueId = (int) $matches[1];
        }
		else {
            $filterType = $filter;
        }

		
        switch ($filterType) {
            case 'sport_id':
                $where['tips.sport_id'] = $sportId;
                foreach ($sports as $sport) {
					if ($sport->id == $sportId) {
						$icon = $this->sports_model->get_sport_icon_by_id($sport->id);
						$url = base_url();
                        Template::set('filter_sport', "<img class='h20 mtm4' src='$url/uploads/sports/$icon'/> ". $sport->name);
                        break;
                    }
                }
                break;	
            case 'league_id':
                $where['tips.league_id'] = $leagueId;
                foreach ($leagues as $league) {
                    if ($league->league_id == $leagueId) {
						$flag = $this->countries_model->get_country_flag_by_id($league->country_id);
						$sp = $this->leagues_model->get_league_sport_id_by_id($league->league_id);
						$sp_icon = $this->sports_model->get_sport_icon_by_id($sp);
						$flag = $this->countries_model->get_country_flag_by_id($league->country_id);
						$url = base_url();
                        Template::set('filter_league', "<img class='h20 mtm2' src='$url/uploads/sports/$sp_icon'/><img class='h20 mtm4' src='$url/uploads/countries/$flag'/> ". $league->league_name);
                        break;
                    }
				}	
                break;				
            case 'all':
                // Nothing to do
                break;
            default:
                // Unknown/bad $filterType
                show_404("tips/index/$filter/");
        }  

		 // Fetch the tips to display
        $this->tips_model->limit($this->limit, $offset)
                         ->where($where);
		
        Template::set('records', $this->tips_model->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url('tips/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->tips_model->where($where)->count_all();
        $this->pager['uri_segment'] = 4;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
		
 
        Template::set_block('sidebar_left','tips/sidebar_left');
        Template::render('two_col_left3');
    }

    public function preview($id)
    {
		$this->tips_model->updateTipView($id);
        $records = $this->tips_model->get_tip_by_id($id);
        Template::set('records', $records);
		Template::set_view('tips/preview/preview');
        Template::set_block('sidebar_left','preview/sidebar_left');
        Template::render('two_col_left3');
    }
	
    public function by_sport($sport_id)
    {

        $records = $this->tips_model->get_tips_by_sport($sport_id);
		Template::set('sports', $this->sports_model->get_sports());
        Template::set('records', $records);
        Template::set_block('sidebar_left','tips/sidebar_left');
		Template::set_view('tips/by_sport');
        Template::render('two_col_left3');
    }

    public function by_league($league_id)
    {

        $records = $this->tips_model->get_tips_by_league($league_id);
		Template::set('sports', $this->sports_model->get_sports());
        Template::set('records', $records);
        Template::set_block('sidebar_left','tips/by_league/sidebar_left');
		Template::set_view('tips/by_league');
        Template::render('two_col_left3');
    }

    public function create()
    {
		$this->auth->restrict(); // Must be Logged In

        if (isset($_POST['save'])) {

            if ($insert_id = $this->save_tips()) {

                Template::set_message(lang('tips_post_success'), 'success');

                redirect('tips/create');
            }

            // Not validation error
            if ( ! empty($this->tips_model->error)) {
                Template::set_message(lang('tips_create_failure') . $this->tips_model->error, 'error');
            }
        }
		
		Template::set('sports', $this->sports_model->get_tips_sports());
		
		Assets::add_module_js('tips', 'tips.js');
		Assets::add_js('js/codeigniter-csrf.js');
		Assets::add_js('plugins/validate/jquery.validate.min.js');
		Assets::add_js('plugins/validate/additional-methods.min.js');


		Template::set_block('sidebar_left','tips/sidebar_left');
        Template::set('toolbar_title', lang('tips_action_post'));
        Template::render('two_col_left');
    }    


    public function insert_bet()
    {
	
	
        $this->auth->restrict(); // Must be Logged In
		$match_date = $this->input->post('match_date');
		$match_time = $this->input->post('match_time');
		Template::set('home_team', $this->input->post('home_team'));
		Template::set('away_team', $this->input->post('away_team'));

		if (($match_date < date('Y-m-d')) && ($match_time < date('H:i:s'))) {

			Template::set_message(lang('tips_match_started'), 'info');

			redirect('tips/create');
		}		

        if (isset($_POST['save'])) {

            if ($insert_id = $this->save_tips()) {

                Template::set_message(lang('tips_post_success'), 'success');

                redirect('tips/create');
            }

            // Not validation error
            if ( ! empty($this->tips_model->error)) {
                Template::set_message(lang('tips_create_failure') . $this->tips_model->error, 'error');
            }
        }

		
		Assets::add_module_js('tips', 'insert.js');
		Assets::add_js('js/codeigniter-csrf.js');
		Assets::add_js('plugins/validate/jquery.validate.min.js');
		Assets::add_js('plugins/validate/additional-methods.min.js');

		Template::set_block('sidebar_left','tips/sidebar_left');
        Template::set('toolbar_title', lang('tips_action_post'));
        Template::render('two_col_left3');
		
		//$this->results_model->update_teams();
    }  
	
//////////////////////////////////////////////////////////////////////		
    public function custom_bet()
    {

        $this->auth->restrict(); // Must be Logged In
		$match_date = $this->input->post('match_date');
		$match_time = $this->input->post('match_time');
		if (($match_date < date('Y-m-d')) && ($match_time < date('H:i:s'))) {

			Template::set_message(lang('tips_match_started'), 'info');

			redirect('tips/create');
		}	
		Template::set('home_team', $this->input->post('home_team'));
		Template::set('away_team', $this->input->post('away_team'));
		Template::set('bet_id', $this->input->post('bet_id'));
		Template::set('bet_name', $this->input->post('bet_name'));
		Template::set('choice_id', $this->input->post('choice_id'));
		Template::set('choice_name', $this->input->post('choice_name'));
		Template::set('odds', $this->input->post('odds'));
		
        if (isset($_POST['save'])) {
		
            if ($insert_id = $this->save_tips()) {

                Template::set_message(lang('tips_post_success'), 'success');

                redirect('tips/create');
            }

            // Not validation error
            if ( ! empty($this->tips_model->error)) {
                Template::set_message(lang('tips_create_failure') . $this->tips_model->error, 'error');
            }
        }
		
		Assets::add_module_js('tips', 'custom.js');
		Assets::add_js('js/codeigniter-csrf.js');
		Assets::add_js('plugins/validate/jquery.validate.min.js');
		Assets::add_js('plugins/validate/additional-methods.min.js');
		
		Template::set_block('sidebar_left','tips/sidebar_left');
        Template::set('toolbar_title', lang('tips_action_post'));
        Template::render('two_col_left3');
    }  
//////////////////////////////////////////////////////////////////////		
    public function outright_bet()
    {

        $this->auth->restrict(); // Must be Logged In
		$match_date = $this->input->post('match_date');
		if ($match_date < date('Y-m-d')){

			Template::set_message(lang('tips_match_started'), 'info');

			redirect('tips/create');
		}	
		Template::set('sport_id', $this->input->post('sport_id'));
		Template::set('league_id', $this->input->post('league_id'));
		Template::set('match_date', $this->input->post('match_date'));
		Template::set('home_team', $this->input->post('home_team'));
		Template::set('away_team', $this->input->post('away_team'));
		Template::set('bet_id', $this->input->post('bet_id'));
		Template::set('bet_name', $this->input->post('bet_name'));
		Template::set('choice_id', $this->input->post('choice_id'));
		Template::set('choice_name', $this->input->post('choice_name'));
		Template::set('odds', $this->input->post('odds'));
		
        if (isset($_POST['save'])) {
		
            if ($insert_id = $this->save_tips()) {

                Template::set_message(lang('tips_post_success'), 'success');

                redirect('tips/create');
            }

            // Not validation error
            if ( ! empty($this->tips_model->error)) {
                Template::set_message(lang('tips_create_failure') . $this->tips_model->error, 'error');
            }
        }
		
		Assets::add_module_js('tips', 'custom.js');
		Assets::add_js('js/codeigniter-csrf.js');
		Assets::add_js('plugins/validate/jquery.validate.min.js');
		Assets::add_js('plugins/validate/additional-methods.min.js');
		
		Template::set_block('sidebar_left','tips/sidebar_left');
        Template::set('toolbar_title', lang('tips_action_post'));
        Template::render('two_col_left3');
    }  	
//////////////////////////////////////////////////////////////////////		
	public function get_leagues_by_sport_id($id='')
	{   
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->leagues_model->get_leagues_by_sport_id($id)));
    } 
//////////////////////////////////////////////////////////////////////		
	public function get_all_leagues_by_sport_id($id='')
	{   
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->leagues_model->get_all_leagues_by_sport_id($id)));
    } 	

//////////////////////////////////////////////////////////////////////	
	public function get_stake($odds='')
	{   
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->bet_category_model->get_stake($odds)));
    } 
//////////////////////////////////////////////////////////////////////	
	public function get_events_by_league_id($id='')
	{   
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->bet_events_model->get_events_by_league_id($id)));
    } 
//////////////////////////////////////////////////////////////////////	
	public function get_bets_by_match_id($id='')
	{   
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->bet_category_model->get_bets_by_match_id($id)));
    } 

/////////////////////////////////////////////////////////	
	public function get_bet_choice_by_bet_id($bet_id,$match_id)
	{   
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->bet_category_model->get_bet_choice_by_bet_id($bet_id,$match_id)));
    }
///////////////////////////////////////////////////////////////
    public function get_match_odds($bet,$choice_id,$match_id)
    {
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->bet_category_model->get_match_odds($bet,$choice_id,$match_id)));
    }	
///////////////////////////////////////////////////	

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_tips($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->tips_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
		$data = array();
        
		// Data from hidden fields in create view
		$data['created_by']      = $this->input->post('created_by'); // The current user
		$data['created_on']      = $this->input->post('created_on'); // The current date

		// Data from post
		$data['sport_id']        = $this->input->post('sport_id');		
		$data['league_id'] 		 = $this->input->post('league_id');
		$data['match_id']        = $this->input->post('match_id');	
		
		if(!$this->input->post('match_date')){ 
		$data['match_date'] = $this->bet_events_model->get_match_date_by_id($this->input->post('match_id'));
		}
		else{
		$data['match_date']     = $this->input->post('match_date');
		}		
		
		if(!$this->input->post('match_time')){ 
			$data['match_time']     = $this->bet_events_model->get_match_time_by_id($this->input->post('match_id'));
		}
		else{
		$data['match_time']     = $this->input->post('match_time');
		}
			
		$data['bet_id']      	 = $this->input->post('bet_id');
		$data['bet_name']    	 = $this->bet_category_model->get_bet_name_by_id($this->input->post('bet_id'));
		$data['choice_id']       = $this->input->post('choice_id');
		
		if(!$this->input->post('choice_name')){ 
		$data['choice_name'] = $this->bet_category_model->get_choice_name_by_id($this->input->post('choice_id'));
		}
		else{
		$data['choice_name']     = $this->input->post('choice_name');
		}
		$data['odd']             = $this->input->post('odds');		
		$data['stake']           = $this->input->post('stake');
		$data['description']     = $this->input->post('description');
		$data['result']          = (($this->input->post('result'))?$this->input->post('result'):'Pending');
		$data['status']          = (($this->input->post('status'))?$this->input->post('status'):1);

		

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->tips_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->tips_model->update($id, $data);
        }

        return $return;
    }	

   
   /////////////////////////////////////////////////////
}