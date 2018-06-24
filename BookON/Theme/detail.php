<?php

    session_start();
    require('dbconnect.php');
    $feed_id = $_GET['feed_id'];
    //$feed=$_POST['feed'];

    //ユーザー情報
    $users_sql = 'SELECT * FROM `users` WHERE `id`=?';
    $users_data = array($_SESSION['id']);
    $users_stmt = $dbh->prepare($users_sql);
    $users_stmt->execute($users_data);
    $users_record = $users_stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `feeds` WHERE `id`=?';
    $data = array($feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    // $feeds = array()
    // while (true) {
    //   $record = $stmt->fetch(PDO::FETCH_ASSOC);

    //   if ($record == false) {
    //       break;
    //   }

      $like_flag_sql = "SELECT COUNT(*) as `like_flag` FROM `likes` WHERE `user_id`=? AND `feed_id`=?";
      //SQL実行
      $like_flag_data = array($_SESSION['id'],$record["id"]);
      $like_flag_stmt = $dbh -> prepare($like_flag_sql);
      $like_flag_stmt -> execute($like_flag_data);

      //likeしてる数を取得
      $like_flag = $like_flag_stmt -> fetch(PDO::FETCH_ASSOC);

      if($like_flag["like_flag"] > 0){
        $record["like_flag"] = 1;
      } else {
        $record["like_flag"] = 0;
      }

    //}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DASHGUM - Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >

      <!--header start-->
      <?php require('header.php'); ?>
      <!--header end-->

      <!--sidebar start-->
      <?php require('sidebar_left.php'); ?>
      <!--sidebar end-->

      <!--main content start-->
      <section id="main-content">
        <section class="wrapper-top site-min-height">
          <div class="row">
            <div class="col-lg-9">
              <section id="main-content-mypage">
                <section class="wrapper-detail site-min-height">
                  <h3><i class="fa fa-angle-right"></i> Detail</h3>
                  <hr>
                <div class="col-xs-offset-1 col-xs-10 col-sm-12 comment_layer_col">
                  <div class="col-sm-7">
                    <img src="user_profile_img/<?php echo $record['feed_img'] ?>" id="comment_layer_img" style="height: 222.94px; width: 326.66px;">

                    <div class="edit" style="padding-top: 30px;">

                      <?php if ($record["like_flag"] == 0){ ?>
                        <a href="like.php?feed_id=<?php echo $record['id'] ?>">
                          <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-up" aria-hidden="true"></i>お気に入り</button>
                        </a>
                      <?php } else { ?>
                        <a href="unlike.php?feed_id=<?php echo $record['id'] ?>">
                          <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-down" aria-hidden="true"></i>お気に入り解除</button>
                        </a>
                      <?php } ?>

                      <?php if ($record["user_id"] == $_SESSION["id"]){ ?>
                        <a href="edit.php?feed_id=<?php echo $record['id'] ?>" class="btn btn-success btn-xs">編集</a>
                        <a onclick="return confirm('本当に消すか？');" href="delete.php?feed_id=<?php echo $record['id'] ?>" class="btn btn-danger btn-xs">削除</a>
                      <?php } ?>
                    </div>
                  </div>

                    <div class="col-sm-5">
                      <div class="square">
                        <div class="col-xs-offset-1 col-xs-10">
                          <h3><?php echo $record['title'] ?></h3>
                          <h3><?php echo $record['score'] ?></h3>
                          <h4><?php echo $record['feed'] ?></h4>
                        </div>
                      </div>
                    </div>

                </div>
                </section>
            </section><!-- /MAIN CONTENT -->
            </div>
          <?php require('sidebar_right.php'); ?>
          </div><!-- /row -->
      
        </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
              <a href="blank.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
</html></html>