<?php
    session_start();
    require('dbconnect.php');

    $feed_id=$_GET['feed_id'];

    $sql="DELETE FROM `likes` WHERE `user_id` = ? AND `feed_id` = ?";
    $data = array($_SESSION['id'],$feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    //一覧に戻る
    header("Location: index.php");

?>