<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('ek','typography', 'url'));
		$this->load->library('typography');
	}

	function get_all_posts(){
		
		$query = $this->db->order_by('date_order','desc')->get('posts');
		
		return $query->result_array();
		
	}
	
	function get_all_post_tags($id){
		$query = $this->db->where('post_id',$id)->group_by('name')->get('tags');
		
		return $query->result_array();
	}
	
	function get_all_posts_by_tag($tagslug){
		
		$query = $this->db->where('slug',$tagslug)->get('tags');
		
		$results = $query->result_array();
		
		$posts = array();
		
		foreach($results as $result){
			$q = $this->db->where('id',$result['post_id'])->group_by('title')->get('posts');
			
			$r = $q->result_array();
			
			if($q->num_rows() > 0){
				array_push($posts, $r[0]);
			}
		}
		
		return $posts;
		
	}
	
	function count_comments($id){
		$query = $this->db->where('post_id',$id)->get('comments');
		
		if($query->num_rows() > 0){
			$results = $query->result_array();
			
			return count($results);
		}else{
			return 0;
		}

	}
	
	function get_all_tags(){
		
		$query = $this->db->order_by('name','desc')->group_by('name')->get('tags');
		
		return $query->result_array();
		
	}
	
	function done_edit($slug, $post_id){
		
		$tags_string = $_POST['lists'];
		$tags_array = explode(',',$tags_string);
		
		//$new = array_filter($tags_array);
		
		if(isset($_POST['isComment'])){
			$i = array(
				'title' => $_POST['title'],
				'body' => $_POST['body'],
				'slug' => url_title(humanize($_POST['title'])),
				'is_commentable' => 1
			);
			
		}else{
			$i = array(
				'title' => $_POST['title'],
				'body' => $_POST['body'],
				'slug' => url_title(humanize($_POST['title'])),
				'is_commentable' => 0
			);
			
		}
		
		$this->db->where('id',$post_id)->update('posts',$i);
		
		$this->db->delete('tags',array('post_id' => $post_id));
		
		
		for($i = 0; $i < count($tags_array); $i++){
			if(isset($tags_array[$i]) && $tags_array[$i] != ""){
				$this->addList($tags_array[$i],$post_id);
			}
		}
		
	}
	
	function getPostIdBySlug($slug){
		$query = $this->db->where('slug',$slug)->limit(1)->get('posts');
		
		$results = $query->result_array();
		
		if($query->num_rows() >= 1){
			$result = $results[0];
			
			return $result['id'];
		}else{
			return array();
		}
		
		
	}
	
	function get_slug_by_id($id){
		$q = $this->db->where('id',$id)->limit(1)->get('posts');
		
		if($q->num_rows() > 0){
			$results = $q->result_array();
			$result = $results[0];
			
			return $result['slug'];
		}
	}
	
	function get_tag_info($slug){
		
		$query = $this->db->where('slug',$slug)->limit(1)->get('tags');
		
		$result = $query->result_array();
		
		if($query->num_rows() > 0){
			return $result[0];
		}else{
			return array('name' => '');
		}
		
	}
	
	function search_blog($term){
	
		$query = $this->db->like('title', $term, 'left')->or_like('title', $term, 'right')->or_like('title',$term, 'match')->or_like('body', $term, 'left')->or_like('body', $term, 'right')->or_like('body',$term,'match')->get('posts');
		
		return $query->result_array();
	
	}
	
	function updateViews($p_id){
			if(!$this->session->userdata('is_logged_in')){
				$this->db->query("update posts set views = (views + 1) where id = ". $p_id);
			}
	}
	
	function is_real_user($user){
			$query = $this->db->select('email_address')->where('email_address',$user)->get('users');

			if($query->num_rows() == 0){
				return false;
			}elseif($query->num_rows() >= 1){
				return true;
			}
	}
	
	function is_commentable($id){
		$q = $this->db->where('id',$id)->limit(1)->get('posts');
		
		if($q->num_rows() > 0){
			$results = $q->result_array();
			$result = $results[0];
			
			if($result['is_commentable'] == 0){
				return false;
			}else if($result['is_commentable'] == 1){
				return true;
			}
		}
	}
	
	function has_child_comments($id){
		$q = $this->db->where('parent_id',$id)->get('comments');
		
		if($q->num_rows() > 0){
			return $q->result_array();
		}else{
			return false;
		}
		
	}
	
	function get_comments_by_post($id){
		
		$query = $this->db->where('post_id',$id)->get('comments');
		
		return $query->result_array();
		
	}
	
	function is_post($id){
		
		$query = $this->db->where('id',$id)->get('posts');
		
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
		
	}
	
	function get_max_ids(){
		
		$q = $this->db->select('id')->get('posts');
		$ids = array();
		
		if($q->num_rows() > 0){
			
			$results = $q->result_array();
			
			foreach($results as $result){
				array_push($ids, $result['id']);
			}
			
			return max($ids);
		}
		
	}
	
	function is_post_by_title($title){
		
		$query = $this->db->where('title',$title)->get('posts');
		
		if($q->num_rows() > 0){
			return true;
		}else{
			return false;
		}
		
	}
	
	function get_post($slug){
		
		$query = $this->db->where('slug', $slug)->get('posts');
		
		$results = $query->result_array();
		
		if($query->num_rows() > 0){
			return $results[0];
		}
		
	}
	
	function get_post_by_id($id){
		$query = $this->db->where('id',$id)->get('posts');
		
		if($query->num_rows() > 0){
			$results = $query->result_array();
			
			return $results[0];
		}
	}
	
	function send_comment_email($info, $slug){
		
		$postinfo = $this->get_post($slug);
		
		//$info is an array of post data
		
		$config['useragent'] = 'Faye Doman\'s Blog';
		$config['smtp_host'] = 'smtp.fayesblog.com';
		$config['stmp_user'] = 'info@fayesblog.com';
		$config['smtp_pass'] = 'a3d59e185b';

		$this->load->library('email');

		$this->email->initialize($config);

		$this->email->from($config['stmp_user'], 'Your Blog');
		$this->email->to("ethankr@comcast.net");

		$this->email->subject($info['name']. " Just commented on ' ". $postinfo['title']." '");
		$this->email->message("

			".$info['name']." just commented on your article ".$postinfo['title']."

			They said:

			".$info['comment']."

		");	

		$this->email->send();
	}
	
	function send_reply_email($info, $slug, $reply){
		
			//$reply is an array with the name of the parent commenter and the email of the parent commenter
			//$info is an array of post data
			
			/*
			Hey ekramer,

			Your Reply To ekramer's Comment on ekramer's Article Has Been Accepted!

			Your Reply:

			@LKramer your are welcome!

			View The Comment You Replied To: http://alphaschildren.org/alphas_children/blog/posts/A-Few-New-Things-And-An-Old-One#comment-4dee8eac4ad47 
			Read The Post You Commented On: http://alphaschildren.org/alphas_children/blog/posts/A-Few-New-Things-And-An-Old-One
			Love,
			Alpha Children's Home
			
			*/
		
			$postinfo = $this->get_post($slug);
		
			$config['useragent'] = 'Faye Doman\'s Blog';
			$config['smtp_host'] = 'smtp.fayesblog.com';
			$config['stmp_user'] = 'info@fayesblog.com';
			$config['smtp_pass'] = 'a3d59e185b';

			$this->load->library('email');

			$this->email->initialize($config);

			$this->email->from($config['stmp_user'], 'Faye Doman\'s Blog');
			$this->email->to($reply['email']);

			$this->email->subject($info['name']. " Just replied to ".$reply['name']."'s comment on ' ". $postinfo['name']." '");
			$this->email->message("

				Hey ".$reply['name'].",

				".$info['name']." just replied to your comment on ".$postinfo['name']."

				They said:

				".$info['comment']."
 
				Read the post they commented on: ".site_url('index.php/post/'.$slug)."
				View the comment they replied to: ".site_url('index.php/post/'.$slug."#comment-".$reply['identifier'])."
				
			
			");	

			$this->email->send();
		
		
	}
	
	
	function get_comment_info_by_id($id){
		$q = $this->db->where('id',$id)->limit(1)->get('comments');
		
		if($q->num_rows() > 0){
			$results = $q->result_array();
			
			return $results[0];
		}
		
	}
	
	function accept_comment($id, $is_rep, $slug){
		//send email
		//set is_accepted to 1
		
		/* 
		Hey ekramer,

		Your Reply To ekramer's Comment on ekramer's Article Has Been Accepted!

		Your Reply:

		@LKramer your are welcome!

		View The Comment You Replied To: http://alphaschildren.org/alphas_children/blog/posts/A-Few-New-Things-And-An-Old-One#comment-4dee8eac4ad47 
		Read The Post You Commented On: http://alphaschildren.org/alphas_children/blog/posts/A-Few-New-Things-And-An-Old-One
		Love,
		Alpha Children's Home
		
		*/
		
		//$this->db->where('id',$id)->update('comments',array('is_approved' => 1));
		
		/*if($is_rep){
			$reply = array(
				'name' => $_POST['irn'],
				'email' => urldecode($_POST['ire'])
			);
			
			$info = array(
				'name' => $_POST['name'],
				'comment' => $_POST['commment'] 
			);
			
			$this->send_reply_email($info, $_POST['slug'], $reply);
		}
		
		*/
		$this->db->where('id',$id)->update('comments',array('is_approved' => 1));
		
		$commentInfo = $this->get_comment_info_by_id($id);
		if($is_rep == "1"){
			$parent = $this->get_comment_info_by_id($commentInfo['parent_id']);
			
			$reply = array(
				'name' => $parent['name'],
				'email' => $parent['email'],
				'identifier' => $parent['unique_id']
			);
		}
		
		$info = array(
			'name' => $commentInfo['name'],
			'comment' => $commentInfo['comment']
		);
		
		$this->send_reply_email($info,$slug,$reply);

		
	}
	
	function addReply($name,$email,$website,$body,$slug,$replyto_id){
	
		$id = $this->getPostIdBySlug($slug);
	
		$reply = array(
			'name' => $_POST['name'],
			'email' => $_POST['mess'],
			'website' => $_POST['website'],
			'comment' => $_POST['comment'],
			'post_id' => $id,
			'parent_id' => $replyto_id
		);
		
		$this->db->insert('comments',$reply);
		
	}
	
	function delete_comment($id){
		$this->db->delete('comments',array('id',$id));
	}
	
	function add_comment($name,$email,$website,$body,$slug){
		
		//$id parameter is the parent_id needed for replies
		//just about everything else is for regular commenting
		
		$post_id = $this->getPostIdBySlug($slug);
		
		$cid = uniqid();
		
		$comment = array(
			'name' => $_POST['name'],
			'email' => $_POST['mess'],
			'website' => $_POST['website'],
			'comment' => auto_link($_POST['comment']),
			'post_id' => intVal($post_id),
			'unique_id' => $cid
		);
		
		$this->db->insert('comments',$comment);
		
		$info = array(
			'name' => $_POST['name'],
			'email' => $_POST['mess'],
			'website' => $_POST['website'],
			'comment' => auto_link($_POST['comment']),
		);
		
		$this->send_comment_email($info,$slug);
		
	}
	
	function get_all_comments_by_post($slug){
		$id = $this->getPostIdBySlug($slug);
		
		$query = $this->db->where('post_id',$id)->get('comments');
		
		return $query->result_array();
	}
	
	function get_all_comments_to_be_moderated(){
		
		$query = $this->db->where('is_approved',0)->get('comments');
		
		return $query->result_array();
		
	}
	
	function get_parent_comment_info($id){
		$query = $this->db->where('id',$id)->limit(1)->get('comments');
		
		
		if($query->num_rows() > 0 ){
			$results = $query->result_array();
			
			return $results[0];
		}
		
	}
	
	function addList($name, $post_id = NULL){
		$array = array(
			'name' => $name,
			'post_id' => $post_id,
			'slug' => url_title(humanize($name))
		);
		
		$this->db->insert('tags', $array);
	}
	
	function exisitingPost($title){
		$slug = url_title(humanize($title));
		$query = $this->db->get_where('posts',array("title" => $title));
		
		if($query->num_rows() >= 1){
			return true;
		}
	}
	
	function getPostId($title){
		$query = $this->db->get_where('posts',array('title' => $title));
		if($query->num_rows() != 0){
			$result = $query->result_array();
			$results = $result[0]['id'];
			
			return $results;
		}
	}
	
	function add_post($comments,$cats){
		
		$title = $_POST['title'];
		
		if(!$this->exisitingPost($title)){
			
			if($comments == 1){
				$data = array(
					'title' => $_POST['title'],
					'body' => nl2br_except_pre(auto_link($_POST['body'])),
					'slug' => url_title(humanize($title)),
					'date_created' => date("Y-m-d"),
					'is_commentable' => 1

				);
			}else if($comments == 0){
				$data = array(
					'title' => $_POST['title'],
					'body' => nl2br_except_pre(auto_link($_POST['body'])),
					'slug' => url_title(humanize($title)),
					'date_created' => date("Y-m-d"),
					'is_commentable' => 0	
				);
			}

			$this->db->insert('posts',$data);
			$postId = $this->getPostId($title);
			
			if(!empty($cats)){
				for($i = 0; $i < count($cats) - 1; $i++){
					$this->addList($cats[$i], $postId);
				}
			}
			
		}else{
			//for error validation
			return false;
		}
	}
	
	function do_stuff($slug){
		
		$id = $this->getPostIdBySlug($slug);
		
		return $id;
	}
	
	function create_from_email($title,$tags,$body){
		$this->db->insert('posts',array(
			'title' => $title,
			'body' => nl2br_except_pre(auto_link($body)),
			'slug' => url_title(humanize($title)),
			'date_created' => date('Y-m-d'),
			'is_commentable' => 1
		));
		
		$postId = $this->getPostId($title);
		
		if(!empty($tags)){
			for($i = 0; $i < count($tags) - 1; $i++){
				$this->addList($tags[$i], $postId);
			}
		}
	}
}