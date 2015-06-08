<?php

class Email extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('app_model','app');
	}

   function index(){
		$body = $_POST['plain'];
		$subject = $_POST['subject'];
		$subject_a = explode("::", $subject);
		$title = $subject_a[0];
		$tags = explode(',',$subject_a[1]);
	
		$this->app->create_from_email($title,$tags,$body);
   }
	
}