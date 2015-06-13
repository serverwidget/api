# serverwidget-api
PHP Serverwidget API Example

# Usage:
```
$sw_api = new ServerWidgetAPI('YOUR_API_ID', 'YOUR_API_KEY');
$serverInfo = $sw_api->serverGet('217.106.106.117:27015');
if ($serverInfo['result']) {
  echo $serverInfo['result']['server']['name'];
}
```

Result example: [https://playga.me/example.php](https://playga.me/example.php)
