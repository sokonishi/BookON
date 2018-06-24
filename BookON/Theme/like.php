<?php
    session_start();
    require('dbconnect.php');

    $feed_id=$_GET['feed_id'];

    $sql="INSERT INTO `likes` (`user_id`, `feed_id`) VALUES (?, ?)";
    $data = array($_SESSION['id'],$feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    //一覧に戻る
    header("Location: index.php");

?>