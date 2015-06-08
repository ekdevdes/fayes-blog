<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  comments  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function accept(){
		$id = $this->uri->segment(3);
		
		if(array_key_exists('is_rep',$_GET)){
			if($_GET['is_rep'] == "1"){
				//its a reply
			
				$this->app->accept_comment($id,$_GET['is_rep'],urldecode($_GET['slug']));
			}
		}else{
			$this->app->accept_comment($id,"0",urldecode($_GET['slug']));
		}
	}
	
	function reply(){
		$id = $this->uri->segment(3);
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name','name','required|trim');
		$this->form_validation->set_rules('mess','email address','require|valid_email|trim');
		$this->form_validation->set_rules('comment','required|min_length[3]');
		$this->form_validation->set_message('required','You must provide your %s ');
		$this->form_validation->set_message('valid_email','You must provide a valid email address');
		$this->form_validation->set_message('min_length','Your comment must be at least 3 characters long');
		
		if($this->form_validation->run() != FALSE){
			
			if($_POST['name'] == 'Name (required)' || $_POST['mess'] == 'Email (required)' || $_POST['comment'] == 'Comment (required)'){
					if($_POST['name'] == 'Name (required)'){
						$_POST['name'] = '';
						$this->session->set_flashdata('noname','You must provide your name');
					}

					if($_POST['mess'] == 'Email (required)'){
						$_POST['mess'] == '';
						$this->session->set_flashdata('noemail','You must provide your email address');
					}

					if($_POST['comment'] == 'Comment (required)'){
						$_POST['comment'] == '';
						$this->session->set_flashdata('nocomment','You must provide a comment');

					}
					//since we are going to do this via ajax we should just echo out the errors
					//failed 
					echo '
					<div class="errors">
					'.validation_errors().'
					'.$this->session->flashdata('wrong').'
					'.$this->session->flashdata('notitle').'
					'.$this->session->flashdata('nobody').'
					</div>
					';
					
			}else{
				
				if($_POST['website'] == 'Website (optional)'){
					$_POST['website'] = '';
				}
				
				$this->app->addReply($_POST['name'],$_POST['mess'],$_POST['website'],$_POST['comment'],$_POST['slug'], $id);
					
			}

		}else{
			//since we are going to do this via ajax we should just echo out the errors
			//failed
			echo '
			<div class="errors">
			'.validation_errors().'
			'.$this->session->flashdata('wrong').'
			'.$this->session->flashdata('notitle').'
			'.$this->session->flashdata('nobody').'
			</div>
			';
		}
	}
	
}