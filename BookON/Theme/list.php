<?php 

    session_start();
    require('dbconnect.php');

    //ユーザー情報
    $users_sql = 'SELECT * FROM `users` WHERE `id`=?';
    $users_data = array($_SESSION['id']);
    $users_stmt = $dbh->prepare($users_sql);
    $users_stmt->execute($users_data);
    $users_record = $users_stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT `l`.*, `f`.* FROM `likes` AS `l` LEFT JOIN `feeds` AS `f` ON `l`.`feed_id` = `f`.`id` WHERE `l`.`user_id`= ? ORDER BY `l`.`id` DESC ';
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

    <title>BookON</title>

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
    <link href="bookon.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
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
                  
<!--                     <div class="row mtbox">
                      <div class="col-md-3 col-sm-3 col-md-offset-2">
                        <img class="" src="user_profile_img/?php echo $users_record['img_name'] ?>" alt="" style="height: 200px; width: 200px;">
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="box1">
                          <span class="li_cloud"></span>
                          <p>?php echo $users_record['introduction'] ?></p>
                        </div>
                      </div>                    
                    </div> -->
                  
                      
      <section id="main-content-mypage">
          <section class="wrapper-list site-min-height">
            <h3><i class="fa fa-angle-right"></i> List&emsp;〜お気に入りの本・読みたい本〜</h3>
            <hr>
        <div class="row mt">
        <?php if(isset($feeds)){ ?>
          <?php foreach ($feeds as $feed){ ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
            <div class="project-wrapper" style="padding-bottom: 36px;">
              <div class="project card_hover card-parent">
                  <div class="photo-wrapper">
                    <!-- <div class="photo"> -->
                      <a class="fancybox" href="detail.php?feed_id=<?php echo $feed['id']?>">
                        <img class="img-responsive" src="user_profile_img/<?php echo $feed['feed_img'] ?>" alt="" style="height: 222.94px; width: 326.66px;">

                        <div class="card_contents card_children">
                          <div class="feed_title"><h3>『<?php echo $feed["title"] ?>』</h3></div>
                          <div class="feed_square"><h3><?php echo $feed["score"] ?>点</h3></div>
                        </div>

                      </a>
                    <!-- </div> -->
                    <div class="overlay"></div>
                  </div>
              </div>
            </div>
          </div><!-- col-lg-4 -->
          <?php } ?>
        <?php }?>
        </div><!-- /row -->

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
    <script src="bookon.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
  <script src="assets/js/zabuto_calendar.js"></script>  
  
<!--   <script type="text/javascript">
        $(document).ready(function () {
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Welcome to Dashgum!',
            // (string | mandatory) the text inside the notification
            text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for <a href="http://blacktie.co" target="_blank" style="color:#ffd777">BlackTie.co</a>.',
            // (string | optional) the image to display on the left
            image: 'assets/img/ui-sam.jpg',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'my-sticky-class'
        });

        return false;
        });
  </script>
  
  <script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script> -->
  

  </body>
</html>
