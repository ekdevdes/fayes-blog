<!-- 

$post['title'] = title
$post['body] = the body
$post['is_commentable'] = are comments allowed?

get post tags from app_model

 -->

<?php

$t = "";
$numc = count($tags) - 1;

//$tags is the array of tags

for($i = 0; $i < count($tags); $i++){
	
	$t .= $tags[$i]['name'];
	
	if($numc > 0){
		$t .= ', ';
	}
	
	$numc--;
	
}


?>

<div class="add-new-post edit" data-tags="<?=$t?>">
	<br />
	<h1 class="tags edit">Edit "<?=$post['title']?>"</h1>
	<br />
    <div class="new-post login-form">
    	<?php if(isset($errors)):?>
		<?php if($errors): ?>
			<div class="errors">
				<?=validation_errors()?>
				<?=$this->session->flashdata('wrong')?>
				<?=$this->session->flashdata('notitle')?>
				<?=$this->session->flashdata('nobody')?>
			</div>
		<?php endif;?>
		<?php endif; ?>

		<!-- And now for the form -->
		<form method="post" action="<?=site_url('index.php/save/'.$post['id'])?>">
		<?php
		
		echo form_input('title',$post['title']);
		
		?>
		
		<br />
		<?php
		
		echo form_textarea('body', $post['body']);
		
		?>
		<br />
		<?=form_input('lists','Type tag name(s) here',"class='list'")?>
		<br />
		<?=form_label('Allow comments on this post?','isComment')?>&nbsp;&nbsp;&nbsp;
		<?=form_hidden('slug',$post['slug'])?>
		<?php
		
		if($post['is_commentable'] == 0){
			echo form_checkbox('isComment',1,FALSE);
		}else if($post['is_commentable'] == 1){
			echo form_checkbox('isComment',1,TRUE);
		}
		
		?>
		<br />
		<br />
		<?=form_submit('submit','Save Changes')?>
		</form>
    </div>
</div>