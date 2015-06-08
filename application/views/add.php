<div class="add-new-post">
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
		<form method="post" action="<?=site_url('index.php/add/create')?>">
		<?=form_input('title','Title','onClick="this.value = \'\'"')?>
		<br />
		<?=form_textarea('body','Body','onClick="this.value = \'\'"')?>
		<br />
		<?=form_input('lists','Type tag name(s) here',"class='list'")?>
		<br />
		<?=form_label('Allow comments on this post?','isComment')?>&nbsp;&nbsp;&nbsp;
		<?=form_checkbox('isComment',1,TRUE)?>
		<br />
		<br />
		<?=form_submit('submit','Publish Post')?>
		</form>
    </div>
</div>