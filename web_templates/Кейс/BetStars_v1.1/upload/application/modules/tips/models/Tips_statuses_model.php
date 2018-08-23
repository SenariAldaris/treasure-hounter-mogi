<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tips Statuses Model
 *
 * This class handles statuses
 *
 * @package		Tips Statuses
 * @subpackage	Model
 * @author		codauris
 * @link		http://codauris.tk
 */
 
 
class Tips_statuses_model extends MY_Model {

	protected $table_name	= "tip_statuses";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;

}
