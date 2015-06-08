<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  home  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index()
	{
		$data['name'] = 'home';
		$data['posts'] = $this->app->get_all_posts();
		
		$this->load->view('templates/main', $data);
	}
}