<?php
class BettvRequest {
  private $BASE_URL = 'http://bettv.tischtennislive.de',
          $UPDATE_HOURS = 24,
          $TMP_DIR = 'tmp_xml';

  public function getTeam($params) {
    $file = __DIR__ . DS . $this->TMP_DIR . DS . "${params['team']}_${params['staffel']}.xml";

    $data = $this->_fetchTeamData($params, $file);

    if ($data) {
      $team = array();
      $team['members'] = array();

      foreach ($data->Content->Bilanz->children() as $member) {
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

  public function getTable($id, $ownTeam) {

  }

  private function _fetchTeamData($params, $file) {
    if (!file_exists($file) || time() - filemtime($file) > $this->UPDATE_HOURS * 3600) {
      $url = $this->BASE_URL . '/Export/default.aspx?' . http_build_query(array(
        'TeamID' => $params['team'],
        'Format' => 'XML',
        'SportArt' => 96, // 96 == tischtennis
        'Area' => 'TeamReport',
        'WettID' => $params['staffel'],
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
