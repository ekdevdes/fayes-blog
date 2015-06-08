<?php

if ($this->agent->is_browser('Firefox')){
	$class = 'ff';
}else{
	$class = NULL;
}

if($this->agent->is_browser('Safari') || $this->agent->is_browser('Chrome')){
	$web="webkit";
}else{
	$web=NULL;
}

?>
<!DOCTYPE html>  

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="<?=$class?><?=$web?>"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="<?=site_url('stylesheets/stylesheet.css')?>" />
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<link rel="stylesheet" type="text/css" href="http://fayesblog.com/stylesheets/nav.min.css" />
<![endif]-->


  	<?php
  	
		if($name == 'add'){
			echo '<title> Add a new blog post | Faye\'s Blog</title>';
		}else if($name == 'home'){
			echo '<title> Welcome to Faye\'s Blog</title>';
		}else if($name == 'login'){
			echo '<title> Log In | Faye\'s Blog</title>';
		}else if($name == 'post'){
			if(isset($post)){
				if(!empty($post)){
					echo '<title> '.$post['title'].' | Faye\'s Blog </title>';
				}else{
					echo '<title> That post no longer exists |Faye\'s Blog </title>';
				}
			}else{
				echo '<title> Blog Title | Faye\'s Blog </title>';
			}
		}else if($name == 'moderate'){
			echo '<title>Moderate Comments | Faye\'s Blog</title>';
		}else if($name == 'tags'){
			echo '<title> Tags | Faye\'s Blog</title>';
		}else if($name == 'forgot'){
			echo '<title>Reset your password | Faye\'s Blog</title>';
		}else if($name == 'reset'){
			echo '<title> Reset your password | Faye\'s Blog </title>';
		}else if($name == 'search'){
			if(isset($term)){
				echo '<title> Search Results for "'.$term.'" | Faye\'s Blog </title>';
			}else{
				echo '<title> Search Results | Faye\'s Blog </title>';
			}
		}else if($name == 'tag_posts'){
			if($tag_info['name'] == ''){
				echo '<title> No posts with that tag | Faye\'s Blog </title>';
			}else{
				echo '<title> All posts tagged "'.$tag_info['name'],'" | Faye\'s Blog </title>';
			}
		}else if($name == 'edit'){
			if(isset($post)){
				if(!empty($post)){
					echo '<title> Edit "'.$post['title'].'" | Faye\'s Blog </title>';
				}else{
					echo '<title> That post no longer exists | Faye\'s Blog </title>';
				}
			}else{
				echo '<title> Edit a post | Faye\'s Blog </title>';
			}
		}
		
		
		if ($name == 'tags') {
			$tagclass = "tags";
		}else{
			$tagclass = NULL;
		}

  	?>

	<link rel="stylesheet" type="text/css" href="<?=site_url('stylesheets/960_16_col.css')?>" />
	<link rel="stylesheet" type="text/css" href="<?=site_url('stylesheets/text.min.css')?>" />
	<link rel="stylesheet" type="text/css" href="<?=site_url('stylesheets/autoSuggest.css')?>?v=2">
	<link rel="stylesheet" type="text/css" href="<?=site_url('stylesheets/screen.min.css')?>" />
	  <!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
	window.__insp = window.__insp || [];
	__insp.push(['wid', 280246579]);
	(function() {
		function __ldinsp(){var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); }
		if (window.attachEvent){
			window.attachEvent('onload', __ldinsp);
		}else{
			window.addEventListener('load', __ldinsp, false);
		}
	})();
</script>
<!-- End Inspectlet Embed Code -->

</head>

