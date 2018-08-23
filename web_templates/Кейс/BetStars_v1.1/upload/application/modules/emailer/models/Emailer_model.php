<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Emailer Model
 *
 * This class handles the emailer
 *
 * @package		Emailer
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Emailer_model extends MY_Model
{
    /** @var string Name of the table. */
    protected $table_name = 'email_queue';

    /** @var string Name of the primary key. */
    protected $key = 'id';

    /** @var boolean Whether to use soft deletes. */
    protected $soft_deletes = false;

    /** @var string The date format to use. */
    protected $date_format = 'datetime';

    /** @var boolean Whether to set the created time automatically. */
    protected $set_created = false;

    /** @var boolean Whether to set the modified time automatically. */
    protected $set_modified = false;
}
/* End of file /emailer/models/emailer_model.php */
