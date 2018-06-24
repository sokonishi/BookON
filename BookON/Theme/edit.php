<?php
  require('dbconnect.php');
  $feed_id = $_GET["feed_id"];

  $sql = "SELECT `feeds`. * ,`users`.`name`, `users`.`img_name` FROM `feeds` LEFT JOIN `users` ON `feeds`.`user_id`=`users`.`id` WHERE `feeds`.`id`=$feed_id";
  $data = array();
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $feeds = $stmt->fetch(PDO::FETCH_ASSOC);
  //HTML内にデータ表示の処理を記述

  if (!empty($_POST)){
    $update_sql = "UPDATE `feeds` SET `title` = ?,`score` = ?, `feed` = ? WHERE `feeds`.`id` = ?";

    $update_data = array($_POST["title"],$_POST["score"],$_POST["feed"],$feed_id);
    $update_stmt = $dbh->prepare($update_sql);
    $update_stmt->execute($update_data);
    
    // 一覧に戻る
    header("Location: index.php");

  }

  $sql = "SELECT `feeds`.*,`users`.`name`,`users`.`img_name` FROM `feeds` LEFT JOIN `users` ON `feeds`.`user_id`=`users`.`id` WHERE `feeds`.`id`=$feed_id";

  // SQL文実行
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $feed = $stmt->fetch(PDO::FETCH_ASSOC);
  

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>BookON</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px;">
  <div class="container">
    <div class="row">
      <!-- ここにコンテンツ -->
      <div class="col-xs-4 col-xs-offset-4">
        <form class="form-group" method="post" style="padding-top: 24px;">

          <img src="user_profile_img/<?php echo $feed["feed_img"]; ?>" width="360"><br>
          <br>
          <h3>タイトル</h3>
          <textarea name="title" class="form-control"><?php echo $feed["title"]; ?></textarea>
          <br>
          <h3>評価</h3>
          <textarea name="score" class="form-control"><?php echo $feed["score"]; ?></textarea>
          <br>
          <h3>感想</h3>
          <textarea name="feed" class="form-control"><?php echo $feed["feed"]; ?></textarea>
          <input type="submit" value="更新" class="btn btn-warning btn-xs">
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>