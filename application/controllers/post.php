<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  post  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index()
	{
		$data['name'] = 'post';
		$data['post'] = $this->app->get_post($this->uri->segment(2));
		$data['max'] = $this->app->get_max_ids();
	
		
		$this->load->view('templates/main', $data);
	}
}