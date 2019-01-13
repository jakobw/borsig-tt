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
  'orderby' => 'menu_order',
  'order' => 'ASC',
)));

$members = array_map(
  function($member) {
    return array_map(function($d) { return trim($d); }, explode(',', $member));
  },
  explode("\n", file_get_contents(__DIR__ . '/birthdays.csv')) ?: []
);
$bdays = array_filter($members, function($member) {
  list(, $birthday) = $member;
  return $birthday && date('m') === date('m', strtotime($birthday));
});
usort($bdays, function($a, $b) {
  return $a[1] - $b[1];
});

include 'views/front_page.phtml';

get_footer();
