<div class="posts">
<?php
	
	$this->load->helper('text');
	
	if(!empty($posts) && $posts[0] != ''){
		echo '<h1 class="tags">All Posts tagged "'.urldecode(str_replace('-',' ',ucfirst($this->uri->segment(2)))).'"</h1>
		<br />';
		
		foreach($posts as $post){
			$date = blogDate($post['date_created']);
			$is_commentable = $this->app->is_commentable($post['id']);
			$numComments = $this->app->count_comments($post['id']);

			if($tag_info['post_id'] != ''){
				echo '
					<div class="blog-post">
						<a href="'.site_url('index.php/post/'.$post['slug']).'"><h2 class="post-name">'.$post['title'].'</h1></a>
						<br />
						<span class="date">Posted on <a href="'.site_url('index.php/post/'.$post['slug']).'"> '.$date[1].' '.$date[2].' '.$date[0].' </a></span>
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
					</div>
				';
			}else{
				echo '
				<div class="no-posts">
					<p class="empty"> No posts tagged "'.$tag_info['name'].'"</p>
				</div>
				';
			}

		}
	}else if(empty($posts) || $posts[0] == ''){
		if($tag_info['name'] == '' && $posts[0] == ''){
			echo '
			<div class="no-posts">
				<p class="empty"> No posts with that tag.</p>
			</div>
			';
		}else{
			echo '
			<div class="no-posts">
				<P class="empty"> No posts tagged "'.$tag_info['name'].'"</p>
			</div>
			';
		}
	}

?>
</div>