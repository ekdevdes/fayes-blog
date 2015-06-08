<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  edit  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index(){
			$data['name'] = 'edit';
			$data['post'] = $this->app->get_post($this->uri->segment(2));
			$data['tags'] = $this->app->get_all_post_tags($data['post']['id']);

			$this->load->view('templates/main', $data);
	}
	
}