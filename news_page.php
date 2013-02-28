<?php
// Template Name: News
get_header();

$posts = get_posts(array(
  'post_type' => 'post',
));

include 'views/news_page.phtml';

get_footer();
