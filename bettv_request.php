<?php
class BettvRequest {
  private $BASE_URL = 'http://bettv.tischtennislive.de',
          $UPDATE_HOURS = 24,
          $TMP_DIR = 'tmp_xml';

  function __construct($params) {
    $file = __DIR__ . DIRECTORY_SEPARATOR . $this->TMP_DIR . DIRECTORY_SEPARATOR . "${params['team']}_${params['staffel']}.xml";

    $this->_data = $this->_fetchTeamData($params, $file);
  }

  public function getTeam() {
    if ($this->_data) {
      $team = array();
      $team['members'] = array();

      foreach ($this->_data->Content->Bilanz->children() as $member) {
        $team['members'][] = array(
          'position' => (string) $member->Position,
          'name' => (string) $member->Spielername,
          'diff' => $member->GesamtPlus . ':' . $member->GesamtMinus,
        );
      }

      return $team;
    } else {
      return false;
    }
  }

  public function getTable() {
    if ($this->_data) {
      $teams = array();

      foreach ($this->_data->Content->Tabelle->children() as $team) {
        $teams[] = array(
          'name' => (string) $team->Mannschaft,
          'diff_points' => $team->PunktePlus . ' : ' . $team->PunkteMinus,
          'diff_matches' => $team->SpielePlus . ' : ' . $team->SpieleMinus,
        );
      }

      return $teams;
    } else {
      return false;
    }
  }

  public function getResults() {
    if ($this->_data) {
      $results = array();

      foreach ($this->_data->Content->Spielplan->children() as $result) {
        if (preg_match('/[0-9]/', (string) $result->Ergebnis)) {
          $home = strpos($result->Heimmannschaft, 'Borsig') !== false;
          $results[] = array(
            'home' => $home,
            'opponent' => (string) ($home ? $result->Gastmannschaft : $result->Heimmannschaft),
            'date' => (string) $result->Datum,
            'score' => (string) $result->Ergebnis,
            'nr' => (int) $result->Nr,
          );
        }
      }

      return $results;
    } else return false;
  }

  private function _fetchTeamData($params, $file) {
    if (!file_exists($file) || time() - filemtime($file) > $this->UPDATE_HOURS * 3600) {
      $url = $this->BASE_URL . '/Export/default.aspx?' . http_build_query(array(
        'TeamID' => $params['team'],
        'Format' => 'XML',
        'SportArt' => 96, // 96 == tischtennis
        'Area' => 'TeamReport',
        'WettID' => $params['staffel'],
        'Runde' => date('m') > 8 ? 1 : 2,
      ));

      $response = wp_remote_get($url);

      return !is_wp_error($response)
        && $response['response']['code'] == 200
        && file_put_contents($file, $response['body']) ?
          simplexml_load_string($response['body'])
        : false;
    } else return simplexml_load_string(file_get_contents($file));
  }
}
