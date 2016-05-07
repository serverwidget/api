## Serverwidget API
PHP пример Serverwidget API

### Как использовать:
```
$API = new ServerWidgetAPI('Ваш токен ключ');
$response = $API->method('Название метода', array(Параметры запроса));

if (!isset($response['error'])) {
  // Выполнить что то если нет ошибок
} else {
  // Выполнить что то если есть ошибки
}
```

Полноценный пример: [https://playga.me/example.php](https://playga.me/example.php)

### Документация:
Наш официальный сайт: [https://serverwidget.com/dev](https://serverwidget.com/dev)
