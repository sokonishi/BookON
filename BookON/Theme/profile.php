<?php 

    session_start();
    require('dbconnect.php');

    //本人情報
    $users_sql = 'SELECT * FROM `users` WHERE `id`=?';
    $users_data = array($_SESSION['id']);
    $users_stmt = $dbh->prepare($users_sql);
    $users_stmt->execute($users_data);
    $users_record = $users_stmt->fetch(PDO::FETCH_ASSOC);


    $sql = 'SELECT * FROM `feeds`  WHERE `user_id`= ? ORDER BY `id` DESC ';
    $data = array($_SESSION['id']);
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
         //  var_dump($feeds);
         //  echo'<pre>';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DASHGUM - FREE Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    
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
          <section class="wrapper">
              <div class="row">
                  <div class="col-lg-9 main-chart">
      <section id="main-content-mypage">
          <section class="wrapper-list site-min-height">
            <h3><i class="fa fa-angle-right"></i> Profile</h3>
            <hr>
<!--         <div class="row mt">
        ?php if(isset($feeds)){ ?>
          ?php foreach ($feeds as $feed){ ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
            <div class="project-wrapper" style="padding-bottom: 36px;">
              <div class="project">
                  <div class="photo-wrapper">
                      <div class="photo">
                        <a class="fancybox" href="detail.php?feed_id=?php echo $feed['id']?>"><img class="img-responsive" src="user_profile_img/?php echo $feed['feed_img'] ?>" alt="" style="height: 222.94px; width: 326.66px;"></a>
                      </div>
                      <div class="overlay"></div>
                  </div>
              </div>
            </div>
          </div>
          ?php } ?>
        ?php }?>
        </div> -->

<!--         <div class="container">
        ?php foreach ($users as $user) { ?>
        
          <div class="row">
            <div class="col-xs-12">
      
                <div class="thumbnail">
                  <div class="row">
                    <div class="col-xs-1">
                      <img src="user_profile_img/?php echo $user["img_name"]; ?>" width="80">
                    </div>
                    <div class="col-xs-11">
                      名前 ?php echo $user["name"]; ?><br>
                      <a href="profile.php?user_id=?php echo $user["id"]; ?>" style="color: #7F7F7F;">?php echo $user["created"]; ?>からメンバー</a>
                    </div>
                  </div>
                  
                  <div class="row feed_sub">
                    <div class="col-xs-12">
                      <span class="comment_count">つぶやき数 : ?php echo $user["feed_cnt"]; ?></span>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        ?php } ?>
        </div> -->
            <div class="row mtbox">
              <div class="col-md-3 col-sm-3 col-md-offset-2">
                <img class="" src="user_profile_img/<?php echo $users_record['img_name'] ?>" alt="" style="height: 180px; width: 180px;">
              </div>
              <div class="col-md-5 col-sm-5">
                <a class="edit_profile" href="edit_profile.php">プロフィールを編集</a><br><br>
                <p><?php echo $users_record['introduction'] ?></p>
              </div>                    
            </div><!-- /row mt -->  

          </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
          
                  </div><!-- /col-lg-9 END SECTION MIDDLE -->
                  
      <?php require('sidebar_right.php'); ?>

              </div><! --/row -->
          </section>
      </section>

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
              <a href="index.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
  <script src="assets/js/zabuto_calendar.js"></script>  
  </body>
</html>
