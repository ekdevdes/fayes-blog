<div class="login">
	<div class="login-form">
		<?php if(isset($errors)):?>
		<?php if($errors): ?>
			<div class="errors">
				<?=validation_errors()?>
				<?=$this->session->flashdata('wrong')?>
			</div>
		<?php endif;?>
		<?php endif; ?>

		<?=form_open('index.php/login/check')?>
		<?=form_input('username','Email Address','onClick="this.value = \'\'"')?>
		<br />
		<?=form_password('pw','Password','onClick="this.value = \'\'"')?>
		<br />
		<?=form_submit('submit','Log in')?>
		<?=form_close()?>
	</div>
</div>