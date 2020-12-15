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
    header("Refresh: 1; url=?");
    echo  '<div class="success">Выход успешно выполнен!</div>';
    session_destroy();

}
if (!isset($_SESSION['id'])){
    echo "вы не авторизованы";
    header("Refresh: 1; auth.php");

}
$query = "SELECT users.ID, users.Email, users.FirstName, users.LastName,users.Birthdate,roles.Title as Rol,offices.Title 
FROM " .TABLE_USER." inner JOIN " .TABLE_ROLE." ON users.RoleID = roles.ID inner JOIN " .TABLE_OFFICES." ON users.OfficeID = offices.ID";
$result = $db->query($query)
    or die ("не удалось получить данные");
$now = new DateTime('now');


?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <form method="post" action="">
<nav class="navbar navbar-expand-sm bg-light navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="reg.php">Add User</a>
    </li>
    <li class="nav-item">
      <input type="submit" class="btn btn-light" name="logout" value="Exit">
    </li>
  </ul>
</nav>

<div class="p-5">



    <label for="btnGroupDrop1">Office: </label>
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            All offices
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="#">Abu dhabi</a>
            <a class="dropdown-item" href="#">Cairo</a>
            <a class="dropdown-item" href="#">Bahrain</a>
            <a class="dropdown-item" href="#">Doha</a>
            <a class="dropdown-item" href="#">Riyadh</a>

        </div>
    </div>



<table class="table table-hover">
    <thead class="thead-dark">
    <tr>
        <th scope="col">id</th>
        <th scope="col">Имя</th>
        <th scope="col">Фамилия</th>
        <th scope="col">age</th>
        <th scope="col">User Role</th>
        <th scope="col">email</th>
        <th scope="col">office</th>
    </tr>
    </thead>
    <tbody>
<?php
while ($row = $result->fetch_array()){
    $interval = $now->diff( new DateTime($row['Birthdate']));
    echo "
   
    <tr>
        <th scope='row'>{$row['ID']}</th>
        <td>{$row['FirstName']}</td>
        <td>{$row['LastName']}</td>
        <td>{$interval->format('%y')}</td>
        <td>{$row['Rol']}</td>
        <td>{$row['Email']}</td>
        <td>{$row['Title']}</td>
    </tr>";
 } ?>
    </tbody>
</table>
    <input type="submit" value="Chenge Role">
    <input type="submit" value="Enable/Disable Login">

</div>
</form>



