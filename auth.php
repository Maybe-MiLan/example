<?php
require_once "db.php";


if (isset($_POST['login'])) {
    if (isset($_SESSION['id'])) {
        echo "вы не можите авторизоваться повторно";
        if($_SESSION['id'] == 1){
            header("Refresh: 1; adminlist.php");

        }
        header("Refresh: 1; userlist.php");
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (!empty($email) && !empty($password)) {
            $query = " SELECT * FROM " . TABLE_USER . " WHERE `Email`='{$email}' AND  `Password` ='{$password}'";
            $result = $db->query($query)
            or die ("не удалось получить запись");
            if ($result->num_rows == 1) {
                echo "вы успешно авторизовались";
                $row = $result->fetch_array();
                $_SESSION['id'] = $row['ID'];
                $_SESSION['name'] = $row['FirstName'] . " " . $row['LastName'];
                $_SESSION['role'] = $row['RoleID'];

                $query = " INSERT INTO `timelog` (`userid`,`date`,`login`) VALUES ({$_SESSION['id']},'$dat','$obg')";
                $db->query($query)
                or die ("не удалось записать вход");
                $query = " UPDATE `users` SET `Active` = 1 WHERE `ID`={$_SESSION['id']}";
                $db->query($query)
                or die ("не удалось записать вход");

                if ($_SESSION['role'] == 1){

                    header('Location: adminlist.php');
                }else
                    header('Location: userlist.php');


            } else
                echo "пользователь не найден";

        } else
            echo "не все данные введены";
    }
}

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<div class="container mt-3 pb-2" style="outline: 2px solid black;width: 550px">
    <div class="form-horizontal">
        <div class="col-md-auto">
            <h3 class="text-center">Авторизация</h3>
            <div align="center">
            <img src="Images/DS2017_TP09_color.png">
            </div>
            <form action="auth.php" method="post" class="form-horizontal" style="padding: 25px 0 0;">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" name="email" placeholder="email" class="form-control" id="staticEmail">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                </div>
                <div class="btn-group ">
                    <div class="text-center">
                        <input type="submit" name="login" class="btn btn-primary" value="Login" />
                    </div>
                </div>
                <div class="btn-group">
                    <div class="text-center">
                        <input type="button" onclick="history.back();" name="exit" class="btn btn-primary" value="Exit" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
