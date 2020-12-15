<?php
require_once "db.php";
if (isset($_POST['save'])) {
    $role = 2;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $office = $_POST['office'];


    if (!empty($email) && !empty($password) && !empty($firstname) && !empty($lastname)){
        $query = " SELECT * FROM " . TABLE_USER . " WHERE `Email` = '{$email}'";
        $result = $db->query($query) or die ("немогу получить данные пользователей");
        if ($result->num_rows == 1){
            echo "такой емаил уже существует";
        }else {
            $query = "INSERT INTO " . TABLE_USER . "(`RoleID`,`Email`,`Password`,`FirstName`,`LastName`,`Birthdate`,`OfficeID`)
         VALUES ('$role','$email','$password','$firstname','$lastname','$birthday','$office')";

            $db->query($query)
            or die("can`t insert");
            echo "вы успешно зарегались";

            header("Location: userlist.php");
        }
    }else
        echo ("не все поля заполнены или не выбран офис");

}






?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


<div class="container mt-3 pb-2" style="outline: 2px solid black;width: 550px">
    <div class="row">
        <div class="col-md-auto col-md-offset-3">
            <h3 class="text-center">Добавление нового пользователя</h3>
            <form action="reg.php" method="post" class="form-group mb-auto" style="width: auto; padding: 25px 0 0;">
                <div class="col-xs-auto">
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Введите email" />
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="email">password</label>

                        <input type="password" name="password" class="form-control" placeholder="Ваш пароль" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">firstname</label>
                    <input type="text" id="email" name="firstname" class="form-control" placeholder="Введите имя" />
                </div>
                <div class="form-group">
                    <label for="email">lastname</label>
                    <input type="text" id="email" name="lastname" class="form-control" placeholder="Введите фамилию" />
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">office</label>
                    <select class="form-control" name="office" id="exampleFormControlSelect1">
                        <option>office name</option>
                        <option value="1">abu dhabi</option>
                        <option value="3">cairo</option>
                        <option value="6">Riyadh</option>
                        <option value="5">Doha</option>
                        <option value="4">Bahrain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">дата рождения</label>
                    <input type="date" name="birthday" class="form-control" placeholder="Выберите дату своего рождения" />
                </div>
<div class="btn-group">
                <div class="text-center">
                    <input type="submit" name="save" class="btn btn-primary" value="Save" />
                </div>
</div>
    <div class="btn-group">
                <div class="text-center">
                    <input type="button" name="cancel" onclick="history.back();" class="btn btn-primary" value="Cancel" />
                </div>
</div>
            </form>

        </div>
    </div>
