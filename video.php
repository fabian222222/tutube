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

    try{
        $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
    }catch (Exeption $e){
        die('error on db' . $e->getMessage());
    }

    $query = $database->prepare("SELECT id, url, title, comment FROM video WHERE id = :id");

    $query->execute([

        "id" => $_POST["id"]

    ]);

    $video = $query->fetch();

    if(isset($title) && $title != ""){
        try{
            $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
        }catch (Exeption $e){
            die('error on db' . $e->getMessage());
        }

        $query = $database->prepare("UPDATE `video` SET `title`= :title WHERE id = :id");

        $query->execute([

            'id' => $_POST['id'],
            'title' => $_POST['title']

        ]);

    }

    if(isset($link) && $link != "" && preg_match($link_validator, $link)){

        try{
            $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
        }catch (Exeption $e){
            die('error on db' . $e->getMessage());
        }

        $query = $database->prepare("UPDATE `video` SET `url`= :url WHERE id = :id");

        $query->execute([

            'id' => $_POST['id'],
            'url' => $_POST['link']

        ]);

    }

    if(isset($description) && $description != ""){

        try{
            $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
        }catch (Exeption $e){
            die('error on db' . $e->getMessage());
        }

        $query = $database->prepare("UPDATE `video` SET `comment`= :comment WHERE id = :id");

        $query->execute([

            'id' => $_POST['id'],
            'comment' => $_POST['description']

        ]);

    }

    $embed = 'embed/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>video</title>
    <style>
        <?php require('menu_style.php') ?>
        textarea{
            width: 15%;
            resize: vertical;
        }
        iframe{
            margin-top: 50px;
            margin-left: 30px;
            border-color: #a5e6ba;
        }
        .video2 > div{
            display:flex;
        }
        h2{
            margin-top: 50px;
            margin-left: 20px;
            font-family: sans-serif;
            color: #fff;
        }
        .comment{
            margin-left: 20px;
            font-family: sans-serif;
            color: #fff;
            font-size: 20px;
        }
        .button{
            margin-left: 20px;
            margin-top: 45px;
            background-color: #aa7bc3;
            width:150px;
            height:35px;
            border: none;
            background: linear-gradient(#AA7BC4, #9a74b2);
            box-shadow:-2px 1px 0px 1px rgba(0,0,0,0.26);
        }
        .button:hover{
            box-shadow: none;
            background: #9a74b2;
        }
        .form2{
            margin-top: 50px;
            margin-left: 30px;
            background: #390084;
            width:162px;
            padding-left: 40px;
            padding-right: 100px;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        #title, #link, #description{
            width:200px;
            height:30px;
        }
    </style>
     <script src="https://kit.fontawesome.com/7806c1eb76.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php require('menu.php') ?>
    </header>  
    <div class="video">
        <div class="video2">
            <div>
                <iframe src="<?php echo(str_replace("watch?v=",$embed , $video['url'])) ?>" frameborder="1"></iframe><br><br>
                <div>
                    <h2><?php echo $video['title'] ?></h2><br>
                    <div class="comment"><?php echo $video['comment'] ?></div>
               
                    <?php if(isset($_SESSION['nickname'])): ?>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="delete" value="<?php echo $video['id'] ?>">
                            <input type="submit" class="button" value="delete this video">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['nickname'])): ?>
    <form action="#" method="post" class=form2>
        <input type="hidden" name="id" value="<?php echo $video['id'] ?>">
        <input type="text" name="title" id="title" placeholder="Change title :">
        <?php if(isset($title)): ?>
            <?php if(strlen($title) > 100): ?>
                <p>Title is too long</p>
            <?php elseif(!empty($title) && strlen($title) < 101): ?>
                <p>Go to home page and see the new title !</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>
        <input type="text" name="link" id="link" placeholder="Change link :">
        <?php if(isset($link)): ?>
            <?php if(!empty($link) && !preg_match($link_validator, $link) || strlen($link) > 255): ?>
                <p>Link is not valid</p>
            <?php elseif(!empty($link) && strlen($link) < 255 && preg_match($link_validator, $link)): ?>
                <p>Go to home page and see the new video !</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>
        <textarea name="description" id="description" placeholder="Change description"></textarea>
        <?php if(isset($description)): ?>
            <?php if(empty($description)): ?>
                <p></p>
            <?php else: ?>
                <p>Go to home page and come back to see the new description !</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>
        <input type="submit" class="button" value="Update video">
    </form>
    <?php endif; ?>
</body>
</body>
</html>