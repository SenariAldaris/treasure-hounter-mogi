<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Leagues Admin Controller
 *
 * This class handles leagues in admin panel
 *
 * @package		Leagues
 * @subpackage	Leagues
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{
    protected $permissionCreate = 'Leagues.Create';
    protected $permissionDelete = 'Leagues.Delete';
    protected $permissionEdit   = 'Leagues.Edit';
    protected $permissionView   = 'Leagues.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('leagues/leagues_model');
  		$this->load->model('sports/sports_model');
		$this->load->model('countries/countries_model');
		
		$language = $this->input->cookie('language');
		$this->lang->load('leagues',$language);		
			
		$this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        Assets::add_module_js('leagues', 'leagues.js');
    }
 
    /**
     * Display a list of Leagues data.
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

     // Perform any actions?
        foreach (array('delete', 'deactivate', 'activate') as $act) {
            if (isset($_POST[$act])) {
                $action = "_{$act}";
                break;
            }
        }

        // If an action was found, get the checked users and perform the action.
        if (isset($action)) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
			}
			else 
			{	
		
				$checked = $this->input->post('checked');
				if (empty($checked)) {
					// No leaguess checked.
					Template::set_message(lang('leagues_empty_id'), 'error');
				} else {
					foreach ($checked as $leagueId) {
						$this->$action($leagueId);
					}
				}
			}	
        }
		
        // Actions done, now display the view.
        $where = array();
        
		// Filters
        if (preg_match('{sport_id-([0-9]*)}', $filter, $matches)) 
		{
            $filterType = 'sport_id';
            $sportId = (int) $matches[1];
        } 
		else 
		{
            $filterType = $filter;
        }

        switch ($filterType) {
            case 'inactive':
                $where['leagues.active'] = 0;
                break;
            case 'sport_id':
                $where['leagues.sport_id'] = $sportId;
                foreach ($sports as $sport) {
                    if ($sport->id == $sportId) {
                        Template::set('filter_sport', $sport->name);
                        break;
                    }
                }
                break;			
            case 'all':
                // Nothing to do
                break;
            default:
                // Unknown/bad $filterType
                show_404("leagues/index/$filter/");
        }        

        // Fetch the leagues to display
        $this->leagues_model->limit($this->limit, $offset)
						->where($where)
						 ->order_by('sport_id', 'asc')
						 ->order_by('league_id', 'asc')
                         ->select(
                             array(
								'id',
                                'league_id',
                                'sport_id',
                                'league_name',
								'country_id',
								'active'
  
                             )
                         );
						 
        Template::set('records', $this->leagues_model->where($where)->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/leagues/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->leagues_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);

		Template::set('toolbar_title', lang('leagues_manage'));
		
        Template::render();
    }
    
	public function get_championships_by_sport_id($id='')
	{   
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->championships_model->get_admin_championships_by_sport_id($id)));
    } 
	
    /**
     * Create a Leagues object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
			}
			else 
			{		
		
				if ($insert_id = $this->save_leagues()) {

					Template::set_message(lang('leagues_create_success'), 'success');

					redirect(SITE_AREA . '/dashboard/leagues');
				}

				// Not validation error
				if ( ! empty($this->leagues_model->error)) {
					Template::set_message(lang('leagues_create_failure') . $this->leagues_model->error, 'error');
				}
			}	
        }

        Template::set('toolbar_title', lang('leagues_action_create'));
		Template::set('sports', $this->sports_model->get_sports());  
		Assets::add_js('js/codeigniter-csrf.js');	
        Template::render();
    }
    /**
     * Allows editing of Leagues data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('leagues_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/leagues');
        }
        
        if (isset($_POST['save'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
			}
			else 
			{			
				$this->auth->restrict($this->permissionEdit);

				if ($this->save_leagues('update', $id)) {
					log_activity($this->auth->user_id(), lang('leagues_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'leagues');
					Template::set_message(lang('leagues_edit_success'), 'success');
					redirect(SITE_AREA . '/dashboard/leagues');
				}

				// Not validation error
				if ( ! empty($this->leagues_model->error)) {
					Template::set_message(lang('leagues_edit_failure') . $this->leagues_model->error, 'error');
				}
			}	
        }
        
        elseif (isset($_POST['delete'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
			}
			else 
			{			
				$this->auth->restrict($this->permissionDelete);

				if ($this->leagues_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('leagues_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'leagues');
					Template::set_message(lang('leagues_delete_success'), 'success');

					redirect(SITE_AREA . '/dashboard/leagues');
				}

				Template::set_message(lang('leagues_delete_failure') . $this->leagues_model->error, 'error');
			}	
        }
        
        Template::set('leagues', $this->leagues_model->find($id));
		Template::set('sports', $this->sports_model->get_sports()); 
		Template::set('countries', $this->countries_model->get_countries_select()); 
        Template::set('toolbar_title', lang('leagues_edit_heading'));
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
    private function save_leagues($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }



        // Make sure we only pass in the fields we want
        
        $data = array();
		$data['league_name']         = $this->input->post('league_name');
		$data['sport_id']        = $this->input->post('sport_id');
		$data['country_id']      = $this->input->post('country_id');

        $return = false;
		
        if ($type == 'insert') {
		
		
            $id = $this->leagues_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') 
		{
		
		  
			
            $return = $this->leagues_model->update($id, $data);
        }

        return $return;
    }
	
	//--------------------------------------------------------------------
	
    private function _delete($id)
    {
        $league = $this->leagues_model->find($id);
        if (! isset($league)) {
            Template::set_message(lang('leagues_invalid_id'), 'error');
            redirect(SITE_AREA . '/dashboard/leagues');
        }

        if ($this->leagues_model->delete($id)) {
            $league = $this->leagues_model->find($id);

            Template::set_message(lang('leagues_action_deleted'), 'success');
        } elseif (! empty($this->leagues_model->error)) {
            Template::set_message(lang('leagues_action_not_deleted') . $this->leagues_model->error, 'error');
        }
    }
		
    // ACTIVATION METHODS
    //--------------------------------------------------------------------------

    /**
     * Activate the selected league.
     *
     * @param int $leagueId The ID of the league to activate.
     *
     * @return void
     */

    private function _activate($leagueId)
    {
        $this->setLeagueStatus($leagueId, 1, 0);
    }


    /**
     * Deactivate the selected league.
     *
     * @param int $leagueId The ID of the league to deactivate.
     *
     * @return void
     */
    private function _deactivate($leagueId)
    {
        $this->setLeagueStatus($leagueId, 0, 0);
    }	

	
  /**
     * Activate or deactivate a league from the users dashboard.
     *
     * @param int $leagueId        The ID of the league to activate/deactivate.
     * @param int $status        1 = Activate, -1 = Deactivate.
     *
     * @return void
     */
    private function setLeagueStatus($leagueId = false, $status = 1)
    {
        if ($leagueId === false || $leagueId == -1) 
		{
            Template::set_message(lang('leagues_err_no_id'), 'error');
            return;
        }

        // Set the league status (activate/deactivate the league).
        if ($status == 1) 
		{		
            $result = $this->leagues_model->league_activation($leagueId);
            $type = lang('bf_action_activate');
			Template::set_message(lang('leagues_active_status_changed'),  'success');
			
        } 	

		else 
		{
			$result = $this->leagues_model->league_deactivation($leagueId);
            $type = lang('bf_action_deactivate');
			Template::set_message(lang('leagues_inactive_status_changed'), 'success');
	
        }

        if (! $result) 
		{
            if (! empty($this->leagues_model->error)) {
                Template::set_message(lang('leagues_err_status_error') . $this->leagues_model->error, 'error');
            }
            return;
        }

    }

	
	
			
}