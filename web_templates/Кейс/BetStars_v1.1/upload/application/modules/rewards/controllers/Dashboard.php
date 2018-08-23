<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Rewards Admin Controller
 *
 * This class handles rewards in admin panel
 *
 * @package		Rewards
 * @subpackage	Rewards
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Dashboard extends Admin_Controller
{
    protected $permissionCreate = 'Rewards.Create';
    protected $permissionDelete = 'Rewards.Delete';
    protected $permissionEdit   = 'Rewards.Edit';
    protected $permissionView   = 'Rewards.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('rewards/rewards_model');
		$this->load->model('competitions/competitions_model');

		$language = $this->input->cookie('language');
		$this->lang->load('rewards',$language);       
		
        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

    }

    /**
     * Display a list of Rewards data.
     *
     * @return void
     */
    public function index($filter = 'all', $offset = 0)
    {
   
        // Fetch sports for the filter and the list.
        $competitions = $this->competitions_model->select('id, name, rewards,currency,active,start_date,end_date')
                                  //->where('active', 1)
                                  ->order_by('id', 'asc')
                                  ->find_all();
        $getcompetitions = array();
        foreach ($competitions as $competition) {
            $getcompetitions[$competition->id] = $competition;
        }
        Template::set('competitions', $getcompetitions);


		 if (isset($_POST['save'])) {

			//Only for Demo mode disabled function
			if(constant("ENVIRONMENT")=='demo')
			{
				Template::set_message(lang('bf_demo_mode'), 'info');
			}
			else 
			{			
				$this->auth->restrict($this->permissionEdit);

				$id = $this->input->post('id');	
				$reward = $this->input->post('reward');

				$final_array = array();
				$length = count($id);
				for($i = 0; $i < $length; $i++) {
					$final_array[$i]['id'] = $id[$i];
					$final_array[$i]['reward'] = $reward[$i];
					// etc.
				}

					
				$this->db->update_batch('competition_rewards',$final_array,'id');

				Template::redirect($this->input->server('HTTP_REFERER'));	
				
				
				
			}	
        }

        
        // Actions done, now display the view.
        $where = array('competition_rewards.competition_id' => 0);
        
		// Filters
        if (preg_match('{competition_id-([0-9]*)}', $filter, $matches)) {
            $filterType = 'competition_id';
            $competitionId = (int) $matches[1];
        } else {
            $filterType = $filter;
        }

        switch ($filterType) {
            case 'competition_id':
                $where['competition_rewards.competition_id'] = $competitionId;
                foreach ($competitions as $competition) {
                    if ($competition->id == $competitionId) {
                        Template::set('filter_competition', $competition->name);
                        break;
                    }
                }
                break;
            case 'all':
                // Nothing to do
                break;
            default:
                // Unknown/bad $filterType
                show_404("rewards/index/$filter/");
        }     

        // Fetch the rewards to display
        $this->rewards_model->limit($this->limit, $offset)
						->where($where)
                        ->select(
                             array(
                                'id',
                                'competition_id',
                                'place',
								'reward',
                             )
                         );
						 
        Template::set('records', $this->rewards_model->find_all());

		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url(SITE_AREA . '/dashboard/rewards/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->rewards_model->count_all();
        $this->pager['uri_segment'] = 6;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);
		
        Assets::add_js('plugins/datatables/jquery.dataTables.min.js');
		Assets::add_js('plugins/datatables/dataTables.bootstrap.min.js'); 
		Assets::add_css('plugins/datatables/dataTables.bootstrap.css');		
		Template::set('toolbar_title', lang('rewards_manage'));

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
    private function save_rewards($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->rewards_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->rewards_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->rewards_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->rewards_model->update($id, $data);
        }

        return $return;
    }
}