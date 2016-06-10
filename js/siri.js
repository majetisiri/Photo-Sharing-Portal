$(document).ready(function() {
	console.log($('.like'));
	$('.like').click(function(){
		// console.log($(this).attr('id'));
		var id=$(this).attr('id');
		var _this =$(this);
		$.post("likes.php", {'pid': id,'user_id':uid},function(response){
			                                                                                                                                                   
		});
		var noOfLikes= $(_this).prev().text();
			
		// console.log($(this).text());

		if($(this).text().trim()=='Like'){
			$(this).text('Unlike') ;
			noOfLikes = parseInt(noOfLikes)+1; 
			}
		else {
			$(this).text('Like');
			noOfLikes = parseInt(noOfLikes)-1; 

		}
		$(_this).prev().text(noOfLikes);			 
		
	});

	$('.comment').click(function(){
		$(this).next().html('<textarea name="comment" class="textarea form-control" placeholder="Type here"></textarea>');
	});

	$(document).on('keyup', '.textarea', function(e){
		var comment = e.target.value;
		var id =$(this).parent().siblings().filter('.like').attr('id');

		if(e.keyCode==13) {
			var _this = this;
			$.post("comments.php",{'comment':comment, 'pid':id, 'user_id':uid},function(response){
				console.log($(_this).parents().find("Table").siblings().children().find('.comment_list').append('<li>' + comment + '</li>'));
				$(_this).parents().find("table").next().find('.comment_list').append('<li>' + comment + '</li>');
				$('.no_comments').remove();
				$(_this).remove();
			});
		}
	});

	$('.see_more').click(function(){
		$(this).prev().children().show();
		$(this).remove();
	});


	$('.see_less').click(function(){
		$(this).prev().hide();
		$(this).remove();
	});

});