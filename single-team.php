<?php
get_header();

require 'bettv_request.php';

$req = new BettvRequest(array(
  'staffel' => $post->fields['staffel_id'],
  'team' => $post->fields['team_id'],
));
$team = $req->getTeam();
$table = $req->getTable();

include 'views/mannschaft.phtml';

get_footer();
