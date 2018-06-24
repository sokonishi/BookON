<?php
    session_start();
    require('dbconnect.php');

    $errors = array();

    $users_sql = 'SELECT * FROM `users` WHERE `id`=?';
    $users_data = array($_SESSION['id']);
    $users_stmt = $dbh->prepare($users_sql);
    $users_stmt->execute($users_data);
    $users_record = $users_stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST)) {
        $introduction = $_POST['input_introduction'];
        if ($introduction == '') {
            $errors['introduction'] = 'blank';
        }

        //画像名を取得
        $file_name = $_FILES[
          'input_img_name']['name'];
          if(!empty($file_name)) {
            $file_type = substr($file_name, -4);
            $file_type = strtolower($file_type);
            if( $file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
              //エラーの時の処理
              $errors['img_name'] = 'type';
            }
          }
          else {
            $file_name=$users_record["img_name"];
          }

          if(empty($errors)) {
            $submit_file_name = $file_name;
            echo $submit_file_name;
            move_uploaded_file($_FILES['input_img_name']['tmp_name'], 'user_profile_img/'.$submit_file_name);


            $sql = 'UPDATE `users` SET `img_name`=?, `introduction`=? WHERE `id`=?';
            $data = array($file_name, $introduction, $_SESSION["id"]);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            header('Location:profile.php');
            exit();
          }
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

                    <form method='POST' action='edit_profile.php' enctype="multipart/form-data">
                      <div class="col-xs-12">
                        <div class="form-group">
                          <h3 for="img_name">写真</h3>
                          <input type="file" name="input_img_name" id="img_name">
                          <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type') { ?>
                            <p class="text-danger">拡張子が「jpg」「png」「gif」「jpeg」の画像を選択してください</p>
                          <?php } ?>
                          <h3>自己紹介</h3>
                          <textarea name="input_introduction" class="form-control" cols="65" rows="5"></textarea>
                          <?php if(isset($errors['introduction']) && $errors['introduction'] == 'blank') { ?>
                            <p style="color: red;">自己紹介文を入力してください</p>
                          <?php } ?>
                      </div><!-- /form_group -->
                      <input type="submit" class="btn btn-primary" value="保存">
                    </form>

                  </div><!-- /col-lg-9 END SECTION MIDDLE -->
              </div>
            <?php require('sidebar_right.php'); ?>
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


