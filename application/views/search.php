<?php 

if(array_key_exists('q', $_GET) && !empty($posts)){
	if ($this->session->userdata('is_logged_in')) {
		echo '<div class="search-form results">

			<form method="get" action="'.site_url('index.php/search/fix').'">
			'.form_input('q',urldecode($_GET['q']),'onClick="this.value = \'\'"').
			form_submit('search','Search')
			.'
			</form>
		</div>';
	}
}

?>
<div class="posts">
<?php
	
	$this->load->helper('text');
	
	if(!empty($posts)){
		
		foreach($posts as $post){
			$numComments = $this->app->count_comments($post['id']);
			$is_commentable = $this->app->is_commentable($post['id']);
			$date = blogDate($post['date_created']);

			echo '
				<div class="blog-post">
					<a href="'.site_url('index.php/post/'.$post['slug']).'"><h2 class="post-name">'.$post['title'].'</h1></a>
					<br />
					<span class="date">Posted on <a href="'.site_url('index.php/post/'.$post['slug']).'"> '.$date[1].' '.$date[2].' '.$date[0].'</a></span>
					<br />
					<p class="blog-text">
					'.word_limiter($post['body'], 100).'
					</p>
					<br />
					<br />';
					
				if($numComments != 0){
					if($numComments == 1){
						echo '<a class="meta" href="'.site_url('index.php/post/'.$post['slug']."#the-comments").'"> '.$numComments.' Comment </a>';
					}else{
						echo '<a class="meta" href="'.site_url('index.php/post/'.$post['slug']."#the-comments").'"> '.$numComments.' Comments </a>';
					}
				}else if($numComments == 0){
					echo '<a class="meta" href="'.site_url('index.php/post/'.$post['slug']."#comment-form").'"> '.$numComments.' Comments </a>';
				}
					
				if($post['views'] == 0 || $post['views'] >= 2){
					
					echo '<a class="meta" href="'.site_url('index.php/post/'.$post['slug']).'"> '.$post['views'].' people read this </a>';
					
				}else if($post['views'] == 1){
					echo '<a class="meta" href="'.site_url('index.php/post/'.$post['slug']).'"> '.$post['views'].' person read this </a>';
				}
					
				echo '
				
				<a href="'.site_url('index.php/post/'.$post['slug']).'" class="meta"> Read More... </a> 
				<br />
				<br />
				<br />
				</div>';

		}
	}else{
		if(array_key_exists('q',$_GET)){
			
			if($this->session->userdata('is_logged_in')){
				echo '
				<div class="no-posts">

				<div class="search-form">

					<form method="get" action="'.site_url('index.php/search/fix').'">
					'.form_input('q',urldecode($_GET['q']),'onClick="this.value = \'\'"').
					form_submit('search','Search')
					.'
					</form>
				</div>

					<p class="empty"> No search results. </p>
				</div>
				';
			}else{
				echo '
				<div class="no-posts">
					<p class="empty"> No search results.</p>
				</div>
				';
			}
			
		}else{
			echo '
			<div class="no-posts">';
			
			if($this->session->userdata('is_logged_in')){
				echo '
					<div class="search-form">

						<form method="get" action="'.site_url('index.php/search/fix').'">
						'.form_input('q','Search your blog...','onClick="this.value = \'\'"').
						form_submit('search','Search')
						.'
						</form>
					</div>
				';
			}
			
			echo '<p class="empty"> Search For Something...</p>
			</div>';
		}
	}

?>
</div>