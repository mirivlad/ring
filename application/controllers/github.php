<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Github extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->dx_auth->check_uri_permissions();
        }
        
	public function index()
	{
                $this->load->library('rssparser');							// load library
                //$this->rssparser->set_feed_url('https://github.com/mirivlad/ring/commits/master.atom'); 	// get feed
                $this->rssparser->set_feed_url('https://github.com/mirivlad/ring/commits/master.atom'); 
                $this->rssparser->set_cache_life(120); 						// Set cache life time in minutes
                $rss = $this->rssparser->getFeed(15); 						// Get six items from the feed
		$data = array(
		    'title' => 'Развитие движка проекта',
		    'main' => 'active',
                    'news' => $rss
		);

		$this->load->view('github', $data);
		//$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */