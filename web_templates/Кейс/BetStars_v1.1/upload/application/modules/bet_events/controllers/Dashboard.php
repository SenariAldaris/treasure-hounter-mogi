<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Bet_Events Admin Controller
 *
 * This class handles bet events
 *
 * @package		Bet_Events
 * @subpackage	Bet_Events
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{

    protected $permissionView   = 'Bet_events.View';
	protected $permissionEdit   = 'Bet_events.Edit';

    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('bet_events/bet_events_model');
        $this->lang->load('bet_events');
		
        $this->load->model(array
		(
		 'leagues/leagues_model',
  		 'sports/sports_model',
		 'teams/teams_model',
		 'countries/countries_model')
		 );

		$this->load->library('settings/settings_lib');
    }
	

    /**
     * Display a list of Bet events data.
     *
     * @return void
     */
	 /////////////////////////////////////////////////////////////////////////
	 
    public function index($filter = 'all', $offset = 0)
    {
  
        // Fetch sports for the filter and the list.
        $sports = $this->sports_model->select('id, name, icon')
                                  ->where('active', 1)
                                  ->order_by('id', 'asc')
                                  ->find_all();
        $getsports = array();
        foreach ($sports as $sport) {
            $getsports[$sport->id] = $sport;
        }
        Template::set('sports', $getsports);

        // Fetch leagues for the filter and the list.
        $leagues = $this->leagues_model->select('sport_name, league_name, leagues.sport_id,leagues.league_id,country_id')
								  ->join('events', 'events.league_id = leagues.league_id','left')
                                  ->where('active', 1)
								  ->where('match_date >=',date('Y-m-d'))
                                  ->order_by('sport_id', 'asc')
                                  ->order_by('leagues.id', 'asc')
                                  ->find_all();
        $getleagues = array();
        foreach ($leagues as $league) {
            $getleagues[$league->league_id] = $league;
        }
        Template::set('leagues', $getleagues);

        // Display the view.
        $where = array();
        
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
                $where['events.sport_id'] = $sportId;
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
                $where['events.league_id'] = $leagueId;
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
                show_404("bet_events/index/$filter/");
        }        
        
        // Fetch the events to display
        $this->bet_events_model->limit($this->limit, $offset)
                         ->where($where)
						 ->order_by('sport_id','asc')
						 //->order_by('league_id','asc')
						 ->order_by('match_date','asc')
						 ->order_by('match_time','asc')
                         ->select(                             
							array(
								'id',
                                'match_id',
                                'sport_id',
								'league_id',
                                'home_team',
								'away_team',
								'match_date',
								'match_time',
								'featured'
  
                             )
							); 
						 
        Template::set('records', $this->bet_events_model->where($where)->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/bet_events/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->bet_events_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);        
        
        Template::set('toolbar_title', lang('bet_events_manage'));

        Template::render();
    }


/////////////////////////////////////////////////////////////////////////
  public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('bet_events_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/bet_events');
        }
        
        if (isset($_POST['save'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
				redirect(SITE_AREA . '/dashboard/bet_events');
			}
			else 
			{			
				$this->auth->restrict($this->permissionEdit);

				if ($this->save_bet_events('update', $id)) {
					Template::set_message(lang('bet_events_edit_success'), 'success');
					redirect(SITE_AREA . '/dashboard/bet_events');
				}

				// Not validation error
				if ( ! empty($this->bet_events_model->error)) {
					Template::set_message(lang('bet_events_edit_failure') . $this->bet_events_model->error, 'error');
				}
			}	
        }
        
	
        Template::set('bet_events', $this->bet_events_model->find($id));

        Template::set('toolbar_title', lang('bet_events_edit_heading'));
        Template::render();
    }
	
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
    private function save_bet_events($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->bet_events_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
		$data = array();
        
		// Data from post
		$data['sport_id']        = $this->input->post('sport_id');
		$data['league_id'] 		 = $this->input->post('league_id');
		$data['match_id']    	 = $this->input->post('match_id');
		$data['match_date']    	 = $this->input->post('match_date');
		$data['match_time']    	 = $this->input->post('match_time');

		$data['featured']          = (($this->input->post('featured'))?$this->input->post('featured'):0);
		
		
        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->bet_events_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->bet_events_model->update($id, $data);
        }

        return $return;
    }
/////////////////////////////////////////////////////////////////////////	
}