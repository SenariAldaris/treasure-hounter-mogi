<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Sports Admin Controller
 *
 * This class handles sports in admin panel
 *
 * @package		Sports
 * @subpackage	Sports
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{
    protected $permissionEdit   = 'Sports.Edit';
    protected $permissionView   = 'Sports.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('sports_model');
		
		$language = $this->input->cookie('language');
		$this->lang->load('sports',$language);		
        
        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
	
    }

    /**
     * Display a list of Sports data.
     *
     * @return void
     */
    public function index($filter = 'active', $offset = 0)
    {
		
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
				show_404("sports/index/$filter/");
        }

        // Fetch the sports to display
        $this->sports_model->limit($this->limit, $offset)
						->where($where)
						 ->order_by('id', 'asc')
                         ->select(
                             array(
								'id',
                                'name',
								'icon',
								'active'
  
                             )
                         );
						 
        Template::set('records', $this->sports_model->where($where)->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/sports/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->sports_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
        
		Template::set('toolbar_title', lang('sports_manage'));

        Template::render();
    }

    /**
     * Allows editing of Sports data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('sports_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/sports');
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

				if ($this->save_sports('update', $id)) {
					log_activity($this->auth->user_id(), lang('sports_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'sports');
					Template::set_message(lang('sports_edit_success'), 'success');
					redirect(SITE_AREA . '/dashboard/sports');
				}

				// Not validation error
				if ( ! empty($this->sports_model->error)) {
					Template::set_message(lang('sports_edit_failure') . $this->sports_model->error, 'error');
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

				if ($this->sports_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('sports_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'sports');
					Template::set_message(lang('sports_delete_success'), 'success');

					redirect(SITE_AREA . '/dashboard/sports');
				}

				Template::set_message(lang('sports_delete_failure') . $this->sports_model->error, 'error');
			}	
        }
        
        Template::set('sports', $this->sports_model->find($id));

        Template::set('toolbar_title', lang('sports_edit_heading'));
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
	private function save_sports($type='insert', $id=0)
	{

		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		// make sure we only pass in the fields we want
		
         $data = array();
		 $data['name']        = $this->input->post('name');
		 $data['active']        = $this->input->post('active');
		 //$data['icon']        = $this->input->post('icon');

		
		if ($type == 'insert')
		{

        $fdata = $this->savenew();
        // We're only really storing the name of the file in the db, so we can point at the right file in our view.
        if($fdata['upload_data'] != NULL) {
            $data['icon'] = $fdata['upload_data']['file_name'];
        }
		else{
		    $data['icon'] = 'no_image.png';
        }  

		
        	$id = $this->sports_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
          if($this->input->post('icon')) 
		 
		    { 
			  $fdata = $this->savenew(); 
			  $data['icon'] = !empty($fdata['upload_data']['file_name'])?$fdata['upload_data']['file_name']:$this->input->post('current_icon'); 
			} 
			else 
			{ 
			  $data['icon'] = $this->input->post('current_icon'); 
			}
			
			$return = $this->sports_model->update($id, $data);
		}

		return $return;
	}
	//--------------------------------------------------------------------
          private function savenew(){                
 
         $config['upload_path'] = './uploads/sports/'; //Make SURE that you chmod this directory to 777!
         $config['allowed_types'] = 'gif|jpg|png';
         $config['max_size']    = '0'; // 0 = no limit on file size (this also depends on your PHP configuration)
         $config['remove_spaces']=TRUE; //Remove spaces from the file name
 
         $this->load->library('upload', $config);
 
        if ( ! $this->upload->do_upload('icon'))
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