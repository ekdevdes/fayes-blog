<div class='success-wrapper new delete-message'>
	<div class="success">
		<p>The comment will be accepted</p>
	</div>
</div>
<div class='success-wrapper new success-message'>
	<div class="success">
		<p>The comment has been deleted</p>
	</div>
</div>


<!--- Comments -->
<?php

if(!empty($comments)){
	echo '<div class="accepts">';
	
	foreach($comments as $comment){
		if($comment['parent_id'] == ''){
			//its a comment

			$post = $this->app->get_post_by_id($comment['post_id']);


			echo '<div class="comment-to-be-approved" id="'.$comment['unique_id'].'">';

			if($comment['website'] != ''){
				echo '<p class="meta"><a href="'.$comment['website'].'">'.$comment['name'].'</a>'.time_ago($comment['date_created']).', On "'.$post['title'].'" Said: </p>';
			}else{
				echo '<p>'.$comment['name'].' '.time_ago($comment['date_created']).', On "'.$post['title'].'" Said: </p>';
			}

			echo '

			<br />
			<p class="parent">'.$comment['comment'].'</p>
			<br />
			<a class="accept-button" href="'.site_url('index.php/comments/accept/'.$comment['id'].'?slug='.urlencode($post['slug']).'&identifier='.urlencode($comment['unique_id'])).'">Accept</a>
			<a class="decline-button" href="'.site_url('index.php/delete/'.$comment['id']).'">Decline</a><br /><br /><br />';

			echo '</div>';


		}else if($comment['parent_id'] != ''){
			//its a reply to a comment
			$parent = $this->app->get_parent_comment_info($comment['parent_id']);
			$post = $this->app->get_post_by_id($comment['post_id']);

			echo '<div class="comment-to-be-approved" id="'.$comment['unique_id'].'">';

			if($comment['website'] != ''){
				if($parent['website'] != ''){
					//both child and parent have a website

					echo '<p class="child-meta"><a href="'.$comment['website'].'">'.$comment['name'].'</a> in reply to <a href="'.$parent['website'].'">'.$parent['name'].'</a> '.time_ago($comment['date_created']).', On "'.$post['title'].'" Said: </p>';

				}else{
					echo '<p class="child-meta"><a href="'.$comment['website'].'">'.$parent['name'].'</a> in reply to '.$parent['name'].' '.time_ago($comment['date_created']).', On "'.$post['title'].'" Said: </p>';
				}
			}else{

				if($parent['website'] != ''){
					echo '<p class="child-meta">'.$comment['name'].' in reply to <a href="'.$parent['website'].'">'.$parent['name'].'</a> '.time_ago($comment['date_created']).', On "'.$post['title'].'" Said: </p>';
				}else{
					echo '<p class="child-meta">'.$comment['name'].' in reply to '.$parent['name'].' '.time_ago($comment['date_created']).' Said: </p>';
				}

			}

			//slug of post
			//comment identifier

			echo '<p class="child-comment">'.$comment['comment'].'</p><br />
					<a class="accept-button" href="'.site_url('index.php/comments/accept/'.$comment['id'].'?is_rep=1&slug='.urlencode($post['slug']).'&identifier='.urlencode($comment['unique_id'])).'">Accept</a>
				<a class="decline-button" href="'.site_url('index.php/delete/'.$comment['id']).'">Decline</a>
				<br /><br /><br />
			';


			echo '</div>';


		}
		
	}
	
	echo '
	<div class="no-posts moderate">
		<p class="empty"> No comments to moderate.</p>
	</div>
	';
	
	echo '</div>';
}else{
	echo '
	<div class="no-posts moderate-no-hide">
		<p class="empty"> No comments to moderate.</p>
	</div>
	';
}

?>