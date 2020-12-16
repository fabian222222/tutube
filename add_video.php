<?php 
    session_start();

    if(isset($_POST['title'])){
        $title = htmlspecialchars($_POST['title']);
    }
    if(isset($_POST['link'])){
        $link = htmlspecialchars($_POST['link']);
    }
    if(isset($_POST['description'])){
        $description = htmlspecialchars($_POST['description']);
    }

    $link_validator = '/(https?|ftp|ssh|mailto):\/\/[a-z0-9\/:%_+.,#?!@&=-]+/';

    if(isset($title) && !empty($title) && strlen($title) < 101 && isset($link) && !empty($link) && strlen($link) < 256 && preg_match($link_validator, $link) && isset($description)  && !empty($description) ){

        try{
            $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
        }catch (Exeption $e){
            die('error on db' . $e->getMessage());
        }
        $query = $database->prepare("SELECT url FROM video WHERE url = :url ");
    
            $query->execute([
    
                'url' => $link
    
            ]);
    
        $link_search = $query->fetch();

        if($link_search){

            echo 'This video is already existing';

        }else{

            try{
                $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
            }catch (Exeption $e){
                die('error on db' . $e->getMessage());
            }
            $query = $database->prepare("INSERT INTO `video`(`title`, `url`, `comment`) VALUES (:title, :link, :comment)");
        
                $query->execute([
        
                    'title' => $title,
                    'link' => $link,
                    'comment' => $description
        
                ]);
        
            $video = $query->fetch();

        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add video</title>
    <style>
        <?php require('menu_style.php') ?>
        textarea{
            width: 100%;
            resize: vertical;
        }
        form{
            margin-top: 25vh;
            margin-left: 39%;
            background: #390084;
            width:150px;
            padding-left: 40px;
            padding-right: 100px;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        #title, #link, #description{
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

    <?php if(isset($title) && !empty($title) && strlen($title) < 101 && isset($link) && !empty($link) && strlen($link) < 256 && preg_match($link_validator, $link) && isset($description)  && !empty($description)): ?>
        <?php if($link_search): ?>
            <p class="success">This video is already existing</p>
        <?php else: ?>
            <p class="success">Video upload with success</p>
        <?php endif; ?>
    <?php endif; ?>

    <form action="#" method="post">

        <input type="text" name="title" id="title" placeholder="Title :">
        <?php if(isset($title)): ?>
            <?php if(empty($title) || strlen($title) > 100): ?>
                <p>Please enter a validate title</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>

        <input type="text" name="link" id="link" placeholder="Link :">
        <?php if(isset($link)): ?>
            <?php if(empty($link) || strlen($link) > 255): ?>
                <p>Please enter a validate link</p>
            <?php endif; ?>
            <?php if(!preg_match($link_validator, $link) && !empty($link)): ?>
                <p>Please enter a validate link in url format</p>
            <?php  endif; ?>
        <?php endif; ?>
        <br><br>

        <textarea name="description" id="description" placeholder="Description :"></textarea>
        <?php if(isset($description)): ?>
            <?php if(empty($description)): ?>
                <p>Please enter a validate description</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>

        <input type="submit" class="button" value="Add video">
        
    </form>
</body>
</html>