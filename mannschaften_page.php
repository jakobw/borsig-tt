<?php
// Template Name: Mannschaften
get_header();

$teams = get_posts(array(
  'post_type' => 'team',
  'numberposts' => -1,
  'order' => 'ASC',
));

include 'views/mannschaften_page.phtml';

get_footer();
