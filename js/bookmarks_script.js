jQuery(document).ready(function($) 
{
 $('.bookmarks button').click(function(e)
 {
 	var act = $(this).data('action');
 	if(act == 'del'){
 			if(!confirm('Are you sure ?')) return false;
 	}
  	$.ajax(
  	{
 		type: 'POST',
 		url : bookmarks_object.url,
 		data : {
 			security: bookmarks_object.sec,
 			action: 'bookmarks_' + act,
 			postID: bookmarks_object.postID,
 		},
 		beforeSend: function()
 		{
 			$('p.bookmarks').html('Loading...');
 		},
 		success: function(result)
 		{
 			$('p.bookmarks').html(result); 			
 		},
 		error: function(){
 			alert('error');
 		}
 	})
 	e.preventDefult();
 })
});

jQuery(document).ready(function($) 
{
 $('.dell_bookmarks button').click(function(e)
 {
 	if(!confirm('Are you sure ?')) return false;
 	var post = $(this).data('post'); 	
 	p = $(this).closest('p');
 	$.ajax(
 	{
		type: 'POST',
 		url : bookmarks_object.url,
 		data : {
 			security: bookmarks_object.sec,
 			action: 'bookmarks_del',
 			postID: post
 		},
 		beforeSend: function()
 		{
 			$('p.bookmarks').html('Loading...'); 			
 		},
 		success: function(result)
 		{
 			p.html(result); 			
 		},
 		error: function()
 		{
 			alert('error');
 		}
 	})
 	e.preventDefult();
  })
 });

jQuery(document).ready(function($)
{
 $('.del_all button').click(function(e)
 {
 	if(!confirm('Are you sure ?')) return false;
 	p = $(this).closest('p');
 	$.ajax(
 	{
		type: 'POST',
 		url : bookmarks_object.url,
 		data : {
 			security: bookmarks_object.sec,
 			action: 'bookmarks_del_all'
 		},
 		beforeSend: function()
 		{
 			$('p.bookmarks').html('Loading...');			
 		},
 		success: function(result)
 		{
	 		p.html(result);
	 		$('div.title').fadeOut();
	 		$('div.img').fadeOut();
	 		$('div.content').fadeOut();
 		},
 		error: function(){
 			alert('ajax error');
 		}
 	})
 	e.preventDefult();
  })
 })