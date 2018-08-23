<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Front Controller
 *
 * This class provides a common place to handle any tasks that need to
 * be done for all public-facing controllers.
 */
 
class Front_Controller extends Base_Controller
{

    //--------------------------------------------------------------------

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        Events::trigger('before_front_controller');

        $this->load->library('template');
        $this->load->library('assets');
		$this->load->library('users/auth');
        $this->set_current_user();
		
		$this->load->model('bet_events/bet_events_model');
		$this->load->library('settings/settings_lib');
		$settings = $this->settings_lib->find_all();
		Template::set('settings', $settings);		
			
		
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
        Events::trigger('after_front_controller');

		
		//$this->getXmlFeed();
    }//end __construct()

    //--------------------------------------------------------------------

	
    public function getXmlFeed()
    {
	
	// Get the last update time 
	$last_update = $this->bet_events_model->get_last_update();
	
	// If last update is older than 10 minutes Update again
	$limit = date('Y-m-d H:i:s', strtotime('-2 minutes', strtotime(date('Y-m-d H:i:s'))));

		
        if( $last_update < $limit) {

			$url = 'http://xml.cdn.betclic.com/odds_en.xml';

			set_time_limit(0);
			$fp = fopen ('fxml/download.xml', 'w+');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_FAILONERROR,1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_exec($ch);			 
			curl_close($ch);
			fclose($fp);
			
			$this->bet_events_model->set_update();
			$this->bet_events_model->delete_update();
			
			$this->bet_events_model->update_db();
			
		}	
			//$this->update();
		
		$today = date('Y-m-d');	
		//$this->bet_events_model->delete_old_events();
		//$this->bet_events_model->delete_old_bets();		
		
    }		
	
	
	
	
	
	
	
	
	
	
}

/* End of file Front_Controller.php */
/* Location: ./application/core/Front_Controller.php */