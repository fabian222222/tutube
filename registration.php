<?php

$mail_validator = '/^[a-z0-9][a-z0-9._-]*@[a-z0-9_-]{2,}(\.[a-z]{2,4}){1,2}$/';
$username_validator = "/^([a-zA-Z' ]+)$/";

if(isset($_POST['username'])){
    $username = htmlspecialchars($_POST['username']);
}
if(isset($_POST['mail'])){
    $mail = htmlspecialchars($_POST['mail']);
}
if(isset($_POST['password'])){ 
    $password = htmlspecialchars($_POST['password']);
}

if(isset($_POST['username'])){
    try{
        $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
    }catch (Exeption $e){
        die('error on db' . $e->getMessage());
    }
    $query = $database->prepare("SELECT nickname FROM user WHERE nickname = :username");

        $query->execute([

            'username' => $_POST['username']

        ]);

    $users_nickname = $query->fetch();
}

if(isset($_POST['mail'])){
    try{
        $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
    }catch (Exeption $e){
        die('error on db' . $e->getMessage());
    }
    $query = $database->prepare("SELECT mail FROM user WHERE mail = :mail");

        $query->execute([

            'mail' => $_POST['mail']

        ]);

    $users_mail = $query->fetch();
}

if(isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['password'])){

    if(preg_match($username_validator, $username) && strlen($username) >= 4 && strlen($username) < 50 && preg_match($mail_validator,$mail) && $mail != "" && strlen($mail) < 256 && strlen($password) >= 9 && strlen($password) < 256){

        if(!$users_nickname && !$users_mail){

            try{
                $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
            }catch (Exeption $e){
                die('error on db' . $e->getMessage());
            }
            $query = $database->prepare("INSERT INTO `user`(`nickname`, `mail`, `password`) VALUES ( :nickname, :mail, :password1)");

                $query->execute([

                    'nickname' => $_POST['username'],
                    'mail' => $_POST['mail'],
                    'password1' => $_POST['password']

                ]);

            $user = $query->fetch();
    
        } 

    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration</title>
    <style>
        <?php require('menu_style.php') ?>
        form{
            margin-top: 25vh;
            margin-left: 38%;
            background: #390084;
            width:150px;
            padding-left: 40px;
            padding-right: 100px;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        #username, #mail, #password{
            width:200px;
            height:30px;
        }
        .button{
            margin-left: 30px;
            margin-top: 10px;
            background-color: #aa7bc3;
            width:130px;
            height:35px;
            border: none;
            background: linear-gradient(#AA7BC4, #9a74b2);
            box-shadow:-2px 1px 0px 1px rgba(0,0,0,0.26);
        }
        .button:hover{
            box-shadow: none;
            background: #9a74b2;
        }
        .success{
            color: #fff;
            text-align: center;
            font-family: sans-serif;
            font-size: 20px;
        }
    </style>
    <script src="https://kit.fontawesome.com/7806c1eb76.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php require('menu.php') ?>
    </header>

    <?php if(isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['password'])): ?>
        <?php if(preg_match($username_validator, $username) && strlen($username) >= 4 && strlen($username) < 50 && preg_match($mail_validator,$mail) && $mail != "" && strlen($mail) < 255 && strlen($password) >= 9 && strlen($password) < 255): ?>
            <p class="success">You get registered with success, now try to connect</p>
        <?php endif; ?>
    <?php endif; ?>
    
    <form action="#" method="post">

        <input type="text" name="username" id="username" placeholder="username :">
        <?php if(isset($_POST['username'])): ?>
            <?php if(!preg_match($username_validator, $username) || strlen($username) < 4 || strlen($username) > 50): ?> 
                <p>This field is not valid</p>
            <?php endif; ?>
            <?php if($users_nickname): ?>
                <p>This username exist already</p>
            <?php endif; ?>
        <?php endif; ?>    
        <br><br>

        <input type="mail" name="mail" id="mail" placeholder="email :">
        <?php if(isset($_POST['mail'])): ?>
            <?php if(!preg_match($mail_validator,$_POST['mail']) || strlen($mail) == 0 || strlen($mail) > 255): ?> 
                <p>This field is not valid</p>
            <?php endif; ?>
            <?php if($users_mail): ?>
                <p>This mail exsit already</p>
            <?php endif; ?>
        <?php endif; ?>   
        <br><br>

        <input type="password" name="password" id="password" placeholder="paswword :">
        <?php if(isset($_POST['password'])): ?>
            <?php if(strlen($password) < 9 || strlen($password) > 255): ?> 
                <p>This field is not valid</p>
            <?php endif; ?>
        <?php endif; ?>   
        <br><br>

        <input type="submit" class="button" value="Register">

    </form>
</body>
</html>