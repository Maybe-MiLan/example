<?php
require_once "db.php";
if (isset($_POST['logout'])){
    $query = " UPDATE `timelog` SET `logout` = '$obg' WHERE `userid` = {$_SESSION['id']} AND `ID` = (SELECT Max(`ID`) 
 FROM   `timelog` WHERE `userid` = {$_SESSION['id']})";
    $db->query($query)
    or die ("не удалось записать выход");

    $query = " UPDATE `users` SET `Active` = 0 WHERE `ID`= {$_SESSION['id']}";
    $db->query($query)
        or die ("не смог записать время выхода");
    $query = " SELECT * FROM `timelog` WHERE `userid` = {$_SESSION['id']} AND `ID` = (SELECT Max(`ID`) 
 FROM   `timelog` WHERE `userid` = {$_SESSION['id']})";
    $result = $db->query($query) or die ("ошибка если вдруг запрос не пройдет");
    $row = $result->fetch_array();
    $now = new DateTime($row['logout']);
    $interval = $now->diff( new DateTime($row['login']));
    $intervaltime = $interval->format('%H:%i:%s');

    $query = " UPDATE `timelog` SET `times` = '$intervaltime' WHERE `userid` = {$_SESSION['id']} AND `ID` = (SELECT Max(`ID`) 
 FROM   `timelog` WHERE `userid` = {$_SESSION['id']})";
    $db->query($query) or die ("не смог найти разницу");
    session_destroy();
    header("Refresh: 1; url=?");
    echo  '<div class="success">Выход успешно выполнен!</div>';
}

if (isset($_SESSION['id'])){
    $query = "SELECT * FROM " . TABLE_RESAN ." WHERE `userid` = {$_SESSION['id']} ";
    $result = $db->query($query)
    or die ("немогу получить данные");

    echo"
    <form method='post' action=''>
<input type='submit' class='btn btn-light' name='logout' value='Exit'>
</form>
<div>
    <div><pre>
        Hi <b>" . $_SESSION['name'] . "</b> Welcome to AMONIC Airlines Automation System
                                                                     Time spent on system: [hh:mm:ss]
                                                                                                         Number of crashes: [n]</pre>
    </div>
</div>

<div class='p-5'>
<table class=\"table table-hover\">
    <thead class=\"thead-dark\">
    <tr>
        <th scope=\"col\">Date</th>
        <th scope=\"col\">Login Time</th>
        <th scope=\"col\">Logout Time</th>
        <th scope=\"col\">Time spent on system</th>
        <th scope=\"col\">Unsuccessful Logout reason</th>
        
    </tr>
    </thead>
    <tbody>
    ";
        while ($row = $result->fetch_array()) {
            echo"

  <tr>
        <th scope='col'>{$row['date']}</th>
        <th scope='col'>{$row['login']}</th>
        <th scope='col'>{$row['logout']}</th>
        <th scope='col'>{$row['times']}</th>
        <th scope='col'>{$row['reason']}</th>

    </tr> 
    
    
     ";
        }"
</tbody>
</table>
</div>
";

}else
    echo "<div class=\"success\">вы не вошли!</div>
<nav class=\"navbar navbar-expand-sm bg-light navbar-light\">
  <ul class=\"navbar-nav\">
    <li class=\"nav-item active\">
      <a class=\"nav-link\" href=\"reg.php\">Add User</a>
    </li>
    <li class=\"nav-item\">
        <a class=\"nav-link\" href=\"auth.php\">login</a>

    </li>
  </ul>
</nav>";
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
