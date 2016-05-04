# Serverwidget API
PHP пример Serverwidget API

# Как использовать:
```
$API = new ServerWidgetAPI('Ваш токен ключ');
$serverInfo = $API->serverGet('IP адрес сервера');
if (count($serverInfo['result']) && is_array($serverInfo['result'])) {
  echo $serverInfo['result'][0]['name'];
}
```

Полноценный пример: [https://playga.me/example.php](https://playga.me/example.php)
