<div>
    <a href="home.php"><p class="tutube"><span class="header_logo"><i class="fab fa-youtube"></i></span>TuTube</p></a>
</div>
<div>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="add_video.php">add video</a></li>
        <?php if(empty($_SESSION['nickname'])): ?>
        <li><a href="registration.php">register</a></li>
        <li><a href="connection.php">connection</a></li>
        <?php elseif(isset($_SESSION['nickname'])): ?>
        <li><a href="deconnection.php">deconnection</a></li>
        <?php endif; ?>
    </ul>
</div>