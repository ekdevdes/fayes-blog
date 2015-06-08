<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  search  extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('ek');
		$this->load->model('app_model','app');
	}

	function index()
	{
		$data['name'] = 'search';
		unset($_GET['search']);
		if(array_key_exists('q',$_GET)){
			$data['posts'] = $this->app->search_blog($_GET['q']);
		}else{
			$data['posts'] = array();
		}
		
		$this->load->view('templates/main', $data);
		
		
		/* 
		<?php if($this->session->userdata('is_logged_in')): ?>
		<div class="search-form">
			<form method="get" action="<?=site_url('index.php/search/fix')?>">
			<?=form_input('search','serd')?>
			<?=form_submit('submit','Search')?>
			</form>
		</div>
		<?php endif; ?>
		*/
	}
	
	function fix(){
		$search = $_GET['q'];
		redirect(site_url('index.php/search?q='.urlencode($search)));
	}
}