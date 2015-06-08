<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  login  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index()
	{
		$data['name'] = 'login';
		
		$this->load->view('templates/main', $data);
	}
	
	function check(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username','username','trim|required|valid_email');
		$this->form_validation->set_rules('pw', 'password','trim|required|min_length[4]');
		$this->form_validation->set_message('required','You didn\'t give me your %s');
		$this->form_validation->set_message('min_length','Your %s must be at least 4 characters long');
		$this->form_validation->set_message('valid_email', 'Your %s must be a valid email address');
		
		if($this->form_validation->run() == FALSE){
			$data['name'] = 'login';
			$data['errors'] = TRUE;
			$this->load->view('templates/main', $data);
		}else{
			
			$email = $this->input->post('username');
			
			if($this->app->is_real_user($email)){
				
				$sess = array(
					'email' => $email,
					'is_logged_in' => TRUE
				);
				
				$this->session->set_userdata($sess);
				
				redirect(site_url());
				
			}else{
				$this->session->set_flashdata('wrong','Wrong username or password');
			}
			
		}
	}
	
	function logout(){
		$data = array(
					'email' => '',
					'group' => '',
					'is_logged_in' => FALSE
				);
		$this->session->unset_userdata($data);
		$this->session->sess_destroy();
		redirect(site_url());
	}
}