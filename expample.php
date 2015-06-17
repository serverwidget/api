<?php

include 'serverwidget.api.php';

$address = (isset($_GET['address']) && strlen($_GET['address'])) ? trim($_GET['address']) : '217.106.106.117:27015';

$sw_api = new ServerWidgetAPI('10007', 'cPlBWPQ74NEF6Ujw3g4HviiPGvZ');
$serverInfo = $sw_api->serverGet($address);

if (isset($serverInfo['result'])) {
  $players = $sw_api->serverPlayers($address);
  $rules = $sw_api->serverRules($address);
  $maps = $sw_api->serverMaps($address);
}

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Serverwidget API Example</title>
<style>
body, html {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  background: #f3f3f3;
  font-family: tahoma, arial, verdana, sans-serif, Lucida Sans;
  font-size: 12px;
  color: #555;
}

a {
  color: #678EB5;
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
  color: #678EB5;
}

h3 {
  margin: 0;
  padding: 10px 0;
  color: #678EB5;
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
}

div.row > span {
  display: inline-block;
  width: 380px;
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
  padding: 10px 0;
  text-align: center;
}

table tr th {
  line-height: 24px;
  background: #eee;
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
</style>
</head>
<body>
  <div class="width">
    <h2>Serverwidget API <div class="fl_r">Скачать с <a href="https://github.com/serverwidget/api/archive/master.zip" rel="nofoloow" target="_blank">github.com</a></div></h2>

    <hr>
<? if (isset($serverInfo['result'])): ?>
    <div class="fl_l">
      <div class="row">
        <b>Статус сервера:</b>
        <span><? if ($serverInfo['result']['server']['online'] == 1): ?><span class="color-green">Работает</span><? else: ?><span class="color-red">Выключен</span><? endif; ?></span>
      </div>
      <div class="row">
        <b>Название сервера:</b>
        <span><?=htmlspecialchars($serverInfo['result']['server']['name']);?></span>
      </div>
      <div class="row">
        <b>Игра:</b>
        <span><?=$serverInfo['result']['server']['game']['name'];?></span>
      </div>
      <div class="row">
        <b>Карта:</b>
        <span><?=htmlspecialchars($serverInfo['result']['server']['map']['name']);?></span>
      </div>
      <div class="row">
        <b>Игроки:</b>
        <span><?=$serverInfo['result']['server']['players']['now'];?> / <?=$serverInfo['result']['server']['players']['max'];?></span>
      </div>
    </div>

    <div class="fl_r"><img width="160" height="120" src="<? if (strlen($serverInfo['result']['server']['map']['image'])): ?><?=$serverInfo['result']['server']['map']['image'];?><? else: ?>//maps.serverwidget.com/noimage.png<? endif; ?>" alt="<?=$serverInfo['result']['server']['map']['name'];?>" title="<?=$serverInfo['result']['server']['map']['name'];?>"></div>

    <div class="clear"></div>

    <hr>

    <h3>Игроки онлайн:</h3>

    <table width="100%" cellpadding="5" cellspacing="0">
      <tr>
        <th align="left">Ранк</th>
        <th align="left">Ник</th>
        <th align="center">Очки</th>
        <th align="right">Время в игре</th>
      </tr>
<? if (count($players['result']['data'])): ?>
<? foreach ($players['result']['data'] as $idx => $player): ?>
      <tr<? if ($idx%2 !== 0): ?> class="dark"<? endif; ?>>
        <td align="left"><?=$player['rank'];?>.</td>
        <td align="left"><?=htmlspecialchars($player['name']);?></td>
        <td align="center"><?=$player['score'];?></td>
        <td align="right"><?=$player['date'];?></td>
      </tr>
<? endforeach; ?>
<? else: ?>
      <tr>
        <td colspan="4"><div class="empty_table">Игроков нет</div></td>
      </tr>
<? endif; ?>
    </table>

    <hr>

    <h3>Настройки сервера:</h3>

    <table width="100%" cellpadding="5" cellspacing="0">
      <tr>
        <th align="right">Ключ</th>
        <th align="left">Значение</th>
      </tr>
<? if (count($rules['result']['data'])): ?>
<? foreach ($rules['result']['data'] as $idx => $rule): ?>
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

    <hr>

    <h3>Карты сервера:</h3>

    <table width="100%" cellpadding="5" cellspacing="0">
      <tr>
        <th align="left">#</th>
        <th align="center">Изображение</th>
        <th align="left">Название</th>
        <th align="right">Процент</th>
      </tr>
<? foreach ($maps['result']['data'] as $idx => $map): ?>
      <tr<? if ($idx%2 !== 0): ?> class="dark"<? endif; ?>>
        <td align="left"><?=($idx + 1)?>.</td>
        <td align="center" width="20%"><img src="<?=(strlen($map['image']) ? $map['image'] : '//maps.serverwidget.com/noimage.png');?>" height="60" alt="<?=$map['name'];?>" title="<?=$map['name'];?>"></td>
        <td align="left" width="40%" style="padding-left: 5px;"><?=$map['name'];?></td>
        <td align="right" width="40%" style="padding-left: 5px;"><?=$map['value'];?>%</td>
      </tr>
<? endforeach; ?>
    </table>
<? else: ?>
    <div class="empty_table"><?=$serverInfo['error']['error_msg'];?></div>
<? endif; ?>

    <div class="footer">jtiq &copy; SERVERWIDGET, 2015</div>
  </div>

<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter30890996 = new Ya.Metrika({id:30890996, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/30890996?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</body>
</html>
