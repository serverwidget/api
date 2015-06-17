<?php

/**
 *
 *  Usage:
 *    $sw_api = new ServerWidgetAPI('YOUR_API_ID', 'YOUR_API_KEY', 'API_LANG', 'API_VERSION');
 *    $serverInfo = $sw_api->serverGet('217.106.106.117:27015');
 *
 *    if ($serverInfo['result']) {
 *      echo $serverInfo['result']['server']['name'];
 *    }
 *
**/

Class ServerWidgetAPI {
  private $api_url = 'https://api.serverwidget.com/';
  private $api_id = 0;
  private $api_key = '';
  private $api_lang = 'ru';
  private $api_version = 'v1';

  // On Class init
  public function __construct($api_id = 0, $api_key = '', $api_lang = 'ru', $api_version = 'v1') {
    $this->api_id = $api_id;
    $this->api_key = $api_key;
    $this->api_lang = $api_lang;
    $this->api_version = $api_version;
  }

  // Method: server.get
  public function serverGet($address) {
    return $this->method('server.get', array('address' => $address));
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
    $url = $this->api_url.$this->api_version."/method/$name";

    return json_decode($this->request($url, $params), true);
  }

  // Requesting
  private function request($url, $params = array()) {
    $params['api_id'] = $this->api_id;
    $params['api_key'] = $this->api_key;
    $params['lang'] = $this->api_lang;

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
