<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  tags  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index()
	{
		$data['name'] = 'tags';
		$data['tags'] = $this->app->get_all_tags();
		
		$this->load->view('templates/main', $data);
	}
	
	function tag(){
		
		$data['name'] = 'tag_posts';
		$data['posts'] = $this->app->get_all_posts_by_tag($this->uri->segment(2));
		$data['tag_info'] = $this->app->get_tag_info($this->uri->segment(2));
		
		$this->load->view('templates/main',$data);

 		
	}
}