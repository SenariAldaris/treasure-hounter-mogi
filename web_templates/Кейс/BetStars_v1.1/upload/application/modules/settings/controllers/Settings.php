<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Settings Admin Controller
 *
 * Allows the user to management the preferences for the site.
 *
 * @package		Settings
 * @subpackage	Settings
 * @author		codauris
 * @link		http://codauris.tk
 */

class Settings extends Admin_Controller
{

    private $permissionView    = 'Settings.View';
    private $permissionManage  = 'Settings.Manage';

    /**
     * Sets up the permissions and loads required classes
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Restrict access - View and Manage.
        $this->auth->restrict($this->permissionView);
        $this->auth->restrict($this->permissionManage);
		
		$this->load->model('bookmakers/bookmakers_model');
		$this->load->model('sports/sports_model');
		
		$this->load->helper('date_helper');
		
		$language = $this->input->cookie('language');
		$this->lang->load('settings',$language);
		
        if (! class_exists('settings_lib', false)) {
            $this->load->library('settings/settings_lib');
        }

        Template::set('toolbar_title', 'Site Settings');
    }

    /**
     * Display a form with various site settings including site name and
     * registration settings
     *
     * @return void
     */
    public function index()
    {

        if (isset($_POST['save'])) {
		
			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
			}
			else 
			{			
				if ($this->saveSettings()) {
					Template::set_message(lang('settings_saved_success'), 'success');
				} else {
					Template::set_message(lang('settings_error_success'), 'error');
					$settingsError = $this->settings_lib->getError();
					if ($settingsError) {
						Template::set_message($settingsError, 'error');
					}
				}
				redirect(SITE_AREA . '/settings/settings');
			}	
        }

        // Read the current settings
        $settings = $this->settings_lib->find_all();

        // Get the available languages
        $this->load->helper('translate/languages');
		Assets::add_module_js('settings', 'settings.js');

		Assets::add_css('plugins/ckeditor/contents.css');
		Assets::add_js('plugins/ckeditor/ckeditor.js');

        Template::set_view('settings/settings/index');
        Template::set('languages', list_languages());
        Template::set('settings', $settings);

 

        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Perform form validation and save the settings to the database
     *
     * @param array $extended_settings An optional array of settings stored in the
     * extended_settings config file.
     *
     * @return boolean False on error, true when settings are successfully saved.
     */
    private function saveSettings()
    {
        $this->form_validation->set_rules('title', 'lang:bf_site_name', 'required|trim');
        $this->form_validation->set_rules('system_email', 'lang:bf_site_email', 'required|trim|valid_email');
        $this->form_validation->set_rules('offline_reason', 'lang:settings_offline_reason', 'trim');
        $this->form_validation->set_rules('list_limit', 'lang:settings_list_limit', 'required|trim|numeric');
        $this->form_validation->set_rules('password_min_length', 'lang:bf_password_length', 'required|trim|numeric');
        $this->form_validation->set_rules('password_force_numbers', 'lang:bf_password_force_numbers', 'trim|numeric');
        $this->form_validation->set_rules('password_force_symbols', 'lang:bf_password_force_symbols', 'trim|numeric');
        $this->form_validation->set_rules('password_force_mixed_case', 'lang:bf_password_force_mixed_case', 'trim|numeric');
        $this->form_validation->set_rules('password_show_labels', 'lang:bf_password_show_labels', 'trim|numeric');
        $this->form_validation->set_rules('language', 'lang:bf_language', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        $data = array(
            array('name' => 'site.title', 'value' => $this->input->post('title')),
            array('name' => 'site.system_email', 'value' => $this->input->post('system_email')),
            array('name' => 'site.status', 'value' => $this->input->post('status')),
            array('name' => 'site.offline_reason', 'value' => $this->input->post('offline_reason')),
            array('name' => 'site.list_limit', 'value' => $this->input->post('list_limit')),

            array('name' => 'auth.allow_register', 'value' => $this->input->post('allow_register') ? 1 : 0),
            array('name' => 'auth.user_activation_method', 'value' => $this->input->post('user_activation_method') ?: 0),
            array('name' => 'auth.login_type', 'value' => $this->input->post('login_type')),
            array('name' => 'auth.allow_remember', 'value' => $this->input->post('allow_remember') ? 1 : 0),
            array('name' => 'auth.remember_length', 'value' => (int) $this->input->post('remember_length')),
            array('name' => 'auth.password_min_length', 'value' => $this->input->post('password_min_length')),
            array('name' => 'auth.password_force_numbers', 'value' => $this->input->post('password_force_numbers') ? 1 : 0),
            array('name' => 'auth.password_force_symbols', 'value' => $this->input->post('password_force_symbols') ? 1 : 0),
            array('name' => 'auth.password_force_mixed_case', 'value' => $this->input->post('password_force_mixed_case') ? 1 : 0),
            array('name' => 'auth.password_show_labels', 'value' => $this->input->post('password_show_labels') ? 1 : 0),
            array('name' => 'password_iterations', 'value' => $this->input->post('password_iterations')),

			array('name' => 'tips.allow_post', 'value' => $this->input->post('allow_post') ? 1 : 0),
			array('name' => 'tips.rules', 'value' => $this->input->post('tips_rules')),
			
            array(
                'name'  => 'site.default_language',
                'value' => $this->input->post('language') ? $this->input->post('language') : ''
            ),			
        );

        log_activity(
            $this->auth->user_id(),
            lang('bf_act_settings_saved') . ': ' . $this->input->ip_address(),
            'core'
        );

        // Save the settings to the DB.
        $updated = $this->settings_lib->update_batch($data);

        return $updated;
    }

}

