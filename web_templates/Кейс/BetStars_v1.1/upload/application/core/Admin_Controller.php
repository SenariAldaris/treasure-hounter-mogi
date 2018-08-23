<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Admin Controller
 *
 * This class provides a base class for all admin-facing controllers.
 * It automatically loads the form, form_validation and pagination
 * helpers/libraries, sets defaults for pagination and sets our
 * Admin Theme.
 *
 * @package    Bonfire
 * @subpackage MY_Controller
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Admin_Controller extends Authenticated_Controller
{
    protected $pager;
    protected $limit;

    //--------------------------------------------------------------------

    /**
     * Class constructor - setup paging and keyboard shortcuts as well as
     * load various libraries
     *
     */
    public function __construct()
    {


        parent::__construct();

        // Pagination config
        $this->pager = array(
            'full_tag_open'     => '<div class="paginate pull-right"><ul class="pagination">',
            'full_tag_close'    => '</ul></div>',
            'next_link'         => '&rarr;',
            'prev_link'         => '&larr;',
            'next_tag_open'     => '<li>',
            'next_tag_close'    => '</li>',
            'prev_tag_open'     => '<li>',
            'prev_tag_close'    => '</li>',
            'first_tag_open'    => '<li>',
            'first_tag_close'   => '</li>',
            'last_tag_open'     => '<li>',
            'last_tag_close'    => '</li>',
            'cur_tag_open'      => '<li class="active"><a href="#">',
            'cur_tag_close'     => '</a></li>',
            'num_tag_open'      => '<li>',
            'num_tag_close'     => '</li>',
        );
        $this->limit = $this->settings_lib->item('site.list_limit');

        // Basic setup
        Template::set_theme($this->config->item('template.admin_theme'), $this->config->item('template.default_theme'));
    }
}
/* End of file Admin_Controller.php */
