<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  delete  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index(){
		$id = $this->uri->segment(2);
		
		$this->db->delete('comments',array('id' => $id));
		$this->db->delete('comments',array('parent_id' => $id));
	}
	
}