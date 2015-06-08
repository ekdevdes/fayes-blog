<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class add extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index()
	{
		$data['name'] = 'add';
		
		$this->load->view('templates/main', $data);
	}
	
	function create(){
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title','title','required|min_length[3]');
		$this->form_validation->set_rules('body','body','required|min_length[3]');
		$this->form_validation->set_message('required','A post %s is required');
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
				
				
				$data['name'] = 'add';
				$data['errors'] = TRUE;
				$this->load->view('templates/main', $data);
		}else{
			
			if($this->app->exisitingPost($_POST['title'])){
				
				$this->session->set_flashdata('wrong','A post with that title already exists');
				
				$data['name'] = 'add';
				$data['errors'] = TRUE;
				$this->load->view('templates/main', $data);
				
			}else{
				$tags = $_POST['lists'];

				$tags_array = explode(',',$tags);

				$comments = 0;

				if(array_key_exists('isComment',$_POST)){
					$comments = 1;
				}

				$this->app->add_post($comments,$tags_array);

				$this->session->set_flashdata('success','Post successfully created');

				redirect(site_url('index.php/post/'.url_title(humanize($_POST['title']))));
			}
			
		}
			
		}else{
			$data['name'] = 'add';
			$data['errors'] =  TRUE;
			$this->load->view('templates/main', $data);
		}
		
	}
	
	function comment(){
		
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
					
					$data['name'] = 'post';
					$data['post'] = $this->app->get_post($_POST['slug']);
					$data['max'] = $this->app->get_max_ids();
					$data['errors'] = TRUE;

					$this->load->view('templates/main', $data);
					
			}else{
				
				if($_POST['website'] == 'Website (optional)'){
					$_POST['website'] = '';
				}
				
				$this->app->add_comment($_POST['name'],$_POST['mess'],$_POST['website'],$_POST['comment'],$_POST['slug']);
				redirect(site_url('index.php/post/'.$_POST['slug']));	
			}

		}else{
			//failed
			$data['name'] = 'post';
			$data['post'] = $this->app->get_post($_POST['slug']);
			$data['max'] = $this->app->get_max_ids();
			$data['errors'] = TRUE;

			$this->load->view('templates/main', $data);
		}
		
	}
}