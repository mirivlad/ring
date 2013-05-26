<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Controller {

	/**
         * Контроллер Банков данных.
         * Индекс выводит список банков. Остальные - выводят список данных в этих банках.
         * Для записи будет отдельный контроллер.
	 */
	public function index()
	{
		$data = array(
		    'title' => 'О проекте',
		    'about' => 'active'
		);

		$this->load->view('about', $data);
		//$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */