<?php
/*
Plugin Name: Test_bookmarks
Description: Add to bookmarks
Version: 1.0
Author: Krugov Vladimir
*/

//подключаем файл с функциями и файл с закладками если юзерзалогинен 

include_once('functions.php');

//_____________________добавляем кнопку добавления в закладки внутри статьи

add_filter('the_content', 'bookmarks');


//_____________________добавляем вкладку с закладками в главное меню

add_filter( 'wp_nav_menu_items', 'add_bookamarks_link', 10, 2 );
			
//_____________________добавляем иконки Font awesome  + звдвем стиль для кнопки закладок

add_action( 'wp_enqueue_scripts', 'enqueue_load_fa' );


//_____________________подключаем файл js

add_action('wp_enqueue_scripts', 'bookmarks_script');

//_____________________пподключаем ajax запрос для добавления

add_action('wp_ajax_bookmarks_add', 'wp_ajax_bookmarks_add');

//_____________________пподключаем ajax запрос для удаления

add_action('wp_ajax_bookmarks_del', 'wp_ajax_bookmarks_del');
add_action('wp_ajax_bookmarks_del_all', 'wp_ajax_bookmarks_del_all');

