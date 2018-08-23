<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Tips Admin Controller
 *
 * This class handles tips in admin panel
 *
 * @package		Tips
 * @subpackage	Tips
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{
    protected $permissionCreate = 'Tips.Create';
    protected $permissionDelete = 'Tips.Delete';
    protected $permissionEdit   = 'Tips.Edit';
    protected $permissionView   = 'Tips.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('tips/tips_model');
		$this->load->model('tips/bet_category_model');

		$language = $this->input->cookie('language');
		$this->lang->load('tips',$language);        
		
        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        $this->load->model(array
		(
		 'leagues/leagues_model',
  		 'sports/sports_model',
		 'countries/countries_model',
		 'bookmakers/bookmakers_model',
		 'tipsters/tipsters_model',
		 'results/results_model',
		 'teams/teams_model',
		 'bet_events/bet_events_model')
		 );

    }

//////////////////////////////////////////////////////////
	
    /**
     * Display a list of Tips data.
     *
     * @return void
     */
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

        $leagues = $this->leagues_model->select('id, sport_name, league_name, sport_id,league_id,country_id')
                                  ->where('active', 1)
                                  ->order_by('sport_id', 'asc')
                                  ->order_by('id', 'asc')
                                  ->find_all();
        $getleagues = array();
        foreach ($leagues as $league) {
            $getleagues[$league->league_id] = $league;
        }
        Template::set('leagues', $getleagues);
		

		// Deleting anything?
        if (isset($_POST['delete'])) {
		
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
			}
			else 
			{			
				$this->auth->restrict($this->permissionDelete);
				$checked = $this->input->post('checked');
				if (is_array($checked) && count($checked)) {

					// If any of the deletions fail, set the result to false, so
					// failure message is set if any of the attempts fail, not just
					// the last attempt

					$result = true;
					foreach ($checked as $pid) {
						$deleted = $this->tips_model->delete($pid);
						if ($deleted == false) {
							$result = false;
						}
					}
					if ($result) {
						Template::set_message(count($checked) . ' ' . lang('tips_delete_success'), 'success');
					} else {
						Template::set_message(lang('tips_delete_failure') . $this->tips_model->error, 'error');
					}
				}
			}	
        }
        
        // Actions done, now display the view.
        $where = array('tips.status' => 2);        

		// Filters
        if (preg_match('{sport_id-([0-9]*)}', $filter, $matches)) 
		{
            $filterType = 'sport_id';
            $sportId = (int) $matches[1];
        } 
        elseif (preg_match('{league_id-([0-9]*)}', $filter, $matches)) {
            $filterType = 'league_id';
            $leagueId = (int) $matches[1];
        }
		else
		{		
			$filterType = $filter;
		}	
		
        switch ($filterType) {
            case 'sport_id':
				$where = array('tips.sport_id' => $sportId, 'tips.status !=' => 0);
                foreach ($sports as $sport) {
                    if ($sport->id == $sportId) {
                        Template::set('filter_sport', $sport->name);
                        break;
                    }
                }
                break;		
            case 'league_id':
				$where = array('tips.league_id' => $leagueId, 'tips.status !=' => 0); 
                foreach ($leagues as $league) {
                    if ($league->league_id == $leagueId) {
                        Template::set('filter_league', $league->league_name);
                        break;
                    }
                }
                break;		
            case 'draft':
                $where = array('tips.status' => 1);
                break;		
            case 'inactive':
			    $where = $this->db->where_not_in('status', array(1,2));
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
                         ->where($where)
                         ->select(
                             array(
                                'tips.id',
                                'tips.sport_id',
								'league_id',
                                'match_id',
								'bet_id',
								'bet_name',
								'choice_name',
								'odd',
								'stake',
								'created_on',
								'created_by',
								'status',

  
                             )
                         );
						 
        Template::set('records', $this->tips_model->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/tips/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->tips_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
		Template::set('toolbar_title', lang('tips_manage'));

        Template::render();
    }
    
    /**
     * Allows editing of Tips data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('tips_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/tips');
        }
        
        if (isset($_POST['save'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
				redirect(SITE_AREA . '/dashboard/tips');
			}
			else 
			{			
				$this->auth->restrict($this->permissionEdit);

				if ($this->save_tips('update', $id)) {
					log_activity($this->auth->user_id(), lang('tips_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'tips');
					Template::set_message(lang('tips_edit_success'), 'success');
					//redirect('/');
				}

				// Not validation error
				if ( ! empty($this->tips_model->error)) {
					Template::set_message(lang('tips_edit_failure') . $this->tips_model->error, 'error');
				}
			}	
        }
        
        elseif (isset($_POST['delete'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
				redirect(SITE_AREA . '/dashboard/tips');
			}
			else 
			{			
				$this->auth->restrict($this->permissionDelete);

				if ($this->tips_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('tips_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'tips');
					Template::set_message(lang('tips_delete_success'), 'success');

					redirect(SITE_AREA . '/dashboard/tips');
				}

				Template::set_message(lang('tips_delete_failure') . $this->tips_model->error, 'error');
			}	
        }
		
		Template::set('sports', $this->sports_model->get_sports());
		Template::set('bookmakers', $this->bookmakers_model->get_bookmakers());  
		Template::set('statuses', $this->tips_model->get_tips_statuses_select());		
        Template::set('tips', $this->tips_model->find($id));

        Template::set('toolbar_title', lang('tips_edit_heading'));
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
		$data['match_id']    	 = $this->input->post('match_id');
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
		$data['bet_name']      	 = $this->input->post('bet_name');
		$data['bet_id']      	 = $this->input->post('bet_id');
		$data['choice_name']     = $this->input->post('choice_name');
		$data['odd']             = $this->input->post('odds');		
		$data['stake']           = $this->input->post('stake');
		$data['description']     = $this->input->post('description');
		$data['result']          = (($this->input->post('result'))?$this->input->post('result'):'Pending');
		$data['status']          = (($this->input->post('status'))?$this->input->post('status'):1);

		$stake   = $this->input->post('stake');
		$odds    = $this->input->post('odds');
		$status  = $this->input->post('status');
		
		$win = $stake*$odds;
						
			if($status == 3) {

				$data['winnings']  = $win-$stake;
						
			} elseif ($status == 4){
						
				$data['winnings']  = -$stake;
			}
			elseif ($status == 5 || $status == 1){
			
				$data['winnings']  = 0;
			}			
		
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
}