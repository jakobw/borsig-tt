<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 'wp-load.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bettv_request.php';

$teams = get_posts(array(
  'numberposts' => -1,
  'post_type' => 'team',
));

foreach ($teams as $team) {
  $team->fields = get_custom_fields($team->ID);
  $req = new BettvRequest(array(
    'team' => $team->fields['team_id'],
    'staffel' => $team->fields['staffel_id'],
  ));

  foreach ($req->getResults() as $result) {
    $num_results = $wpdb->query($wpdb->prepare(
      "SELECT id
      FROM results
      WHERE `team_id` = %d
        AND `match_nr` = %d
        AND `date` = DATE('%s')",
      $team->ID,
      $result['nr'],
      date('Y-m-d', strtotime($result['date']))
    ));

    if ($num_results === 0) {
      $score = explode(':', $result['score']);

      $wpdb->insert(
        'results',
        array(
          'team_id' => $team->ID,
          'match_nr' => $result['nr'],
          'opponent' => $result['opponent'],
          'date' => $result['date'],
          'home' => $result['home'],
          'url' => $result['url'],
          'score_we' => $result['home'] ? $score[0] : $score[1],
          'score_they' => $result['home'] ? $score[1] : $score[0],
        )
      );
    }
  }
}
