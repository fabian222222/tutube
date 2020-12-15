<?php

    session_start();

    $mail_validator = '/^[a-z0-9][a-z0-9._-]*@[a-z0-9_-]{2,}(\.[a-z]{2,4}){1,2}$/';

    if(isset($_POST['mail'])){
        $mail = htmlspecialchars($_POST['mail']);
    }
    if(isset($_POST['password'])){
        $password = htmlspecialchars($_POST['password']);
    }

    if(isset($_POST['mail']) && isset($_POST['password'])){

        if(preg_match($mail_validator,$mail) && strlen($password) > 9){

            try{
                $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
            }catch (Exeption $e){
                die('error on db' . $e->getMessage());
            }

            $query = $database->prepare("SELECT password, nickname FROM user WHERE mail = :mail");

            $query->execute([
    
                'mail' => $_POST['mail']
    
            ]);
    
            $users_password = $query->fetch();

            if($users_password){

                if($password == $users_password['password']){

                    $_SESSION['nickname'] = $users_password['nickname'];
                    header('Location: Home.php');

                }elseif($password != $users_password['password']){

                    echo 'The password is wrong !';

                }

            }else{

                echo 'This email doesn\'t exist';

            }

        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connection</title>
    <style>
        <?php require('menu_style.php') ?>
        form{
            margin-top: 25vh;
            margin-left: 37%;
            background: #390084;
            width:150px;
            padding-left: 40px;
            padding-right: 100px;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        #mail, #password{
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
    </style>
    <script src="https://kit.fontawesome.com/7806c1eb76.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php require('menu.php') ?>
    </header>  
    <form action="#" method="post">

        <input type="mail" name="mail" id="mail" placeholder="Enter mail">
        <?php if(isset($_POST['mail'])): ?>
            <?php if(strlen($_POST['mail']) == 0):?>
                <p>Please fill this field</p>
            <?php endif; ?>
            <?php if(!preg_match($mail_validator,$mail) && strlen($_POST['mail']) > 0):?>
                <p>Please respect the mail format</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>

        <input type="password" name="password" id="password" placeholder="Enter Password">
        <?php if(isset($_POST['password'])): ?>
            <?php if(strlen($_POST['password']) == 0):?>
                <p>Please fill this field</p>
            <?php endif; ?>
            <?php if((strlen($_POST['password'])) < 9 && strlen($_POST['password']) > 0): ?>
               <p>The password is too short</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>

        <input type="submit" class="button" value="Login">

    </form>
</body>
</html>