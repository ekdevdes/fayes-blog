<?php

if (!empty($post)) {
	if(array_key_exists('id',$post)){
		$this->app->updateViews($post['id']);	
	}
}

?>

<script>

	if(location.href == "<?=site_url('index.php/post/'.$post['slug'])?>"){
		$('.comment-errors').remove();
		$('#comment-form form .errors').remove();
	}

</script>

<style>
	p.small{
		color:#025d8c;
		font-size:30px;
		font-weight:normal;
	}
</style>

<?php if(!empty($post)): ?>

	<?php if($this->session->flashdata('success')): ?>
		<div class='success-wrapper new'>
			<div class="success">
				<p><?=$this->session->flashdata('success')?></p>
			</div>
		</div>
	<?php endif; ?>

	<div class="posts single">
		<?php

		$numComments = $this->app->count_comments($post['id']);
		$is_commentable = $this->app->is_commentable($post['id']);
		$date = blogDate($post['date_created']);
		$next = $post['id'] + 1;
		$prev = $post['id'] - 1;
		$nextSlug = $this->app->get_slug_by_id($next);
		$prevSlug = $this->app->get_slug_by_id($prev);
		$comments = $this->app->get_comments_by_post($post['id']);
		$tags = $this->app->get_all_post_tags($post['id']);
		$ta = array();
		$numcommas = count($tags) - 1;
		$tags_string = '';
		foreach($tags as $tag){
			array_push($ta,ucfirst($tag['name']));
		}
		
		for($i=0; $i < count($tags); $i++){
			$tags_string .= '<a href="'.site_url('index.php/tags/'.$tags[$i]['slug']).'">'.$ta[$i].'</a> ';
			if($numcommas > 0){
				$tags_string .= ",";
			}
			
			$numcommas --;
		}
		
		echo '
			<div class="blog-post">
				<br />
				<div class="post-date grid_3 alpha">
					<span class="date">Posted on <a href="'.site_url('index.php/post/'.$post['slug']).'"> '.$date[1].' '.$date[2].' '.$date[0].' </a></span>
				</div>';
				
				if($post['id'] == 1){
					echo '<div class="move prefix_10 grid_3 omega">
						<a href="'.site_url('index.php/post/'.$nextSlug).'"><span class="next"><span>Next Post&nbsp;&nbsp;&rarr; </span></span></a>
					</div>';
				}else if($post['id'] > 1 && $post['id'] < $max){
					echo '<div class="move prefix_8 grid_5 omega">
						<a href="'.site_url('index.php/post/'.$nextSlug).'"><span class="next">&larr; <span>Next Post&nbsp;&nbsp;</span></span></a>
						<a href="'.site_url('index.php/post/'.$prevSlug).'"><span class="previous"><span>Previous Post</span> &rarr;</span>
					</div>';
				}else if($post['id'] == $max){
					echo '<div class="move prefix_9 grid_4 omega">
						<a href="'.site_url('index.php/post/'.$prevSlug).'">&larr; <span class="previous"><span>Previous Post&nbsp;&nbsp;</span></span>
					</div>';
				}
				
				echo '<br />
				<br />
				<a href="'.site_url('index.php/post/'.$post['slug']).'"><h2 class="post-name">'.$post['title'].'</h1></a>';
				
				//<span class="read">'.$post['views'].' people read this</span>
				if($post['views'] == 0 || $post['views'] >= 2){
					
					if($this->session->userdata('is_logged_in')){
						echo '<span class="read">'.$post['views'].' people read this | <a href="'.site_url('index.php/edit/'.$post['slug']).'" class="edit"> Edit this post </a></span>';
					}else{
						echo '<span class="read">'.$post['views'].' people read this</span>';
					}
					
				}else if($post['views'] == 1){
					if($this->session->userdata('is_logged_in')){
						echo '<span class="read">'.$post['views'].' person read this | <a href="'.site_url('index.php/edit/'.$post['slug']).'" class="edit"> Edit this post </a></span>';
					}else{
						echo '<span class="read">'.$post['views'].' person read this</span>';
					}
				}
				
				echo '<br />
				<br />
				<p class="blog-text">
				'.$post['body'].'
				</p>';
				
				 if(!empty($tags)){
					echo '<br /><span class="post-meta"> This entry was posted in '.$tags_string.' . Bookmark the <a href="'.current_url().'">Permalink</a>.</span>';
				}else{
					echo '<br /><span class="post-meta">Bookmark the <a href="'.current_url().'">Permalink</a>.</span>';
				}
				
				
				if($numComments >= 1){
					
					if($numComments == 1){
						echo "<h3 class='tags leave numc' data-num='".$numComments."'>".$numComments." Comment </h3>";
					}else{
						echo "<h3 class='tags leave numc' data-num='".$numComments."'>".$numComments." Comments</h3>";
					}
					
					echo "<div class='comments' id='the-comments'>";
					
					foreach($comments as $comment){
						if($comment['parent_id'] == ''){
							echo '<div class="single-comment" id="'.$comment['unique_id'].'">';
							if($comment['website'] != ''){
								echo '<p><a href="'.$comment['website'].'">'.$comment['name'].'</a> '.time_ago($comment['date_created']).' Said:</p>';
							}else{
								echo '<p> '.$comment['name'].' '.time_ago($comment['date_created']).' Said: </p>';
							}
							echo '<br />';

							if($comment['is_approved'] == 0){
								echo '<span class="read single-comment parent">Your comment is awaiting moderation</span>';
							}
							
							echo '<p class="parent">'.$comment['comment'].'</p>';
							
							if($this->session->userdata('is_logged_in')){
								echo '<a href="#" data-id="'.$comment['id'].'" class="delete">  Delete</a>';
							}
							
							if($this->app->has_child_comments($comment['id'])){
								$children = $this->app->has_child_comments($comment['id']);
								
								echo '<div class="children">';
								
									foreach($children as $child){
										echo '<div>';
										
										if($child['website'] != ''){
											if($comment['website'] != ''){
												//both child and parent have a website
												
												echo '<p class="child-meta"><a href="'.$child['website'].'">'.$child['name'].'</a> in reply to <a href="'.$comment['website'].'">'.$comment['name'].'</a> '.time_ago($child['date_created']).' Said: </p>';
												
											}else{
												echo '<p class="child-meta"><a href="'.$child['website'].'">'.$child['name'].'</a> in reply to '.$comment['name'].' '.time_ago($child['date_created']).' Said: </p>';
											}
										}else{
											
											if($comment['website'] != ''){
												echo '<p class="child-meta">'.$child['name'].' in reply to <a href="'.$comment['website'].'">'.$comment['name'].'</a> '.time_ago($child['date_created']).' Said: </p>';
											}else{
												echo '<p class="child-meta">'.$child['name'].' in reply to '.$comment['name'].' '.time_ago($child['date_created']).' Said: </p>';
											}
											
										}
										
										if($child['is_approved'] == 0){
											echo '<span class="read single-comment">Your comment is awaiting moderation</span>';
										}
										
										echo '<p class="child-comment">'.$child['comment'].'</p>';
										echo '</div>';
										
									}
								
								echo '</div>';
								
							}
							
							
							echo '</div>';
						}
					}
					
					echo '</div>';
				}
				
				echo '<span class="put-in"></span>';
				
				if($is_commentable){
					
					echo "<br /><br />";
					
					echo "<div class='comment-form' id='comment-form'> <h3 class='tags leave leave-comment'>Leave a Comment</h3><h3 class='tags leave reply'>Leave a reply</h3><br /><span class='read comment'>Your email address will not be published.</span>";
					
					if(isset($errors)){
						if($errors){
							echo '<div class="comment-errors">
							'.validation_errors().$this->session->flashdata('noname').$this->session->flashdata('noemail').$this->session->flashdata('nocomment').'
							</div>';
						}
					}
					
					echo form_open('index.php/add/comment');
					echo form_input('name','Name (required)','onClick="this.value = \'\'"');
					echo form_input('mess','Email (required)','onClick="this.value = \'\'"');
					echo form_input('website','Website (optional)','onClick="this.value = \'\'"');
					echo form_textarea('comment','Comment (required)','class="comm-text"');
					echo form_hidden('slug',$post['slug']);
					echo form_submit('submit','Post Comment','class="submitComment"');
					echo '<a href="#" class="no-reply">Post Reply</a>';
					echo form_close();
					
					echo '</div>';
				}else{
					echo "<br /><div class='success-wrapper comments'>
						<div class=\"success\">
							<p> Faye Doman has closed comments on this post </p>
						</div>
					</div>";
				}
				
				echo '</div>';
				
				echo "<br /><div class='success-wrapper comments thanks hidden'>
					<div class=\"success\">
						<p> Adding Reply... </p>
					</div>
				</div>";

		?>
	</div>

<?php else: ?>

		<div class="no-posts">
			<p class="empty"> That post no longer exists.</p>
			<br />
			<p class="small">Redirecting you back to the home page...</p>
		</div>

		<script>
			function redirect(){
				window.location = "<?=site_url()?>";
			}

			setTimeout(redirect(),3500);
		</script>

<?php endif; ?>
<script>

	if(location.href == "<?=site_url('index.php/post/'.$post['slug'])?>"){
		var height = $('.body').height();
		$('.body').attr("data-height",height - 20);
		$('.blog-post').css({
			borderBottom:"none"
		});
		
	
	}

</script>