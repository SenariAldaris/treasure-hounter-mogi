<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Bet_Events Front Controller
 *
 * This class handles bet events on the front page
 *
 * @package		Bet_Events
 * @subpackage	Bet_Events
 * @author		codauris
 * @link		http://codauris.tk
 */

class Bet_events extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('bet_events/bet_events_model');
		$language = $this->input->cookie('language');
		$this->lang->load('bet_events',$language);
		$this->load->helper('text');
		
        $this->load->model(array
		(
		 'leagues/leagues_model',
  		 'sports/sports_model',
		 'bookmakers/bookmakers_model',
		 'tips/tips_model',
		 'teams/teams_model',
		 'results/results_model',
		 'countries/countries_model')
		 );
		
		Template::set_block('sidebar_left','bet_events/sidebar_left');
		Template::set('sports', $this->sports_model->get_sports()); 
		Assets::add_module_js('bet_events', 'events.js');			
    }

	public function index()
	{		
		Template::set('leagues', $this->bet_events_model->get_live_leagues_by_sport_id(1));	
		Template::render('two_col_left3');
	}//end index()

	//--------------------------------------------------------------------

    public function by_sport($sport)
    {

		Assets::add_module_js('bet_events', 'by_sport.js');
        Template::render('two_col_left3');
    } 
	
    public function by_league($league_id)
    {		
	
		$league_id = $this->uri->segment(3);
		$url = "https://en.expekt.com/menu/eventrankingdata?competitionId=$league_id";
		$result = file_get_contents($url);
		
		$data = json_decode($result);
		
		if(!empty($data->ServiceDataUrl)) 
		{
			$rank_url = $data->ServiceDataUrl;
			$rank = file_get_contents($rank_url);

			
			$rank = str_replace('getRanking(','', $rank);
			$rank = str_replace(');','', $rank);
			Template::set('rank', $rank);
		}
		
		Assets::add_module_js('bet_events', 'by_sport.js');
        Template::render('two_col_left3');
    }








	
}