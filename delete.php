<?php 

try{
    $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
}catch (Exeption $e){
    die('error on db' . $e->getMessage());
}

$query = $database->prepare("DELETE FROM `video` WHERE id = :id");

$query->execute([

    'id' => $_POST['delete']

]);

header('Location: home.php')

?>