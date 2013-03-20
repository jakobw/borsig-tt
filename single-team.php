<?php
get_header();

require 'bettv_request.php';

$req = new BettvRequest(array(
  'staffel' => $post->fields['staffel_id'],
  'team' => $post->fields['team_id'],
));
$team = $req->getTeam();
$table = $req->getTable();

$results = $wpdb->get_results($wpdb->prepare(
  "SELECT *
  FROM results
  WHERE team_id = %d
  ORDER BY date DESC
  LIMIT 10", // TODO: better than LIMIT 10 would be to get all results from the current season
  $post->ID
));

include 'views/mannschaft.phtml';

get_footer();
