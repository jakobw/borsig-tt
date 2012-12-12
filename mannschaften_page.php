<?php
// Template Name: Mannschaften
get_header();

$teams = get_posts(array(
  'post_type' => 'team',
  'numberposts' => -1,
));

include 'views/mannschaften_page.phtml';

get_footer();
