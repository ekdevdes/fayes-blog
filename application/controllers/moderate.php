<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  moderate  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index()
	{
		$data['name'] = 'moderate';
		$data['comments'] = $this->app->get_all_comments_to_be_moderated();
		$data['numComments'] = count($data['comments']);
		
		$this->load->view('templates/main', $data);
	}
}