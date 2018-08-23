<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dashboard Controller
 *
 * The controller displays the admin dashboard.
 *
 * @package		Dashboard
 * @subpackage	Dashboard
 * @author		codauris
 * @link		http://codauris.tk
 */
 

class Dashboard extends Admin_Controller
{


	/**
	 * Controller constructor sets the Title and Permissions
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		Template::set('toolbar_title', 'Dashboard');
		$this->load->model('roles/role_model');
		$this->load->model('users/user_model'); 
		$this->load->model('tips/tips_model'); 
		$this->load->model('bet_events/bet_events_model'); 
		
		$language = $this->input->cookie('language');
		$this->lang->load('roles/roles',$language);
		$this->lang->load('tips/tips',$language);
		
		Template::set('status_counts', $this->tips_model->count_by_status()); 
		$this->auth->restrict('Dashboard.View');

		$this->output->cache(0);
	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Displays the initial page of the Content context
	 *
	 * @return void
	 */
	public function index()
	{
	
		Template::set('role_counts', $this->user_model->count_by_roles());
        Template::set('total_users', $this->user_model->count_all());
		Template::set('roles', $this->role_model->where('deleted', 0)->find_all());
		Template::set_view('admin/dashboard/index');
		Template::render();
	}//end index()

	//--------------------------------------------------------------------


}//end class