<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * Scores controller
 *
 * The base controller which displays the scores page.
 *
 * @package		Scores
 * @subpackage	Scores
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class Scores extends Front_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('application');
		$this->load->library('Template');
		$this->load->library('Assets');
		$language = $this->input->cookie('language');
		$this->lang->load('tips/tips',$language);
		$this->load->library('events');
		
		$this->load->model('sports/sports_model');
		$this->load->model('countries/countries_model');
		
		Assets::add_module_css('scores', 'scores.css');
		Assets::add_module_js('scores', 'scores.js');

		
		
		
		include('simple_html_dom.php');

		$this->lang->load('bet_events/bet_events',$language);

        $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
	}

	
	//--------------------------------------------------------------------
	public function index()
	{
		$date = date('Ymd');

		$url = "http://www.scoresdata.com/";
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$page = curl_exec($ch);
		curl_close($ch);
		
		Template::set('page', $page);
		$html = new simple_html_dom();
		$html->load($page);
		Template::set('html', $html);
		Template::set('date', $date);

		Template::render();
		
	}//end index()
	
	
	
	
	public function basketball()
	{

		$url = "http://www.scoresdata.com/basketball";
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$page = curl_exec($ch);
		curl_close($ch);
		
		Template::set('page', $page);
		$html = new simple_html_dom();
		$html->load($page);
		Template::set('html', $html);

		Template::render();
		
	}//end index()		
	
	public function handball()
	{

		$url = "http://www.scoresdata.com/handball";
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$page = curl_exec($ch);
		curl_close($ch);
		
		Template::set('page', $page);
		$html = new simple_html_dom();
		$html->load($page);
		Template::set('html', $html);

		Template::render();
		
	}//end index()	
	
	public function hockey()
	{

		$url = "http://www.scoresdata.com/hockey";
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$page = curl_exec($ch);
		curl_close($ch);
		
		Template::set('page', $page);
		$html = new simple_html_dom();
		$html->load($page);
		Template::set('html', $html);

		Template::render();
		
	}//end index()
	

}

