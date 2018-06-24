<?php
    session_start();
    require('dbconnect.php');

    $errors = array();    //この配列の意味はエラーの種類

    $users_sql = 'SELECT * FROM `users` WHERE `id`=?';
    $users_data = array($_SESSION['id']);
    $users_stmt = $dbh->prepare($users_sql);
    $users_stmt->execute($users_data);
    $users_record = $users_stmt->fetch(PDO::FETCH_ASSOC);

    if(!isset($_SESSION['mcteam'])) {
    //正規のルートから遷移していない場合
      header("Location:post.php");
      exit();
    }

   // ①
    $title = $_SESSION['mcteam']['title'];
    $feed = $_SESSION['mcteam']['feed'];
    $score = $_SESSION['mcteam']['score'];
    $img_name = $_SESSION['mcteam']['img_name'];

    // 登録ボタンが押された時の処理 = POSTがからじゃない

    if(!empty($_POST)) {
        // 1.DB実行
        require('dbconnect.php');

        // 2.SQL文実行
        $sql = 'INSERT INTO `feeds` SET `feed`=?, `title`=?, `score`=?, `feed_img`=?, `user_id` = ?,`created`=NOW()';
        $data = array($feed, $title, $score, $img_name, $_SESSION['id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // 3. データベース切断
         $dbh = null;

        unset($_SESSION['mcteam']);
        //var_dump($_SESSION['register']);
        header('Location: index.php');
        exit();
    }
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
          <section class="wrapper site-min-height">

            <div class="container">
              <div class="row">
                <div class="col-sm-12">
                <h2 class="text-center content_header">投稿確認</h2>
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="card_item">
                          <img style="width: 100%" src="user_profile_img/<?php echo htmlspecialchars($img_name); ?>" class="img-responsive img-tumbnail">
                        </div><!-- /card_item -->
                      </div>
                      <div class="col-sm-6">
                        <h4 class="lead"><?php echo htmlspecialchars($title); ?></h4>
                        
                        <h4 class="lead"><?php echo htmlspecialchars($score); ?></h4>

                        <div style="width: 75%; overflow: auto;">
                          <p class="lead"><?php echo htmlspecialchars($feed); ?></p>
                        </div>

                      </div>
                    </div><!-- /row -->
                  </div><!-- /container -->
                  <div class="container">
                    <div class="row text-center" style="margin-top: 50px;">
                      <form method="POST" action="">
                        <a href="post.php" class="btn" onclick="history.back()">&laquo;&nbsp;戻る</a>
                        <input type="hidden" name="action" value="submit">
                        <input type="submit" class="btn btn-primary" value="登録">
                      </form>
                    </div><!-- /row -->
                  </div><!-- /container -->
                </div>
              </div><!-- /row -->
            </div><!-- /container -->
      
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
