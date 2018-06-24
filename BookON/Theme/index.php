<?php
  session_start();
  require('dbconnect.php');

  $user_id = $_SESSION['id'];

  //ログインユーザー情報
  $users_sql = 'SELECT * FROM `users` WHERE `id`=?';
  $users_data = array($_SESSION['id']);
  $users_stmt = $dbh->prepare($users_sql);
  $users_stmt->execute($users_data);
  $users_record = $users_stmt->fetch(PDO::FETCH_ASSOC);

  //以降投稿に関して
  $sql = 'SELECT * FROM `feeds` ORDER BY `id` DESC';
  $data = array();
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  while (true) {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($record == false) {
        break;
    }

    //投稿者情報
    $feed_user_sql = 'SELECT `u`.`name`,`u`.`img_name`,`u`.`introduction` FROM `feeds` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id` = `u`.`id` WHERE `f`.`id`=?';
    $feed_user_data = array($record["id"]);
    $feed_user_stmt = $dbh->prepare($feed_user_sql);
    $feed_user_stmt->execute($feed_user_data);
    $record['feed_user'] = $feed_user_stmt->fetch(PDO::FETCH_ASSOC);

      $feeds[] = $record;
  }
          // echo'<pre>';
          // var_dump($feeds);
          // echo'<pre>';



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
    <link href="assets/js/fancybox/jquery.fancybox.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/jquery.js"></script>


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
            <h3><i class="fa fa-angle-right"></i> Gallery</h3>
            <hr>
        <div class="row mt">
          <?php foreach ($feeds as $feed){ ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
            <div class="project-wrapper" style="padding-bottom: 36px;">
              <div class="project">
                  <div class="photo-wrapper">
                    <div class="photo">
                      <a class="fancybox" href="detail.php?feed_id=<?php echo $feed['id']?>"><img class="img-responsive" src="user_profile_img/<?php echo $feed['feed_img'] ?>" alt="" style="height: 222.94px; width: 326.66px;"></a>
                    </div>
                    <div class="overlay"></div>
                  </div>
              </div>
            </div>
          </div><!-- col-lg-4 -->
          <?php } ?>
        </div><!-- /row -->

          </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
              <a href="gallery.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
  <script src="assets/js/fancybox/jquery.fancybox.js"></script>    
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
  
  <script type="text/javascript">
      $(function() {
        //    fancybox
          jQuery(".fancybox").fancybox();
      });

  </script>
  
  <script>
      //custom select box

      $(function(){
          $("select.styled").customSelect();
      });

  </script>

  </body>
</html>
