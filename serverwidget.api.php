<?php

/**
 *
 *  Usage:
 *    $sw_api = new ServerWidgetAPI('API_TOKEN_KEY', 'API_LANG', 'API_VERSION');
 *    $serverInfo = $sw_api->serverGet('217.106.106.117:27015');
 *
 *    if ($serverInfo['result']) {
 *      echo $serverInfo['result'][0]['name'];
 *    }
 *
**/

Class ServerWidgetAPI {
  private $api_url = 'http://api.serverwidget.com/';
  private $api_token = '';
  private $api_lang = 'ru';
  private $api_version = '2.0';

  // On Class init
  public function __construct($api_token = '', $api_lang = 'ru', $api_version = '2.0') {
    $this->api_token = $api_token;
    $this->api_lang = $api_lang;
    $this->api_version = $api_version;
  }

  // Method: server.get
  public function serverGet($address) {
    return $this->method('server.get', array('address' => $address, "fields" => "players,map,game,location,update,extra,uptime,rank,ping"));
  }

  // Method: server.players
  public function serverPlayers($address) {
    return $this->method('server.players', array('address' => $address));
  }

  // Method: server.rules
  public function serverRules($address) {
    return $this->method('server.rules', array('address' => $address));
  }

  // Method: server.maps
  public function serverMaps($address) {
    return $this->method('server.maps', array('address' => $address));
  }

  // Method: server.stats
  public function serverStats($address, $start_time = 0, $end_time = 0) {
    return $this->method('server.stats', array('address' => $address, 'start_time' => $start_time, 'end_time' => $end_time));
  }

  // Method: server.ping
  public function serverPing($address, $start_time = 0, $end_time = 0) {
    return $this->method('server.ping', array('address' => $address, 'start_time' => $start_time, 'end_time' => $end_time));
  }

  // Method: server.uptime
  public function serverUptime($address, $start_time = 0, $end_time = 0) {
    return $this->method('server.uptime', array('address' => $address, 'start_time' => $start_time, 'end_time' => $end_time));
  }

  // Call method
  public function method($name, $params = array()) {
    $url = $this->api_url."/method/$name";

    return json_decode($this->request($url, $params), true);
  }

  // Requesting
  private function request($url, $params = array()) {
    $params['token'] = $this->api_token;
    $params['lang'] = $this->api_lang;
    $params['v'] = $this->api_version;
    $params['https'] = 1;

    $url = $url . (is_array($params) && count($params) ? '?'.$this->params($params) : '');

    if (function_exists('curl_init')) {
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
      curl_setopt($ch, CURLOPT_HEADER, 0);

      $result = curl_exec($ch);

      curl_close($ch);

      return $result;
    }

    return @file_get_contents($url);
  }

  // Genearate URL query params
  private function params($params = array()) {
    $pice = array();

    foreach ($params as $k => $v) {
      $pice[] = $k.'='.urlencode($v);
    }

    return implode('&', $pice);
  }
}

?>
