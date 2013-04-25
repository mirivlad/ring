<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
                $this->load->library('rssparser');							// load library
                //$this->rssparser->set_feed_url('https://github.com/mirivlad/ring/commits/master.atom'); 	// get feed
                $this->rssparser->set_feed_url('https://github.com/mirivlad/ring/commits/master.atom'); 
                $this->rssparser->set_cache_life(120); 						// Set cache life time in minutes
                $rss = $this->rssparser->getFeed(6); 						// Get six items from the feed
		$data = array(
		    'title' => 'Главная',
		    'main' => 'active',
                    'news' => $rss
		);

		$this->parser->parse('welcome', $data);
		//$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */