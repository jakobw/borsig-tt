<?php
// Template Name: Mannschaften
get_header();
require 'bettv_request.php';

$req = new BettvRequest();
$team = $req->getTeam(array(
  'staffel' => 3914,
  'team' => 25323,
));

include 'views/mannschaft.phtml';

get_footer();
