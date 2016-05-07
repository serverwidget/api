<?php

include 'serverwidget.api.php';

$address = (isset($_GET['address']) && strlen($_GET['address'])) ? trim($_GET['address']) : '78.107.35.5:27015';

$API = new ServerWidgetAPI('Ваш токен ключ');
$serverInfo = $API->method("server.get", array(
  "address" => $address,
  "fields" => "players,map,game,location,update,extra,uptime,rank,ping"
));

if (count($serverInfo['result']) && is_array($serverInfo['result'])) {
  $server = $serverInfo['result'][0];
  $players = $API->method("server.players", array("address" => $address));
  $rules = $API->method("server.rules", array("address" => $address));
  $maps = $API->method("server.maps", array("address" => $address));
}

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Пример Serverwidget API</title>
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
</head>
<body>
  <div class="width">
    <h2><a href="/example.php" class="logo fl_l"></a> <span style="display: block; padding-left: 40px;"> API 2.0 <div class="github fl_r">Скачать с <a href="https://github.com/serverwidget/api" rel="nofoloow" target="_blank">github.com</a></div></span></h2>

    <hr>
<? if (is_array($server)): ?>
    <div class="fl_l">
      <div class="row">
        <b>Статус сервера:</b>
        <span><? if ($server['online'] == 1): ?><span class="color-green">Работает</span><? else: ?><span class="color-red">Выключен</span><? endif; ?></span>
      </div>
      <div class="row">
        <b>Название сервера:</b>
        <span><?=htmlspecialchars($server['name']);?></span>
      </div>
      <div class="row">
        <b>Адрес сервера:</b>
        <span><?=htmlspecialchars($server['address']);?></span>
      </div>
      <div class="row">
        <b>Игра:</b>
        <span><?=$server['game']['name'];?></span>
      </div>
      <div class="row">
        <b>Карта:</b>
        <span><?=htmlspecialchars($server['map']['name']);?></span>
      </div>
      <div class="row">
        <b>Игроки:</b>
        <span><?=$server['players']['now'];?> / <?=$server['players']['max'];?></span>
      </div>
      <div class="row">
        <b>VAC античит:</b>
        <span><?=($server['extra']['vac'] == 1 ? 'Да' : 'Нет');?></span>
      </div>
      <div class="row">
        <b>ОС сервера:</b>
        <span><?=($server['extra']['os'] == 'l' ? 'Linux' : ($server['extra']['os'] == 'w' ? 'Windows' : 'Mac'));?></span>
      </div>
      <div class="row">
        <b>Требуется пароль:</b>
        <span><?=($server['extra']['password'] == 1 ? 'Да' : 'Нет');?></span>
      </div>
      <div class="row">
        <b>Тип:</b>
        <span><?=($server['extra']['dedicated'] == 'd' ? 'Выделенный' : 'Виртуальный');?></span>
      </div>
      <div class="row">
        <b>Расположение:</b>
        <span><?=$server['location']['country']['name'];?></span>
      </div>
      <div class="row">
        <b>Ранк:</b>
        <span><?=$server['rank'];?></span>
      </div>
      <div class="row">
        <b>Пинг:</b>
        <span><?=$server['ping'];?></span>
      </div>
      <div class="row">
        <b>Uptime:</b>
        <span><?=$server['uptime'];?>%</span>
      </div>
    </div>

    <div class="fl_r"><img width="160" height="120" src="<? if (strlen($server['map']['image'])): ?><?=$server['map']['image'];?><? else: ?>https://img.serverwidget.com/maps/noimage.png<? endif; ?>" alt="<?=$server['map']['name'];?>" title="<?=$server['map']['name'];?>"></div>

    <div class="clear"></div>

<script type="text/javascript">
function geByTag(searchTag, node) {
  node = node || document;
  var elems = [], nodes = node.getElementsByTagName(searchTag);

  if (nodes.length) {
    for (var i = 0; i < nodes.length; i++) {
      elems.push(nodes[i]);
    }
  }

  return elems;
}

function geByClass(searchClass, node, tag) {
  node = node || document;
  tag = tag || '*';

  if (node.querySelectorAll && tag != '*') {
    return node.querySelectorAll(tag + '.' + searchClass.replace(/\s+/g, '.'));
  }

  var classElements = [];

  if (node.getElementsByClassName) {
    var nodes = node.getElementsByClassName(searchClass);

    if (tag != '*') {
      tag = tag.toUpperCase();

      for (var i = 0, l = nodes.length; i < l; ++i) {
        if (nodes[i].tagName.toUpperCase() == tag) {
          classElements.push(nodes[i]);
        }
      }
    } else {
      classElements = Array.prototype.slice.call(nodes);
    }

    return classElements;
  }

  var els = geByTag(tag, node), pattern = new RegExp('(^|\\s)' + searchClass + '(\\s|$)');

  for (var i = 0, l = els.length; i < l; ++i) {
    if (pattern.test(els[i].className)) {
      classElements.push(els[i]);
    }
  }

  return classElements;
}

