<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  save  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
		$this->output->enable_profiler();
	}
	
	function index(){
		$this->load->library('form_validation');
		
		$post_id = $this->uri->segment(2);
		
		$this->form_validation->set_rules('title','title','min_length[3]');
		$this->form_validation->set_rules('body','body', 'min_length[3]');
		$this->form_validation->set_message('min_length','Your post %s must be at least 3 characters long');
		
		if($this->form_validation->run() != FALSE){
			
			if($_POST['title'] == 'Title' || $_POST['body'] == 'Body'){
					if($_POST['title'] == "Title"){
						$_POST['title'] == '';
						$this->session->set_flashdata('notitle','A post title is required');
					}

					if($_POST['body'] == 'Body'){
						$_POST['body'] == '';
						$this->session->set_flashdata('nobody','A post body is required');
					}
					
					//failed load view again
					$data['name'] = 'post';
					$data['post'] = $this->app->get_post($_POST['slug']);
					$data['max'] = $this->app->get_max_ids();
					$data['errors'] = TRUE;

					$this->load->view('templates/main', $data);
					
			}else{
				
				//succeeded
				
				$this->app->done_edit(url_title(humanize($_POST['title'])), $post_id);

				redirect(site_url('index.php/post/'.url_title(humanize($_POST['title']))));
				
			}

		}else{
			//failed load view again
			$data['name'] = 'post';
			$data['post'] = $this->app->get_post($_POST['slug']);
			$data['max'] = $this->app->get_max_ids();
			$data['errors'] = TRUE;

			$this->load->view('templates/main', $data);
		}
	}

}