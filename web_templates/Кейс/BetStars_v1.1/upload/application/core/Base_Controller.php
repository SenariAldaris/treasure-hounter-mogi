<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Base Controller
 *
 * This provides a controller that your controllers can extend. This allows any
 * tasks that need to be performed sitewide to be done in one place.
 * Since it extends from MX_Controller, any controller in the system can be used
 * in the HMVC style, using modules::run(). 
 */
 
class Base_Controller extends MX_Controller
{
    /**
     * @var string Stores the previously viewed page's complete URL.
     */
    protected $previous_page;

    /**
     * @var string Stores the page requested.
     *
     * This will sometimes be different than the previous page if a redirect
     * happened in the controller.
     */
    protected $requested_page;

    /**
     * @var object Stores the current user's details, if they've logged in.
     */
    protected $current_user = null;

    /**
     * @var bool If TRUE, this class requires the user to be logged in before
     * accessing any method.
     */
    protected $require_authentication = false;

    /**
     * @var array Stores a number of items to 'autoload' when the class
     * constructor runs. This allows any controller to easily set items which
     * should always be loaded, but not to force the entire application to
     * autoload it through the config/autoload file.
     */
    public $autoload = array(
        'libraries' => array('settings/settings_lib', 'events','session'),
        'helpers'   => array('application'),
        'models'    => array(),
    );

    //--------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Handle any autoloading here...
        $this->autoload_classes();

        $controllerClass = get_class($this);
        Events::trigger('before_controller', $controllerClass);

        if ($this->require_authentication === true) {
            $this->authenticate();
        }
		
		// Load the lang file here, after the user's language is known
        if ($this->input->cookie('language') != '') 
		{
            $language = $this->input->cookie('language');
        } 
		else
		{
			$language = $this->settings_lib->item('default.language');
        }
		
        $this->lang->load('application', $language);


        $cacheDriver = array();

        // Performance optimizations for production environments.
        if (ENVIRONMENT == 'production') {
            // Saving queries can vastly increase the memory usage
            $this->db->save_queries = false;

            // With debugging information turned off, at times it is possible to
            // continue on after db errors. Also turns off display of any DB
            // errors to reduce info available to hackers.
            $this->db->db_debug = false;

            $cacheDriver['adapter'] = 'apc';
            $cacheDriver['backup']  = 'file';
        } elseif (ENVIRONMENT == 'testing') {
            // Testing niceties...
            // Saving Queries can vastly increase the memory usage
            $this->db->save_queries = false;

            $cacheDriver['adapter'] = 'apc';
            $cacheDriver['backup']  = 'file';
        } else {
            // Development niceties...

            $cacheDriver['adapter'] = 'dummy';
        }

        $this->load->driver('cache', $cacheDriver);

        // Make sure no assets end up as a requested page or a 404 page.
        if (! preg_match('/\.(gif|jpg|jpeg|png|css|js|ico|shtml)$/i', $this->uri->uri_string())) {
            $this->previous_page  = $this->session->userdata('previous_page');
            $this->requested_page = $this->session->userdata('requested_page');
        }

        // After-Controller Constructor Event
        $controllerClass = get_class($this);
        Events::trigger('after_controller_constructor', $controllerClass);
    }

    /**
     * If the Auth lib is loaded, it will set the current user, since users will
     * never be needed if the Auth library is not loaded. By not requiring this
     * to be executed and loaded for every command, calls that don't need users
     * at all, or which rely on a different type of auth (like an API or
     * cronjob), can be sped up.
     */
    protected function set_current_user()
    {
        if (class_exists('Auth', false)) {
            // Load the currently logged-in user for convenience
            if ($this->auth->is_logged_in()) {
                $this->current_user = clone $this->auth->user();
            }

            // Make the current user available in the views
            if (! class_exists('template', false)) {
                $this->load->library('template');
            }
            Template::set('current_user', $this->current_user);
        }
    }

    /**
     * Performs the authentication of a class. Ensures that a user is logged in.
     * Any additional authentication will need to be done by the child classes.
     *
     * By having the authenticaiton handled here, it can be called in the
     * Base_Controller's __construct() method to ensure the user's chosen
     * language is used.
     */
    protected function authenticate()
    {
        // Load the Auth library before the parent constructor to ensure the
        // current user's settings are honored by the parent
        $this->load->library('users/auth');

        // Ensure the user is logged in.
        $this->auth->restrict();

        $this->set_current_user();
    }

    /**
     * Autoloads any class-specific files that are needed throughout the
     * controller. This is often used by base controllers, but can easily be
     * used to autoload models, etc.
     *
     * @return void
     */
    public function autoload_classes()
    {
        // Using ! empty() because count() returns 1 for certain error conditions

        if (! empty($this->autoload['libraries'])
            && is_array($this->autoload['libraries'])
        ) {
            foreach ($this->autoload['libraries'] as $library) {
                $this->load->library($library);
            }
        }

        if (! empty($this->autoload['helpers'])
            && is_array($this->autoload['helpers'])
        ) {
            foreach ($this->autoload['helpers'] as $helper) {
                $this->load->helper($helper);
            }
        }

        if (! empty($this->autoload['models'])
            && is_array($this->autoload['models'])
        ) {
            foreach ($this->autoload['models'] as $model) {
                $this->load->model($model);
            }
        }
    }

}
