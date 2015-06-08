$(function() {
  	$('.success-message').hide();
	$('.delete-message').hide();
	$('.moderate').hide();
	if($.browser.mozilla){
		var prefill = $('div.edit').data('tags');

		$("input[type=text].list").autoSuggest("http://www.fayesblog.com/index.php/lists", {selectedItemProp: "name", selectedValuesProp:"name", searchObjProps: "name", startText:'Tag Name(s)', emptyText:'Hey That\'s a New Tag! Good Job! <em>Press Comma to Add It.</em>',neverSubmit:true, preFill:prefill}).css({
			fontSize:'20px',
			width:'150px',
			paddingTop:'0px',
			paddingBottom:'1px',
			height: '25px'
		});
	}else{
		var prefill = $('div.edit').data('tags');

		$("input[type=text].list").autoSuggest("http://www.fayesblog.com/index.php/lists", {selectedItemProp: "name", selectedValuesProp:"name", searchObjProps: "name", startText:'Tag Name(s)', emptyText:'Hey That\'s a New Tag! Good Job! <em>Press Comma to Add It.</em>',neverSubmit:true,preFill:prefill}).css({
			fontSize:'20px',
			width:'150px',
			paddingTop:'0px',
			paddingBottom:'1px'
		});
	}

	$('.as-values').removeAttr('name').attr('name','lists');

	$('.success-wrapper.new').delay(5000).animate({opacity: 0.5}).slideUp();

	$('.delete').click(function(){
		var id = $(this).data('id');
		var url = "http://fayesblog.com/index.php/delete/" + id;

		$.ajax({
			type: 'GET',
			url: url
		});

		if($('.comments').children().length == 1){
			$('.comments').slideUp();
		}else if($('.comments').children().length > 1){
			$(this).parent().slideUp();
		} 

		var id = $(this).parent().attr("id");
	   	var numChildren = $(".single-comment#" + id + " .children").children().length;

		var newComments = 1 + parseInt(numChildren);
		var oldComments = $('h3.numc').data('num');
		var nc = parseInt(oldComments) - parseInt(newComments);
		console.log(nc);

		if(nc <= 0){
			$('h3.numc').fadeOut(function(){
				$(this).text('No Comments');
				$(this).fadeIn().delay(1300).animate({opacity:0.5}).slideUp();
				$('#the-comments').slideUp();
			});
		}else if(nc == 1){
			$('h3.numc').fadeOut(function(){
				$(this).text('1 Comment');
				$(this).fadeIn();
			});
		}else if(nc > 1){
			$('h3.numc').fadeOut(function(){
				$(this).text(nc + " Comments");
				$(this).fadeIn();
			});
		}


		return false;

	});

	$('.comm-text').focus(function(){
		this.value = '';
	});

	$('.accept-button').click(function(){
		var location = $(this).attr("href");

		$.ajax({
			type: 'GET',
			url: location
		});

		$(this).parent().slideUp();
		$('.delete-message').animate({opacity:1}).slideDown().delay(3000).slideUp(function(){
			if($('.accepts').children().not(':hidden').length == 0){
				$('.moderate').slideDown();
			}
		});

		return false;
	});

	$('.decline-button').click(function(){
		var location = $(this).attr("href");

		$.ajax({
			type: 'GET',
			url: location
		});

		$(this).parent().slideUp();
		$('.success-message').animate({opacity:1}).slideDown().delay(3000).slideUp(function(){
			if($('.accepts').children().not(':hidden').length == 0){
				$('.moderate').slideDown();
			}
		});

		return false;

	});

	$('.reply').click(function(){
		$('.leave-comment').fadeOut(function(){
			$(this).text('Leave a Reply');
			$(this).fadeIn();
			$('.comment-errors').remove();
			$('#comment-form form .errors').remove();
		});

		var id = $(this).data('id');
		var url = "http://fayesblog.com/index.php/comments/reply/" + id;
		$('.no-reply').addClass('replySubmit');
		$('.replySubmit').attr("data-url",url);
		$('.submitComment').slideUp();
		$('.replySubmit').animate({opacity:1}).slideDown();
		$('.replySubmit').css({
			width:"500px",
			textAlign:"center"
		});

		var scrollPosition = $('#comment-form').offset().top - 100;
		      $('body').animate({
		        "scrollTop": scrollPosition
		      });
		      $('html').animate({
		        "scrollTop": scrollPosition
		      });

		return false;
	});

	$('.no-reply').click(function(){

		var url = $(this).data('url');

	    $('#comment-form').animate({opacity:0.5}).slideUp(function(){
	        $('.thanks').slideDown();

			$.post(url,{name:$('#comment-form form input[name=name]').val(),mess:$('#comment-form form input[name=mess]').val(),comment:$('#comment-form form textarea[name=comment]').val(),website:$('#comment-form form input[name=website]').val(),slug:$('#comment-form form input[name=slug]').val()},function(data){
				//data is a string

				if(data != ''){
					//wierd bug
					$('div.success').show(function(){
						$('div.success').hide();
					});

					$(data).prependTo('#comment-form form');
					var height = parseInt($('.body').data('height')) - 110;
					var input_height = $('#comment-form form input').height();
					var text_area_height = $('#comment-form input textarea').height();
					var button_height = $('#comment-form form .replySubmit').height();
					var error_height = $('#comment-form form .errors').height();
					var error_count = $('#comment-form form .errors').length;
					var body_height = $('.body').height();
					var comment_error_height = $('.comment-errors').height();

					var full_input_height = input_height * 3;
					var full_error_height = (error_height * error_count) + comment_error_height;

					var full_form_height = full_input_height + text_area_height + button_height;
					var full_form_height_with_errors = full_form_height + full_error_height;

					$('#comment-form').animate({opacity:1}).slideDown(function(){
						if(full_form_height_with_errors > body_height){
							$('.body').animate({height: height += '10'});
						}
					});

				}else{
					$('div.success').show(function(){
						$('div.success').hide();
					});

					$('.body').animate({height:height});

						window.location.reload();


				}

			});

	    });


		//send post data
		//slide down form with validation errors

		//else if no errors slide down the form set the values back to the default values
		//change 'leave a reply' to 'leave a comment' 
		//slidedown the form

	    return false;
	});
});	