# serverwidget-api
PHP Serverwidget API Example

# Usage:
```
$API = new ServerWidgetAPI('API_TOKEN_KEY');
$serverInfo = $API->serverGet('217.106.106.117:27015');
if (count($serverInfo['result']) && is_array($serverInfo['result'])) {
  echo $serverInfo['result'][0]['name'];
}
```

Result example: [https://playga.me/example.php](https://playga.me/example.php)
