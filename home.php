<?php 
    session_start();

    try{
        $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
    }catch (Exeption $e){
        die('error on db' . $e->getMessage());
    }

    $query = $database->prepare("SELECT id, url, title FROM video");

    $query->execute();

    $videos = $query->fetchAll();

    $embed = 'embed/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        <?php require('menu_style.php') ?>
        h1{
            padding-top: 40px;
            padding-bottom: 40px;
            text-align: center;
            font-size: 80px;
        }
        h2{
            text-align: center;
        }
        .video{
            width: 304px;
            margin-top:30px;
            margin-left: 50px;
            font-family: sans-serif;
            color: white;
            display:flex;
        }
        iframe{
            border-color: #a5e6ba;
        }
        .button{
            margin-left: 30px;
            margin-top: 20px;
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
    </style>
    <script src="https://kit.fontawesome.com/7806c1eb76.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php require('menu.php') ?>
    </header>  

    <?php if(isset($_SESSION['nickname']) && !empty($_SESSION['nickname'])): ?>
        <h1>Welcome back <?php echo $_SESSION['nickname'] ?></h1>
    <?php else: ?>
        <h1>Hello stranger !</h1>
    <?php endif; ?>

    <?php foreach($videos as $video): ?>
        <div class="video">
            <div> 
                <iframe src="<?php echo(str_replace("watch?v=",$embed , $video['url'])) ?>" frameborder="1"></iframe><br><br>
                <h2><?php echo $video['title'] ?></h2><br>
            </div>
            <div>
                <form action="video.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $video['id'] ?>">
                    <input type="submit" value="Go to video page" class="button">
                </form>
            
                <?php if(isset($_SESSION['nickname'])): ?>
                    <form action="delete.php" method="post">
                        <input type="hidden" name="delete" value="<?php echo $video['id'] ?>">
                        <input type="submit" value="delete this video" class="button">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>