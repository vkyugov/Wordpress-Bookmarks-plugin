<?php
//_____________________добавляем кнопку добавления в закладки внутри статьи
function bookmarks ($content)
{
    if (!is_user_logged_in () || !is_single ()) return $content;

    global $post;

    if (!is_bookmarks ($post->ID)) {
        $b='"';
        $a = "<p class={$b}bookmarks{$b}>
               <button data-action = {$b}add{$b}>
                <i  class={$b}fa fa-bookmark{$b} aria-hidden={$b}true{$b}>
                 add to bookmarks </i></button>			 
              </p> ";
        return $a.$content;
    } else {
         $b='"';
         $a = "
         <p class={$b}bookmarks{$b}>
          <span class = {$b}bookmarks_added{$b}>
           <i  class={$b}fa fa-bookmark{$b} aria-hidden={$b}true{$b}>
            alredy added to bookmarks 
            <button data-action = {$b}del{$b}>delate</button>
           </i>
          </span>
         </p>";
    return $a.$content;
    }
}
//_____________________добавляем вкладку с закладками в главное меню
function add_bookamarks_link ($items, $args)
{
    if (is_user_logged_in ()) {
        $items .= "<li><a href ='".plugins_url('bookmarks.php', __FILE__)."'>My bookmarks</a></li>";
    }
    return $items;
}
//_____________________добавляем иконки Font awesome  + звдвем стиль для кнопки закладок

 function enqueue_load_fa ()
{  
    wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
}
//_____________________подключаем файл js + задаем данные для поиска файла admin-ajax.php

function bookmarks_script ()
{
    if (!is_user_logged_in ()) return;

    wp_enqueue_script('bookmarks_script', plugins_url('/js/bookmarks_script.js', __FILE__), array('jquery'));
    wp_enqueue_style('bookmarks_style', plugins_url('/css/bookmarks_style.css', __FILE__));

    global $post;
    global $post;

    wp_localize_script ('bookmarks_script', 'bookmarks_object', ['url'=>admin_url ('admin-ajax.php'),
        'sec' => wp_create_nonce ('bookmarks_secure'), 'postID' => $post->ID,
        'img_load' => plugins_url ('/img/loadimg.gif', __FILE__)]);
}

//_____________________функция для работы с ajax запросом для добавления в закладки

function wp_ajax_bookmarks_add ()
{
    if (!wp_verify_nonce ($_POST['security'], 'bookmarks_secure')) {
        wp_die ('sequre error');
    }
    $post_id = (int)$_POST['postID'];
    $user_info = wp_get_current_user ();

    if (is_bookmarks ($post_id)) {
        $a = '<span class = "result">
               <i> alredy added to bookmarks</i>
             </span>';
    wp_die($a);
    }

    if (add_user_meta ($user_info->ID, 'bookmarks', $post_id)){
    $a = '<span class = "result">
          <i> Added to bookmarks</i>
        </span>';
    wp_die ($a);
    }

    echo $_POST['postID'];
    wp_die ('error of adding');
}

//_____________________функция для работы с ajax запросом для удаления из закладок

function wp_ajax_bookmarks_del ()
{
    if (!wp_verify_nonce ($_POST['security'], 'bookmarks_secure')){
        wp_die ('sequre error');
    }

    $post_id = (int)$_POST['postID'];
    $user_info = wp_get_current_user ();

    if (!is_bookmarks ($post_id)) {
        $a = '<span class = result>
              <i> alredy deleted from bookmarks</i>
            </span>';
    wp_die ($a);
    }

    if (delete_user_meta ($user_info->ID, 'bookmarks', $post_id)){
    $a = '<span class = result>
          <i>Deleted from bookmarks</i> 
        </span>';
    wp_die ($a);
    }

    wp_die ('error of deleting');
}

//________________________удаляем все закладки

function wp_ajax_bookmarks_del_all ()
{
    if(!wp_verify_nonce ($_POST['security'], 'bookmarks_secure')){
        wp_die ('sequre error');
    }
    $user_info = wp_get_current_user();

    if (delete_user_meta ($user_info->ID, 'bookmarks')){
	    $a = '<span class = "result">
              <i>All bookmarks was deleted</i>
            </span>'	;
    wp_die ($a);

    }
    wp_die ('error of deleting');
}

//_____________________добавляем проверку на наличие этой статьи в заклдках 

function is_bookmarks ($post_id)
{
    $user_info = wp_get_current_user ();
    $bookmarks = get_user_meta ($user_info->ID, 'bookmarks');

    foreach ($bookmarks as $bookmark) {
        if ($bookmark == $post_id) return true;
    }

    return false;
}
