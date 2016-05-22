## Serverwidget API
PHP пример Serverwidget API

### Как использовать:
```
$API = new ServerWidgetAPI('Ваш токен ключ');
$response = $API->method('Название метода', array(Параметры запроса));

if (!isset($response['error'])) {
  // Обработчик результата
} else {
  // Обработчик ошибок
}
```

Полноценный пример: [https://playga.me/example.php](https://playga.me/example.php)

### Пример JS API:
```
SERVERWIDGET.Api.call('Название метода', {
  Параметры запроса
}, function(response) {
  if (response.result) {
    // Обработчик результата
  } else {
    // Обработчик ошибок
  }
});
```

Полноценный пример: [https://playga.me/example2.php](https://playga.me/example2.php)

### Документация:
Наш официальный сайт: [https://serverwidget.com/dev](https://serverwidget.com/dev)
