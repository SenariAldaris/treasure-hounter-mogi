<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Teams Admin Controller
 *
 * This class handles teams in admin panel
 *
 * @package		Teams
 * @subpackage	Teams
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{
    protected $permissionCreate = 'Teams.Create';
    protected $permissionDelete = 'Teams.Delete';
    protected $permissionEdit   = 'Teams.Edit';
    protected $permissionView   = 'Teams.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('teams/teams_model');
		$this->load->model('countries/countries_model');
		$this->load->model('leagues/leagues_model');
		$this->load->model('sports/sports_model');

		

		$language = $this->input->cookie('language');
		$this->lang->load('teams',$language);		
		$this->lang->load('bet_events/bet_events',$language);
        
        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
		Assets::add_module_js('teams', 'teams.js');
		//Template::set('leagues', $this->leagues_model->get_leagues()); 
    }

    /**
     * Display a list of Teams data.
     *
     * @return void
     */
    public function index($filter = 'all', $offset = 0)
    {

        // Fetch leagues for the filter and the list.
        $leagues = $this->leagues_model->select('id, sport_id,league_name, league_id, country_id')
                                  ->where('active', 1)
								  ->order_by('sport_id', 'asc')
                                  ->order_by('league_id', 'asc')
                                  ->find_all();
        $getleagues = array();
        foreach ($leagues as $league) {
            $getleagues[$league->id] = $league;
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
						$deleted = $this->teams_model->delete($pid);
						if ($deleted == false) {
							$result = false;
						}
					}
					if ($result) {
						Template::set_message(count($checked) . ' ' . lang('teams_delete_success'), 'success');
					} else {
						Template::set_message(lang('teams_delete_failure') . $this->teams_model->error, 'error');
					}
				}
			}	
        }
        
        // Actions done, now display the view.
        $where = array('teams.active' => 1);
        
		// Filters
        if (preg_match('{league_id-([0-9]*)}', $filter, $matches)) {
            $filterType = 'league_id';
            $leagueId = (int) $matches[1];
        } 
		else 
		{
            $filterType = $filter;
        }      

        switch ($filterType) {		
            case 'league_id':
                $where['teams.league_id'] = $leagueId;
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
                show_404("leagues/index/$filter/");
        }    
         // Fetch the Teams to display
        $this->teams_model->limit($this->limit, $offset)
                         ->where($where)
                         ->select(
                             array(
                                'team_id',
                                'league_id',
								'sport_id',
                                'name',
								'logo',
								'active',
  
                             )
                         );
						 
        Template::set('records', $this->teams_model->order_by('league_id')->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/teams/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->teams_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
        
		Template::set('toolbar_title', lang('teams_manage'));

        Template::render();
    }

    /**
     * Allows editing of Teams data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('teams_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/teams');
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

				if ($this->save_teams('update', $id)) {
					log_activity($this->auth->user_id(), lang('teams_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'teams');
					Template::set_message(lang('teams_edit_success'), 'success');
					
					$league_id = $this->teams_model->get_team_league_id($id);
					redirect(SITE_AREA . '/dashboard/teams/index/league_id-'.$league_id.'');
				}

				// Not validation error
				if ( ! empty($this->teams_model->error)) {
					Template::set_message(lang('teams_edit_failure') . $this->teams_model->error, 'error');
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

				if ($this->teams_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('teams_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'teams');
					Template::set_message(lang('teams_delete_success'), 'success');
					
					
					redirect(SITE_AREA . '/dashboard/teams');
				}

				Template::set_message(lang('teams_delete_failure') . $this->teams_model->error, 'error');
			}	
        }
        
        Template::set('teams', $this->teams_model->find($id));

        Template::set('toolbar_title', lang('teams_edit_heading'));
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
    private function save_teams($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        $data = array();
		$data['name']         = $this->input->post('name');
		$data['league_id']      = $this->input->post('league_id');
		$data['logo']        = $this->input->post('logo');

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
		
			$fdata = $this->savenew();
			// We're only really storing the name of the file in the db, so we can point at the right file in our view.
			if($fdata['upload_data'] != NULL) {
				$data['logo'] = $fdata['upload_data']['file_name'];
			} else {
				$data['logo'] = 'team.png';
			}  
			
            $id = $this->teams_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
			else
			{
				$return = FALSE;
			}
		}	
		
		elseif ($type == 'update') 
		{
		    if($this->input->post('logo')) 
			{
			    $fdata = $this->savenew(); 
			    $data['logo'] = !empty($fdata['upload_data']['file_name'])?$fdata['upload_data']['file_name']:$this->input->post('current_logo'); 
			}
			else 
			{ 
			  $data['logo'] = $this->input->post('current_logo'); 
			}
			
            $return = $this->teams_model->update($id, $data);
        }

        return $return;
    }
	
	//--------------------------------------------------------------------
          private function savenew(){                
 
         $config['upload_path'] = './uploads/teams/'; //Make SURE that you chmod this directory to 777!
         $config['allowed_types'] = 'gif|jpg|png';
         $config['max_size']    = '0'; // 0 = no limit on file size (this also depends on your PHP configuration)
         $config['remove_spaces']=TRUE; //Remove spaces from the file name
 
         $this->load->library('upload', $config);
 
        if ( ! $this->upload->do_upload('logo'))
        {
                $data['error']= array('error' => $this->upload->display_errors());
                log_message('error',$data['error']);
                }
                else
                    {
                    $data = array('upload_data' => $this->upload->data());
 
                    }
            return $data;
        }		
}