<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  lists  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model');
	}

	function index()
	{
		$get = $_GET['q'];
		//fix query
		$query = $this->db->select('name')->group_by('name')->like('name', $get, 'left')->or_like('name',$get,'right')->or_like('name',$get, 'match')->get('tags');
		
		$lists = array();
		
		foreach($query->result() as $row){
			$json = array();
			$json['name'] = humanize($row->name);
			$lists[] = $json;
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($lists));
	}
}