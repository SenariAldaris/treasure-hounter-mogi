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

class Results extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('results/results_model');
        $this->lang->load('results');
		
        $this->load->model(array
		(
		 'leagues/leagues_model',
  		 'sports/sports_model',
		 'teams/teams_model',
		 'countries/countries_model')
		 );

    }
		


    public function index($filter = 'all', $offset = 0)
    {

			
        // Fetch sports for the filter and the list.
        $sports = $this->sports_model->select('id, name, icon')
                                  ->where('active', 1)
                                  ->order_by('id', 'asc')
                                  ->find_all();
        $getsports = array();
        foreach ($sports as $sport) {
            $getsports[$sport->id] = $sport;
        }
        Template::set('sports', $getsports);

        // Fetch leagues for the filter and the list.
        $leagues = $this->leagues_model->select('sport_name, league_name, sport_id,league_id,country_id')
                                  ->where('active', 1)
                                  ->order_by('sport_id', 'asc')
                                  ->order_by('leagues.id', 'asc')
                                  ->find_all();
        $getleagues = array();
        foreach ($leagues as $league) {
            $getleagues[$league->league_id] = $league;
        }
        Template::set('leagues', $getleagues);

		// Fetch leagues for the filter and the list.
        $dates = $this->results_model->select('match_date')
								 ->where('match_date <=', date('Y-m-d'))	
                                  ->order_by('match_date','desc')
                                  ->find_all();
        $getdates = array();
        foreach ($dates as $date) {
            $getdates[$date->match_date] = $date;
        }
        Template::set('dates', $getdates);
		
		
        // Display the view.
        $where = array();
        
		// Filters
        if (preg_match('{sport_id-([0-9]*)}', $filter, $matches)) {
            $filterType = 'sport_id';
            $sportId = (int) $matches[1];
		}	
		elseif (preg_match('{league_id-([0-9]*)}', $filter, $matches)) {
            $filterType = 'league_id';
            $leagueId = (int) $matches[1];				
        }			
		else {
            $filterType = $filter;
        }

		
        switch ($filterType) {
            case 'sport_id':
                $where['results.sport_id'] = $sportId;
                foreach ($sports as $sport) {
					if ($sport->id == $sportId) {
						$icon = $this->sports_model->get_sport_icon_by_id($sport->id);
						$url = base_url();
                        Template::set('filter_sport', "<img class='h20 mtm4' src='$url/uploads/sports/$icon'/> ". $sport->name);
                        break;
                    }
                }
                break;
            case 'league_id':
                $where['results.league_id'] = $leagueId;
                foreach ($leagues as $league) {
                    if ($league->league_id == $leagueId) {
						$flag = $this->countries_model->get_country_flag_by_id($league->country_id);
						$sp = $this->leagues_model->get_league_sport_id_by_id($league->league_id);
						$sp_icon = $this->sports_model->get_sport_icon_by_id($sp);
						$flag = $this->countries_model->get_country_flag_by_id($league->country_id);
						$url = base_url();
                        Template::set('filter_league', "<img class='h20 mtm2' src='$url/uploads/sports/$sp_icon'/><img class='h20 mtm4' src='$url/uploads/countries/$flag'/> ". $league->league_name);
                        break;
                    }
                }
				 break;					 
            case 'all':
                // Nothing to do
                break;
            default:
                // Unknown/bad $filterType
                show_404("results/index/$filter/");
        }        
        
        // Fetch the events to display
        $this->results_model->limit($this->limit, $offset)
                         ->where($where)
						 ->where('match_date <=',date('Y-m-d'))
						 ->order_by('match_date','desc')
						 ->order_by('match_time','desc')
						 ->order_by('sport_id','asc')
						 ->order_by('league_id','asc')
                         ->select(                             
							array(
								'id',
                                'match_id',
                                'sport_id',
								'league_id',
                                'home_team',
								'away_team',
								'match_date',
								'match_time',
								'home',
								'away'
  
                             )
							); 
						 
        Template::set('records', $this->results_model->where($where)->find_all());
		
		// Used as the view's index_url and the base for the pager's base_url.
        $indexUrl = site_url('results/index') . '/';
        Template::set('index_url', $indexUrl);

        // Pagination
        $this->load->library('pagination');

        $this->pager['base_url']    = "{$indexUrl}{$filter}/";
        $this->pager['per_page'] = $this->limit;
        $this->pager['total_rows']  = $this->results_model->where($where)->count_all();
        $this->pager['uri_segment'] = 4;

        $this->pagination->initialize($this->pager);

        Template::set('filter_type', $filterType);        
        
        Template::set('toolbar_title', lang('results_manage'));
        Template::render('index');
	}//end index()

	//--------------------------------------------------------------------

	
}