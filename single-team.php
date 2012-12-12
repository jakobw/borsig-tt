<?php
get_header();

require 'bettv_request.php';

$req = new BettvRequest();
$team = $req->getTeam(array(
  'staffel' => $post->fields['staffel_id'],
  'team' => $post->fields['team_id'],
));

include 'views/mannschaft.phtml';

get_footer();
