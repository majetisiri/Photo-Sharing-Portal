$(document).ready(function() {

	$('.like').click(function(){
		var id=$(this).attr('id');
		var _this =$(this);
		
		$.post("likes.php", {'pid': id,'user_id':uid},function(response){
			
			var noOfLikes= $(_this).prev().text();
			
			if(!noOfLikes) {
				noOfLikes = 0;
			}

			if($(_this).html()=='Like'){
					$(_this).text('Unlike') ;
					noOfLikes = parseInt(noOfLikes)+1; 
				}
			else {

				$(_this).text('Like');
				noOfLikes = parseInt(noOfLikes)-1; 

			}
			$(_this).prev().text(noOfLikes);			 
		});
		
	});

	$('.edit_post').click(function(){
		var id = $(this).attr('id');
		var post= $(this).siblings('.caption').children('p').text();
		var _this = this;
		$.post('get_post.php', {edit_id: id}, function(response){
			$(_this).siblings('.caption').children('p').html('<textarea style="margin-bottom:8px;"  name="post_data" class="edited_post textarea form-control"> '+post+'</textarea><button name="re_post" type="submit" class="repost btn btn-primary"> Re-Post </button>');
		});
	});

	$(document).on('click', '.repost', function(){
		var post_data = $(this).siblings('.edited_post').val();
		console.log(post_data);
		var edit_id = $(this).parent().siblings('.like').attr('id');

		var _this = this;
		$.post('update_post.php', {edit_id: edit_id, post_data: post_data}, function(response) {
				console.log($(_this));
				$(_this).parent().html(post_data);
				$(_this).siblings('.edited_post').remove();
				$(_this).remove();	
		});
	
	});


	$('.comment').click(function(){
		$(this).siblings('.comment_box').html('<br/><textarea style="margin-bottom:8px;" name="comment" class="textarea form-control" placeholder="Type here"></textarea>');
	});

	// $('.see_comments').click(function(){
	// 	var that= 
	// 	$(this).siblings('.comment_box').html('<br/><textarea style="margin-bottom:8px;" name="comment" class="textarea form-control" placeholder="Type here"></textarea>');
	// });

	$('.delete_post').click(function(){
		var id = $(this).attr('id');
		var _this = this;
		$.post('delete_post.php', {delete_id: id}, function(response){
			$(_this).parents('.post').remove();
		});
	});

	$(document).on('keyup', '.textarea', function(e){
		var comment = e.target.value;
		var id =$(this).parent().siblings().filter('.like').attr('id');
		if(e.keyCode==13) {
			
			var _this = this;

			$.post("comments.php",{'comment':comment, 'pid':id, 'user_id':uid},function(response){
				var that = $(_this).parent().siblings('.comments_click');
				display_comments(that, id);
				$(_this).remove();			
			});
		}
	});


});