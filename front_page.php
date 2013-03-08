<?php
// Template Name: Front Page
get_header();

$posts = get_posts();

$teams = array_map(function($team) {
  global $wpdb;

  $team->results = $wpdb->get_results($wpdb->prepare(
    "SELECT *
    FROM results
    WHERE team_id = %d
    ORDER BY date DESC
    LIMIT 3",
    $team->ID
  ));

  return $team;
}, get_posts(array(
  'post_type' => 'team',
  'numberposts' => -1,
)));

include 'views/front_page.phtml';

get_footer();
