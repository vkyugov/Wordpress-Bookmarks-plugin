
<?php 

$home_url = 'http://' . $_SERVER['HTTP_HOST'].'/bookmarks';
//header($home_url);

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');


get_header(); 

 
if (!is_user_logged_in()) {
    wp_die('This page avelible only for logged in users') ;
}

include_once('functions.php');
wp_enqueue_style('bookmarks_style', plugins_url('/css/bookmarks_style.css', __FILE__));

$user_info = wp_get_current_user();
$bookmarks = get_user_meta($user_info->ID, 'bookmarks');

if (!$bookmarks) {
    echo '<p  class = "no_bookmarks">No 1 page was find in bookmarks</p>';
    get_footer();
    exit();
}

echo'<div class = "all_bookmarks">';
echo'
    <p class="del_all">
    <button data-action = "del_all">Clear bookmarks</button>
    </p>';
//____________________________________________выводим заголовок, картинку, контент статьи и кнопку удаления
foreach ($bookmarks as $bookmark) {
    $post = get_post($bookmark);
    $title = $post->post_title;
    $img = get_the_post_thumbnail( $post->ID, 'medium' );
    $content = wp_trim_words( $post->post_content, 35, '<br><b><a href="'
              .get_permalink($post->ID).'"> ... read more </b> </a>' );
    echo'
    <div class="title">
    	<h3>
    	 <a href="'.get_permalink($post->ID).'">'.$title.'</a></li>
    	</h3>	
    </div>
    <div class="img">
      '.$img.' 
    </div>
    <div class="content"><i>
     <span>'.$content.'</span></i>
     <p class="dell_bookmarks">
      <button data-post = "'.$bookmark.'">Delete from bookmarks</button>
     </p>
    </div>';
}
echo '</div>';

get_footer();
