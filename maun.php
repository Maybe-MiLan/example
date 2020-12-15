<?php
require_once "db.php";
$query = " SELECT * FROM `timelog` WHERE `userid` = '9' AND `ID` = (SELECT Max(`ID`) 
 FROM   `timelog` WHERE `userid` = '9')";
$result = $db->query($query) or die ("ошибка если вдруг запрос не пройдет");
$row = $result->fetch_array();
$now = new DateTime($row['logout']);
$interval = $now->diff( new DateTime($row['login']));
$intervaltime = $interval->format('%H,%i,%s');
$query = " UPDATE `timelog` SET `times` = '$intervaltime' WHERE `userid` = '9' AND `ID` = (SELECT Max(`ID`) 
 FROM   `timelog` WHERE `userid` = '9')";
$db->query($query) or die ("не смог найти разницу");
var_dump($intervaltime);

