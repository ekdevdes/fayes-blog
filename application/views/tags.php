	<?php 
	
	if(isset($tags)){
		if(!empty($tags)){
			echo '<h1 class="tags">Tags</h1>';
			if(count($tags) == 1){
				echo '<ul class="tag-list one">';
				foreach($tags as $tag){
					echo '
					<li>
						<a href="'.site_url('index.php/tags/'.$tag['slug']).'"> '.ucfirst($tag['name']).' </a>
					</li>
					';
				}
			}else{
				echo '<ul class="tag-list">';
				foreach($tags as $tag){
					echo '
					<li>
						<a href="'.site_url('index.php/tags/'.$tag['slug']).'"> '.$tag['name'].' </a>
					</li>
					';
				}
			}
		}else{
			echo '
			<div class="no-posts">
				<p class="empty"> No tags yet.</p>
			</div>
			';
		}
	}
	
	?>
	
</ul>