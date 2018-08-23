<?php defined('BASEPATH') || exit('No direct script access allowed');


/**
 * News controller
 *
 * The base controller which displays the news.
 *
 * @package		News
 * @subpackage	News
 * @author		codauris
 * @link		http://codauris.tk
 */
 
class News extends Front_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('application');
		$this->load->library('Template');
		$this->load->library('Assets');
		$language = $this->input->cookie('language');
		$this->lang->load('news/news',$language);
		$this->load->library('events');
		
		Assets::add_module_css('news', 'news.css');
		
		include('simple_html_dom.php');

		$this->lang->load('bet_events/bet_events',$language);

        $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
	}


	//--------------------------------------------------------------------
	public function index()
	{
		$url = "http://www.espnfc.com/blogs";
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

		
		if (isset($_POST['save'])) {
		
		    $link = $this->input->post('link');
			$data = $this->input->post('data');
            $this->article(); 

		}	
		Template::set_block('sidebar_left','news/sidebar_left');
		Template::render();
	}//end index()
	
	public function article($post)
	{
		$link = $this->input->post('link');	
		$data = $this->input->post('data');

		if(empty($data)) {
			$url = "$link";
		}
		else 
		{		
			$url = "http://www.espnfc.com/$data";
		}
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
		Template::set_block('sidebar_left','article/sidebar_left');
		Template::render('two_col_left');

	}		
}

