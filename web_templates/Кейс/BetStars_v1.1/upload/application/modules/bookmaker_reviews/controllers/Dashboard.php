<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Bookmaker_Reviews Admin Controller
 *
 * This class handles bookmaker reviews
 *
 * @package		Bookmaker_Reviews
 * @subpackage	Bookmaker_Reviews
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{
    protected $permissionCreate = 'Bookmaker_Reviews.Create';
    protected $permissionDelete = 'Bookmaker_Reviews.Delete';
    protected $permissionEdit   = 'Bookmaker_Reviews.Edit';
    protected $permissionView   = 'Bookmaker_Reviews.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('bookmaker_reviews_model');
		$this->load->model('bookmakers/bookmakers_model');
		$this->load->model('tipsters/tipsters_model');

		$language = $this->input->cookie('language');
		$this->lang->load('bookmaker_reviews',$language);
		
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
						$deleted = $this->bookmaker_reviews_model->delete($pid);
						if ($deleted == false) {
							$result = false;
						}
					}
					if ($result) {
						Template::set_message(count($checked) . ' ' . lang('bookmaker_reviews_delete_success'), 'success');
					} else {
						Template::set_message(lang('bookmaker_reviews_delete_failure') . $this->bookmaker_reviews_model->error, 'error');
					}
				}
			}	
        }
        
        // Actions done, now display the view.
        $where = array();

        $filterType = $filter;


        switch ($filterType) {
            case 'pending':
                $where['bookmaker_reviews.status'] = 0;
                break;
            case 'approved':
                $where['bookmaker_reviews.status'] = 1;
                break;			
            case 'all':
                // Nothing to do
                break;
            default:
                // Unknown/bad $filterType
                show_404("bookmaker_reviews/index/$filter/");
        }         

        // Fetch the leagues to display
        $this->bookmaker_reviews_model->limit($this->limit, $offset)
                         ->where($where)
						 ->order_by('status', 0)
						 ->order_by('date_posted', 'desc')
                         ->select(
                             array(
                                'review_id',
                                'user_id',
                                'rating',
								'date_posted',
								'description',
								'bookmaker_id',
								'status',
                             )
                         );
						 
        Template::set('records', $this->bookmaker_reviews_model->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/bookmaker_reviews/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->bookmaker_reviews_model->where($where)->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
        
		Template::set('toolbar_title', lang('bookmaker_reviews_manage'));

        Template::render();
    }

	public function update_reviews()
	{
	
        if (isset($_POST['save'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
				redirect(SITE_AREA . '/dashboard/bookmakers/reviews');
			}
			else 
			{		
				foreach ($_POST['review_id'] as $value)
				{
						$item = $value;
						$review_id = $_POST['review_id'][$item];
						$status = $_POST['status'][$item];
						$update =  array(
								 'status' => $status
							  );
						$this->bookmakers_model->UpdtReview($update,$review_id);
						$this->bookmakers_model->DeleteReviews();
				}
				redirect(SITE_AREA . '/dashboard/bookmakers/reviews');
			}	
		}	
	}	    

    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('bookmaker_reviews_invalid_id'), 'error');

            redirect(SITE_AREA . '/dashboard/bookmaker_reviews');
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

				if ($this->save_bookmaker_reviews('update', $id)) {
					log_activity($this->auth->user_id(), lang('bookmaker_reviews_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'bookmaker_reviews');
					Template::set_message(lang('bookmaker_reviews_edit_success'), 'success');
					redirect(SITE_AREA . '/dashboard/bookmaker_reviews');
				}

				// Not validation error
				if ( ! empty($this->bookmakers_model->error)) {
					Template::set_message(lang('bookmaker_reviews_edit_failure') . $this->bookmaker_reviews_model->error, 'error');
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

				if ($this->bookmaker_reviews_model->delete($id)) {
					log_activity($this->auth->user_id(), lang('bookmaker_reviews_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'bookmaker_reviews');
					Template::set_message(lang('bookmaker_reviews_delete_success'), 'success');

					redirect(SITE_AREA . '/dashboard/bookmaker_reviews');
				}

				Template::set_message(lang('bookmaker_reviews_delete_failure') . $this->bookmaker_reviews_model->error, 'error');
			}	
        }
        
        Template::set('bookmaker_reviews', $this->bookmaker_reviews_model->find($id));
        Template::set('toolbar_title', lang('bookmaker_reviews_edit_heading'));
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
    private function save_bookmaker_reviews($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Make sure we only pass in the fields we want
        $data = array();
		$data['status']   = $this->input->post('status');
        

        $return = false;
        if ($type == 'insert') 
		{

			
            $id = $this->bookmaker_reviews_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
			
        } 
		elseif ($type == 'update') 
		{

            $return = $this->bookmaker_reviews_model->update($id, $data);
        }

        return $return;
    }
	
	//--------------------------------------------------------------------

	
}