<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Competitions Admin Controller
 *
 * This class handles competitions in admin panel
 *
 * @package		Competitions
 * @subpackage	Competitions
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Dashboard extends Admin_Controller
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
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('competitions/competitions_model');
		$this->load->model('sports/sports_model');
		$this->load->model('leagues/leagues_model');
		$this->load->model('bookmakers/bookmakers_model');
		$this->load->model('countries/countries_model');
		$this->load->model('tipsters/tipsters_model');

		$language = $this->input->cookie('language');
		$this->lang->load('competitions',$language);        

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set('sports', $this->sports_model->get_sports());
		Template::set('bookmakers', $this->bookmakers_model->get_bookmakers_select()); 
		Assets::add_js('js/codeigniter-csrf.js');
        Assets::add_js('plugins/datepicker/bootstrap-datepicker.js');
		Assets::add_css('plugins/datepicker/datepicker.css');			
        Assets::add_module_js('competitions', 'competitions.js');
    }

    /**
     * Display a list of Competitions data.
     *
     * @return void
     */
    public function index($filter = 'active', $offset = 0)
    {

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
						$deleted = $this->competitions_model->delete($pid);
						if ($deleted == false) {
							$result = false;
						}
					}
					if ($result) {
						Template::set_message(count($checked) . ' ' . lang('competitions_delete_success'), 'success');
					} else {
						Template::set_message(lang('competitions_delete_failure') . $this->competitions_model->error, 'error');
					}
				}
			}	
        }
		
		$where['active'] = 1;
		 
		$filterType = $filter;
		
		switch ($filterType) {
            case 'inactive':
                $where['active'] = 0;
                break;		
			case 'active':
				// Nothing to do
				break;
			default:
				// Unknown/bad $filterType
				show_404("competitions/index/$filter/");
        }

        // Fetch the competitions to display
        $this->competitions_model->limit($this->limit, $offset)
						->where($where)
						 ->order_by('id', 'asc')
                         ->select(
                             array(
								'id',
                                'name',
								'sport_id',
								'sport_id',
								'league_id',
								'start_date',
								'end_date',
								'price_pool',
								'currency',
								'rewards',
								'sponsored_by',
								'min_tips',
								'description',
								'active'
  
                             )
                         );
						 
		Template::set('records', $this->competitions_model->where($where)->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/competitions/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->competitions_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
        
		Template::set('toolbar_title', lang('competitions_manage'));

        Template::render();						 
						 

        
    }

    /**
     * Create a Competitions object.
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
				if ($insert_id = $this->save_competitions()) {
					log_activity($this->auth->user_id(), lang('competitions_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'competitions');
					Template::set_message(lang('competitions_create_success'), 'success');

					redirect(SITE_AREA . '/dashboard/competitions');
				}

				// Not validation error
				if ( ! empty($this->competitions_model->error)) {
					Template::set_message(lang('competitions_create_failure') . $this->competitions_model->error, 'error');
				}
			}	
        }

        Template::set('toolbar_title', lang('competitions_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Competitions data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('competitions_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/competitions');
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

				if ($this->save_competitions('update', $id)) {
					log_activity($this->auth->user_id(), lang('competitions_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'competitions');
					Template::set_message(lang('competitions_edit_success'), 'success');
					redirect(SITE_AREA . '/dashboard/competitions/edit/'. $id .'');
				}

				// Not validation error
				if ( ! empty($this->competitions_model->error)) {
					Template::set_message(lang('competitions_edit_failure') . $this->competitions_model->error, 'error');
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

				if ($this->competitions_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('competitions_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'competitions');
					Template::set_message(lang('competitions_delete_success'), 'success');

					redirect(SITE_AREA . '/dashboard/competitions');
				}

				Template::set_message(lang('competitions_delete_failure') . $this->competitions_model->error, 'error');
			}	
        }
        
        Template::set('competitions', $this->competitions_model->find($id));
		Template::set('tipsters', $this->tipsters_model->get_tipsters());
        Template::set('toolbar_title', lang('competitions_edit_heading'));
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
    private function save_competitions($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->competitions_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->competitions_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['start_date']	= $this->input->post('start_date') ? $this->input->post('start_date') : '0000-00-00';
		$data['end_date']	= $this->input->post('end_date') ? $this->input->post('end_date') : '0000-00-00';
		$data['winner']		= $this->input->post('winner');
		
		


		
		

        $return = false;
        if ($type == 'insert') {
            $id = $this->competitions_model->insert($data);

			
					//  Rewards DATA
		$n = $this->input->post('rewards');

			foreach (range(1, $n) as $i){
				$rewards_data = array(

					'competition_id' => $id,
					'place' => $i++,
					'reward' => 0
					// etc.
				);
				
				$this->db->insert('competition_rewards',$rewards_data);
			}
			
			
            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->competitions_model->update($id, $data);
        }

        return $return;
    }

}