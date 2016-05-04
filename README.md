# serverwidget-api
PHP Serverwidget API Example

# Usage:
```
$sw_api = new ServerWidgetAPI('API_TOKEN_KEY');
$serverInfo = $sw_api->serverGet('217.106.106.117:27015');
if ($serverInfo['result']) {
  echo $serverInfo['result'][0]['name'];
}
```

Result example: [https://playga.me/example.php](https://playga.me/example.php)
