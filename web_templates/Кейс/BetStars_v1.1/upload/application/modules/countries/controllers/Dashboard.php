<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Countries Admin Controller
 *
 * This class handles countries in admin panel
 *
 * @package		Countries
 * @subpackage	Countries
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{
    protected $permissionCreate = 'Countries.Create';
    protected $permissionDelete = 'Countries.Delete';
    protected $permissionEdit   = 'Countries.Edit';
    protected $permissionView   = 'Countries.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('countries_model');

		$language = $this->input->cookie('language');
		$this->lang->load('countries',$language);
        
        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
   
    }

    /**
     * Display a list of Countries data.
     *
     * @return void
     */
    public function index($offset = 0)
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
						$deleted = $this->countries_model->delete($pid);
						if ($deleted == false) {
							$result = false;
						}
					}
					if ($result) {
						Template::set_message(count($checked) . ' ' . lang('countries_delete_success'), 'success');
					} else {
						Template::set_message(lang('countries_delete_failure') . $this->countries_model->error, 'error');
					}
				}
			}	
        }
		
		
        // Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/countries/index') . '/';
        Template::set('index_url', $indexUrl);
		
		$limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = $indexUrl;
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->countries_model->count_all();
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);

        $this->countries_model->limit($limit, $offset);
        
        $records = $this->countries_model->order_by('name','asc')->find_all();

        Template::set('records', $records);
        
		Template::set('toolbar_title', lang('countries_manage'));

        Template::render();
    }
    
    /**
     * Create a Countries object.
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
				if ($insert_id = $this->save_countries()) {
					log_activity($this->auth->user_id(), lang('countries_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'countries');
					Template::set_message(lang('countries_create_success'), 'success');

					redirect(SITE_AREA . '/dashboard/countries');
				}

				// Not validation error
				if ( ! empty($this->countries_model->error)) {
					Template::set_message(lang('countries_create_failure') . $this->countries_model->error, 'error');
				}
			}	
        }

        Template::set('toolbar_title', lang('countries_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Countries data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('countries_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/countries');
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

				if ($this->save_countries('update', $id)) {
					log_activity($this->auth->user_id(), lang('countries_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'countries');
					Template::set_message(lang('countries_edit_success'), 'success');
					redirect(SITE_AREA . '/dashboard/countries');
				}

				// Not validation error
				if ( ! empty($this->countries_model->error)) {
					Template::set_message(lang('countries_edit_failure') . $this->countries_model->error, 'error');
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

				if ($this->countries_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('countries_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'countries');
					Template::set_message(lang('countries_delete_success'), 'success');

					redirect(SITE_AREA . '/dashboard/countries');
				}

				Template::set_message(lang('countries_delete_failure') . $this->countries_model->error, 'error');
			}	
        }
        
        Template::set('countries', $this->countries_model->find($id));

        Template::set('toolbar_title', lang('countries_edit_heading'));
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
    private function save_countries($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->countries_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->countries_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->countries_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->countries_model->update($id, $data);
        }

        return $return;
    }
}