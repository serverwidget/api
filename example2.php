<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Пример Serverwidget JS API</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
<style>
body, html {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  background: #f3f3f3;
  font-family: 'Open Sans', sans-serif;
  font-size: 13px;
  color: #555;
}

* {
  outline: 0;
}

a {
  color: #52A9EA;
}

.fl_r {
  float: right;
}

.fl_l {
  float: left;
}

.clear {
  clear: both;
}

.width {
  width: 760px;
  margin: 0 auto;
  padding: 0 20px;
  background: #fff;
  min-height: 100%;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}

h2 {
  margin: 0;
  padding: 15px 0 0 0;
  color: #52A9EA;
  font-size: 20px;
  font-weight: 500;
}

h3 {
  margin: 0;
  padding: 10px 0;
  color: #52A9EA;
  font-size: 18px;
  font-weight: 400;
}

hr {
  height: 1px;
  border: 0;
  background: #B0C2D6;
  margin-top: 20px;
  margin-bottom: 10px;
  padding: 0;
}

div.row > b {
  display: inline-block;
  width: 150px;
  text-align: right;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  height: 24px;
  line-height: 24px;
  font-weight: 600;
}

div.row > span {
  display: inline-block;
  width: 420px;
  padding-left: 5px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  height: 24px;
  line-height: 24px;
}

div.empty_table {
  padding: 100px 0;
  text-align: center;
  color: #777;
  font-size: 14px;
}

div.footer {
  padding: 10px 0 20px 0;
  text-align: center;
}

table tr th {
  line-height: 24px;
  background: #DEE5EB;
  color: #67809f;
  font-weight: 600;
}

table tr td {
  line-height: 18px;
}

table tr.dark td {
  background: #f3f3f3;
}

img {
  border: 0;
  border-radius: 3px;
}

span.color-red {
  color: red;
}

span.color-green {
  color: green;
}

a.logo {
  background: url(/logo.svg?1) center center no-repeat;
  width: 32px;
  height: 32px;
  position: relative;
  top: -3px;
  display: block;
  background-size: 32px 32px;
}

.github {
  font-size: 14px;
  line-height: 28px;
}
</style>
<script src="//api.serverwidget.com/js/api.js?1"></script>
</head>
<body>
  <div class="width">
    <h2><a href="/example2.php" class="logo fl_l"></a> <span style="display: block; padding-left: 40px;"> JS API <div class="github fl_r">Скачать с <a href="https://github.com/serverwidget/api" rel="nofoloow" target="_blank">github.com</a></div></span></h2>

    <hr>

    <div id="server_wrapper"><div class="empty_table">Идёт загрузка данных...</div></div>

<script>
var address = '37.187.205.242:7777', server_wrapper = document.getElementById('server_wrapper');

function htmlspecialchars(str) {
  return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

SERVERWIDGET.Api.call('server.get', {
  lang: 'ru',
  address: address,
  fields: 'players,map,game,geo,update,extra,uptime,rank,ping'
}, function(response) {
  if (response.result) {
    var server = response.result[0] || null;

    if (server) {
      var serverTpl = '\
    <div class="fl_l">\
      <div class="row">\
        <b>Статус сервера:</b>\
        <span>' + (server['online'] ? '<span class="color-green">Работает</span>' : '<span class="color-red">Выключен</span>') + '</span>\
      </div>\
      <div class="row">\
        <b>Название сервера:</b>\
        <span>' + htmlspecialchars(server['name']) + '</span>\
      </div>\
      <div class="row">\
        <b>Адрес сервера:</b>\
        <span>' + htmlspecialchars(server['address']) + '</span>\
      </div>\
      <div class="row">\
        <b>Игра:</b>\
        <span>' + server['game']['name'] + '</span>\
      </div>\
      <div class="row">\
        <b>Карта:</b>\
        <span>' + htmlspecialchars(server['map']['name']) + '</span>\
      </div>\
      <div class="row">\
        <b>Игроки:</b>\
        <span>' + server['players']['now'] + ' / ' + server['players']['max'] + '</span>\
      </div>\
      <div class="row">\
        <b>VAC античит:</b>\
        <span>' + (server['extra']['vac'] == 1 ? 'Да' : 'Нет') + '</span>\
      </div>\
      <div class="row">\
        <b>ОС сервера:</b>\
        <span>' + (server['extra']['os'] == '-' ? '-' : (server['extra']['os'] == 'l' ? 'Linux' : (server['extra']['os'] == 'w' ? 'Windows' : 'Mac'))) + '</span>\
      </div>\
      <div class="row">\
        <b>Требуется пароль:</b>\
        <span>' + (server['extra']['password'] == 1 ? 'Да' : 'Нет') + '</span>\
      </div>\
      <div class="row">\
        <b>Тип:</b>\
        <span>' + (server['extra']['dedicated'] == '-' ? '-' : (server['extra']['dedicated'] == 'd' ? 'Выделенный' : 'Виртуальный')) + '</span>\
      </div>\
      <div class="row">\
        <b>Расположение:</b>\
        <span>' + server['geo']['country']['name'] + '</span>\
      </div>\
      <div class="row">\
        <b>Пинг:</b>\
        <span>' + server['ping'] + '</span>\
      </div>\
      <div class="row">\
        <b>Uptime:</b>\
        <span>' + server['uptime'] + '%</span>\
      </div>\
    </div>\
    <div class="fl_r"><img width="160" height="120" src="' + (server['map']['image'] ? server['map']['image'] : '//img.serverwidget.com/maps/noimage.png') + '" alt="' + server['map']['name'] + '" title="' + server['map']['name'] + '"></div>\
    <div class="clear"></div>';

      server_wrapper.innerHTML = serverTpl;
    } else {
      server_wrapper.innerHTML = '<div class="empty_table">Сервер не найден</div>';
    }
  } else {
    server_wrapper.innerHTML = '<div class="empty_table">' + response.error.message + '</div>';
  }
});
</script>

    <hr>

    <div class="footer">SERVERWIDGET &copy; 2016</div>
  </div>
</body>
</html>
