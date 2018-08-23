<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Controller
 *
 * This class handles the installation
 *
 * @package		Install
 * @author		codauris
 */

class Install extends CI_Controller {

	protected $minVersionPhp = '5.3';
	
    public function __construct()
    {
        parent::__construct();

        // Load the basics since Base_Controller is not used here.
        $this->lang->load('application');

        // Make sure the template library doesn't try to use sessions.
        $this->load->library('template');
        Template::setSessionUse(false);

        $this->load->library('assets');
        $this->load->library('events');
		
		$this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->helper('application');

        // Disable hooks, since they may rely on an installed environment.
        get_instance()->hooks->enabled = false;

        // Load the Installer library.
        $this->lang->load('install');
        $this->load->library('installer_lib');
    }

	public function index()
	{
        if ($this->installer_lib->is_installed()) {
		   redirect();
		   Template::set_message(lang('in_installed'), 'error');
        }

        $data = array();
        $data['curl_enabled']    = $this->installer_lib->cURL_enabled();
        $data['files']           = $this->installer_lib->check_files();
        $data['folders']         = $this->installer_lib->check_folders();
        $data['php_acceptable']  = $this->installer_lib->php_acceptable($this->minVersionPhp);
        $data['php_min_version'] = $this->minVersionPhp;
        $data['php_version']     = $this->installer_lib->php_version;

        Template::set($data);
		Template::render();
	}
	
	public function dbsetup()
	{
		Template::render();
	}
	public function dbtest()
	{
		Template::render();
	}	
	public function dbinstall()
	{
		Template::render();
	}		
	public function success()
	{
		Template::render();
	}
}

/* End of file install.php */
/* Location: ./application/modules/install/controllers/install_core.php */