<body>


  <div class="container_16" id="wrapper">
      <header class="grid_16">
      	<div class="logo grid_8 alpha">
      		<a href="<?=site_url()?>">
				<img src="<?=site_url('img/logo.png')?>" alt="Welcome to Faye Doman's Blog" />
			</a>
      	</div>
      	<div class="butterflies prefix_4 grid_4 omega">
      		<img src="<?=site_url('img/butterflies.png')?>" alt="Butterflies" />
      	</div>
      </header>
	  	<div class="nav grid_16">
			<?php if($this->session->userdata('is_logged_in')): ?>
				
				<nav>
				    <ul class="auth" style="margin-left:75px;">
					
						<?php if($name == 'home'): ?>
							
							<li class="home">
					            <a href="<?=site_url()?>" class="selected">Home</a>
					        </li>
							
						<?php else: ?>
					
				        <li class="home">
				            <a href="<?=site_url()?>">Home</a>
				        </li>
				
						<?php endif; ?>
						
						<?php if($name == 'tags'): ?>
							<li>
					            <a href="<?=site_url('index.php/tags')?>" class="selected">Tags</a>
					        </li>
						<?php else: ?>
						
				        <li>
				            <a href="<?=site_url('index.php/tags')?>">Tags</a>
				        </li>
				
						<?php endif; ?>
						
						<li>
				            <a href="<?=site_url('index.php/login/logout')?>">Log Out</a>
				        </li>
						
						<?php if($name == 'add'): ?>
							
							<li>
					            <a href="<?=site_url('index.php/add')?>" class="selected">Add new post</a>
					        </li>
					
						<?php else: ?>
					
						<li>
				            <a href="<?=site_url('index.php/add')?>">Add new post</a>
				        </li>
				
						<?php endif; ?>
						
						<?php if($name == 'moderate'): ?>
							
							<li>
					            <a href="<?=site_url('index.php/moderate')?>" class="selected">Moderate</a>
					        </li>
							
						<?php else: ?>
				
						<li>
				            <a href="<?=site_url('index.php/moderate')?>">Moderate</a>
				        </li>
				
						<?php endif;?>
					

						<?php if($name == 'search'): ?>
							<li>
								<a href="<?=site_url('index.php/search')?>" class="selected">Search</a>
							</li>
						<?php else: ?>

						<li>
							<a href="<?=site_url('index.php/search')?>">Search</a>
						</li>

						<?php endif; ?>
				    </ul>
				</nav>
				<?php if($this->agent->is_browser('Internet Explorer')): ?>
					
				<?php else: ?>
					<br />
					<br />
					<br />
					<br />
				<?php endif; ?>
			<?php else: ?>

				
				<nav>
				    <ul class="no-log">
					
						<?php if($name == 'home'): ?>
							
							<li class="home">
					            <a href="<?=site_url()?>" class="selected">Home</a>
					        </li>
							
						<?php else: ?>
					
				        <li class="home">
				            <a href="<?=site_url()?>">Home</a>
				        </li>
				
						<?php endif; ?>
				
						<?php if($name == 'tags'): ?>

							<li>
					            <a href="<?=site_url('index.php/tags')?>" class="selected">Tags</a>
					        </li>
						<?php else: ?>
				
				        <li>
				            <a href="<?=site_url('index.php/tags')?>">Tags</a>
				        </li>
				
						<?php endif; ?>
						
						<?php if($name == 'login'): ?>
							
							<li>
					            <a href="<?=site_url('index.php/login')?>" class="selected">Log in</a>
					        </li>
							
						<?php else: ?>
					
				        <li>
				            <a href="<?=site_url('index.php/login')?>">Login</a>
				        </li>
						
						<?php endif; ?>
					
					 	<li class="search">
					 		<?php
					 		
								$search = array(
									'class' => 'search',
									'name' => 'q',
									'value' => 'Search... ',
									'onclick' => "this.value = ''"
								);
								
								$submit = array(
									'class' => 'start-search',
									'name' => 'search',
									'value' => "Search"
								);
					
					 		?>
							
							<form method="get" action="<?=site_url('index.php/search/fix')?>">
							<?=form_input($search)?>
							<?=form_submit($submit)?>
							</form>
					 	</li>
				    </ul>
				</nav>
				
			<?php endif; ?>
		</div>
	
      <div class="<?=$tagclass?> body grid_16">
      	<?php
    
  		$this->load->view($name);
	
      	?>
      </div>
	  <?php  $single = ($name == 'post') ? "single" : NULL; ?>
      <footer class="grid_16 <?=$single?>">
      	<p>&copy; <?=date("Y")?> <a href="http://ek.alphaschildren.org/">Ethan Kramer</a>. All Rights Reserved.</p>
      </footer>
  </div>
<script src="http://code.jquery.com/jquery-1.6b1.js" type="text/javascript"></script>
<!--[if (gte IE 6)&(lte IE 8)]>
  <script type="text/javascript" src="selectivizr.js"></script>
<![endif]-->
<script src="<?=site_url('js/jquery.autoSuggest.minified.js')?>"></script>
<script src="<?=site_url('js/scripts.js')?>"></script>
  <script>
   var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
  </script>
  
</body>
</html>