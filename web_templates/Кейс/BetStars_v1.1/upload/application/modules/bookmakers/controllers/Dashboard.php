<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Bookmakers Admin Controller
 *
 * This class handles bookmakers in admin panel
 *
 * @package		Bookmakers
 * @subpackage	Bookmakers
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Dashboard extends Admin_Controller
{
    protected $permissionCreate = 'Bookmakers.Create';
    protected $permissionDelete = 'Bookmakers.Delete';
    protected $permissionEdit   = 'Bookmakers.Edit';
    protected $permissionView   = 'Bookmakers.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('bookmakers/bookmakers_model');
		$this->load->model('bookmaker_reviews/bookmaker_reviews_model');
		$this->load->model('tipsters/tipsters_model');

		$language = $this->input->cookie('language');
		$this->lang->load('bookmakers',$language);
		
		$this->load->helper('date');
		$this->load->helper('text');
        
        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

    }

    /**
     * Display a list of Bookmakers data.
     *
     * @return void
     */
    public function index($filter = 'all', $offset = 0)
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
						$deleted = $this->bookmakers_model->delete($pid);
						if ($deleted == false) {
							$result = false;
						}
					}
					if ($result) {
						Template::set_message(count($checked) . ' ' . lang('bookmakers_delete_success'), 'success');
					} else {
						Template::set_message(lang('bookmakers_delete_failure') . $this->bookmakers_model->error, 'error');
					}
				}
			}	
        }
        
        // Actions done, now display the view.
        $where = array();     
			
		$filterType = $filter;	
        
        switch ($filterType) {			
            case 'all':
                // Nothing to do
                break;
            default:
                // Unknown/bad $filterType
                show_404("bookmakers/index/$filter/");
        }        

        // Fetch the leagues to display
        $this->bookmakers_model->limit($this->limit, $offset)
                         ->where($where)
						 ->order_by('id', 'asc')
                         ->select(
                             array(
                                'id',
                                'logo',
                                'name',
								'url',
								'review',
								'bonus_offer',
								'bonus_code',
                             )
                         );
						 
        Template::set('records', $this->bookmakers_model->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/bookmakers/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->bookmakers_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
        
		Template::set('toolbar_title', lang('bookmakers_manage'));

        Template::render();
    }

    /**
     * Create a Bookmakers object.
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
				if ($insert_id = $this->save_bookmakers()) {
					log_activity($this->auth->user_id(), lang('bookmakers_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'bookmakers');
					Template::set_message(lang('bookmakers_create_success'), 'success');

					redirect(SITE_AREA . '/dashboard/bookmakers');
				}

				// Not validation error
				if ( ! empty($this->bookmakers_model->error)) {
					Template::set_message(lang('bookmakers_create_failure') . $this->bookmakers_model->error, 'error');
				}
			}	
        }

        Template::set('toolbar_title', lang('bookmakers_action_create'));
		Assets::add_css('plugins/ckeditor/contents.css');
		Assets::add_js('plugins/ckeditor/ckeditor.js');
		Assets::add_module_js('bookmakers', 'bookmakers.js');
        Template::render();
    }
    /**
     * Allows editing of Bookmakers data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('bookmakers_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/bookmakers');
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

				if ($this->save_bookmakers('update', $id)) {
					log_activity($this->auth->user_id(), lang('bookmakers_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'bookmakers');
					Template::set_message(lang('bookmakers_edit_success'), 'success');
					redirect(SITE_AREA . '/dashboard/bookmakers');
				}

				// Not validation error
				if ( ! empty($this->bookmakers_model->error)) {
					Template::set_message(lang('bookmakers_edit_failure') . $this->bookmakers_model->error, 'error');
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

				if ($this->bookmakers_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('bookmakers_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'bookmakers');
					Template::set_message(lang('bookmakers_delete_success'), 'success');

					redirect(SITE_AREA . '/dashboard/bookmakers');
				}

				Template::set_message(lang('bookmakers_delete_failure') . $this->bookmakers_model->error, 'error');
			}	
        }
        
        Template::set('bookmakers', $this->bookmakers_model->find($id));
		Assets::add_css('plugins/ckeditor/contents2.css');
		Assets::add_js('plugins/ckeditor/ckeditor.js');
		Assets::add_module_js('bookmakers', 'bookmakers.js');
        Template::set('toolbar_title', lang('bookmakers_edit_heading'));
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
    private function save_bookmakers($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Make sure we only pass in the fields we want
        $data = array();
		$data['name']         = $this->input->post('name');
		$data['url']          = $this->input->post('url');
		$data['review']       = $this->input->post('review');
		$data['bonus_offer']       = $this->input->post('bonus_offer');
		$data['bonus_code']   = $this->input->post('bonus_code');
		
		$data['banner']   = $this->input->post('banner');
		$data['banner_url']   = $this->input->post('banner_url');
		$data['banner_type']   = $this->input->post('banner_type');
        

        $return = false;
        if ($type == 'insert') 
		{
		
			$fdata = $this->savenew();
			// We're only really storing the name of the file in the db, so we can point at the right file in our view.
			if($fdata['upload_data'] != NULL) 
			{
				$data['logo'] = $fdata['upload_data']['file_name'];
			} 
			else 
			{
				$data['logo'] = 'no_image.png';
			}  
			
			$bdata = $this->savebanner();
			// We're only really storing the name of the file in the db, so we can point at the right file in our view.
			if($bdata['upload_data'] != NULL) 
			{
				$data['banner'] = $bdata['upload_data']['file_name'];
			} 
			else 
			{
				$data['banner'] = '';
			} 			
			
            $id = $this->bookmakers_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
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
			
			
			if($this->input->post('banner')) 
		 
		    { 
			  $bdata = $this->savebanner(); 
			  $data['banner'] = !empty($bdata['upload_data']['file_name'])?$bdata['upload_data']['file_name']:$this->input->post('current_banner'); 
			} 
			else 
			{ 
			  $data['banner'] = $this->input->post('current_banner'); 
			}		
            $return = $this->bookmakers_model->update($id, $data);
        }

        return $return;
    }
	
	//--------------------------------------------------------------------
    private function savenew()
	{                
 
        $config['upload_path'] = './uploads/bookmakers/'; //Make SURE that you chmod this directory to 777!
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
	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
    private function savebanner()
	{                
 
        $config['upload_path'] = './uploads/bookmakers/'; //Make SURE that you chmod this directory to 777!
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']    = '0'; // 0 = no limit on file size (this also depends on your PHP configuration)
        $config['remove_spaces']=TRUE; //Remove spaces from the file name
 
        $this->load->library('upload', $config);
 
        if ( ! $this->upload->do_upload('banner'))
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