function formatTime(seconds) {
  var days   = Math.floor(seconds / 86400);
  var hours   = Math.floor((seconds - (days * 86400)) / 3600);
  var minutes = Math.floor((seconds - (days * 86400) - (hours * 3600)) / 60);
  seconds = seconds - (days * 86400) - (hours * 3600) - (minutes * 60);

  if (hours && hours   < 10) {hours = "0"+hours;}
  if (minutes < 10) {minutes = "0"+minutes;}
  if (seconds < 10) {seconds = "0"+seconds;}

  return (days ? days+'d ' : '')+(hours ? hours+':' : '')+minutes+':'+seconds;
}

function declOfNum(number, str) {
  var cases = [2, 0, 1, 1, 1, 2];

  str = str[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];

  return str.replace(/%n/g, number);
}

function updatePlayerTime(elements) {
  var i = 0;

  for (var key in elements) {
    var element = elements[key], time = parseInt(element.getAttribute('time')) || 0;

    time++;

    element.setAttribute('time', time);
    element.innerHTML = formatTime(time);

    i++;
  }

  if (i > 0) {
    setTimeout(function() {
      updatePlayerTime(elements);
    }, 1000);
  }
}
</script>

    <hr>

    <h3>Все карты сервера:</h3>

    <table width="100%" cellpadding="5" cellspacing="0">
      <tr>
        <th align="left">#</th>
        <th align="center">Изображение</th>
        <th align="left">Название</th>
        <th align="right">Процент</th>
      </tr>
<? foreach ($maps['result'] as $idx => $map): ?>
      <tr<? if ($idx%2 !== 0): ?> class="dark"<? endif; ?>>
        <td align="left"><?=($idx + 1)?>.</td>
        <td align="center" width="20%"><img src="<?=(strlen($map['image']) ? $map['image'] : 'https://img.serverwidget.com/maps/noimage.png');?>" height="60" alt="<?=$map['name'];?>" title="<?=$map['name'];?>"></td>
        <td align="left" width="40%" style="padding-left: 5px;"><?=$map['name'];?></td>
        <td align="right" width="40%" style="padding-left: 5px;"><?=$map['value'];?>%</td>
      </tr>
<? endforeach; ?>
    </table>

    <hr>

    <h3>Игроки онлайн:</h3>

    <table width="100%" cellpadding="5" cellspacing="0">
      <tr>
        <th align="left">Ранк</th>
        <th align="left">Ник</th>
        <th align="center">Очки</th>
        <th align="right">Время в игре</th>
      </tr>
<? if (count($players['result'])): ?>
<? foreach ($players['result'] as $idx => $player): ?>
      <tr<? if ($idx%2 !== 0): ?> class="dark"<? endif; ?>>
        <td align="left"><?=$player['rank'];?>.</td>
        <td align="left"><?=htmlspecialchars($player['name']);?></td>
        <td align="center"><?=$player['score'];?></td>
        <td align="right" class="update-time" time="<?=$player['time'];?>"><?=$player['date'];?></td>
      </tr>
<? endforeach; ?>
<? else: ?>
      <tr>
        <td colspan="4"><div class="empty_table">Игроков нет</div></td>
      </tr>
<? endif; ?>
    </table>

<script type="text/javascript">
updatePlayerTime(geByClass('update-time'));
</script>

    <hr>

    <h3>Настройки сервера:</h3>

    <table width="100%" cellpadding="5" cellspacing="0">
      <tr>
        <th align="right">Ключ</th>
        <th align="left">Значение</th>
      </tr>
<? if (count($rules['result'])): ?>
<? foreach ($rules['result'] as $idx => $rule): ?>
      <tr<? if ($idx%2 !== 0): ?> class="dark"<? endif; ?>>
        <td align="right" width="50%"><?=$rule['key'];?></td>
        <td align="left" width="50%" style="padding-left: 5px;"><?=htmlspecialchars($rule['value']);?></td>
      </tr>
<? endforeach; ?>
<? else: ?>
      <tr>
        <td colspan="4"><div class="empty_table">Настроек нет</div></td>
      </tr>
<? endif; ?>
    </table>
<? else: ?>
    <div class="empty_table"><?=$serverInfo['error']['error_msg'];?></div>
<? endif; ?>

    <hr>

    <div class="footer">jtiq &copy; SERVERWIDGET, 2016</div>
  </div>
</body>
</html>
