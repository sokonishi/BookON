<?php
    session_start();
    require('dbconnect.php');

    $errors = array();    //この配列の意味はエラーの種類

    $users_sql = 'SELECT * FROM `users` WHERE `id`=?';
    $users_data = array($_SESSION['id']);
    $users_stmt = $dbh->prepare($users_sql);
    $users_stmt->execute($users_data);
    $users_record = $users_stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST)) {   //POST送信があった時に以下を実行する
        $title = $_POST['input_title'];
        $feed = $_POST['input_feed'];
        $score = $_POST['input_score'];

        // 半角数字チェック
        if (!ctype_digit($score)) {
            $errors['score'] = 'digit';
        }
        // 内容の空チェック
        if ($title == '') {
            $errors['title'] = 'blank';
        }
        elseif($feed == ''){
            $errors['feed'] = 'blank';
        }

        if ($score == '') {
            $errors['score'] = 'blank';
        }elseif($score < 0 || $score > 100){
            $errors['score'] = 'over';
        }

          //var_dump($_FILES,$_POST);
          //exit();
        //画像名を取得
        $file_name = $_FILES[
          'input_img_name']['name'];
          if(!empty($file_name)) {
            //拡張子チェック
            $file_type = substr($file_name, -4);
            //画像の後ろから小文字4文字
            $file_type = strtolower($file_type);
            //比較するために取得した拡張子を小文字に変換する
            //var_dump($file_name);
            //exit();

            if( $file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
              //エラーの時の処理
              $errors['img_name'] = 'type';
            }
          }
          else {
            //ファイルがないときの処理
            $errors['img_name']='blank';
          }

          //echo $file_name."<br>"

          if(empty($errors)) {
            //エラーがなかった時の取得
            date_default_timezone_set('Asia/Manila');   //フィリピン時間に設定
            $date_str = date('YmdHis');
            //この行を実行した日時を取得
            $submit_file_name = $date_str.$file_name;
            echo $date_str;
            echo "<br>";
            echo $submit_file_name;
            //move_uploaded_file(テンポラリパス、保存したい場所、ファイル名)

            move_uploaded_file($_FILES['input_img_name']['tmp_name'], 'user_profile_img/'.$submit_file_name);

            //var_dump($_FILES);
            //exit();
            //$_SESSIONサーバーに保存されるスーパーグローバル変数
            //ログインしていることのユーザー情報などを保存しておくことが多い

            $_SESSION['mcteam']['title'] = $_POST['input_title'];
            $_SESSION['mcteam']['feed'] = $_POST['input_feed'];
            $_SESSION['mcteam']['score'] = $_POST['input_score'];
            $_SESSION['mcteam']['img_name'] = $submit_file_name;

            header('Location:post_conform.php');
            exit();
          }
    }

    // PHPプログラム
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
            <div class="container">
              <div class="row space_timeline">
                <div class="col-xs-offset-1 col-xs-10">
                  <form method='POST' action='post.php' enctype="multipart/form-data">
                    <div class="form-group">

                      <h3 for="img_name">写真</h3>
                        <input type="file" name="input_img_name" id="img_name">
                          <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type') { ?>
                            <p class="text-danger">拡張子が「jpg」「png」「gif」「jpeg」の画像を選択してください</p>
                          <?php } ?>
                          <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank') { ?>
                            <p class="text-danger">画像を選択してください</p>
                          <?php } ?>

                      <h3>題名</h3>
                        <input type="text" name="input_title" placeholder="名前を入力してください" style="width:300px">
                          <?php if(isset($errors['title']) && $errors['title'] == 'blank') { ?>
                            <p class="text-danger">題名を入力してください</p>
                          <?php } ?>

                      <h3>評価</h3>
                        <div class="side_by_side">
                          <input class="form-control" type="text" name="input_score" placeholder="0~100点で評価" style="width: 300px">
                          <a class="noline jpy" href="https://info.finance.yahoo.co.jp/fx/detail/?code=usdjpy" style="font-size: 15px;"></a>
                        </div>
                          <?php if(isset($errors['score']) && $errors['score'] == 'blank') { ?>
                            <p class="text-danger">価格を設定してください</p>
                          <?php } ?>
                          <?php if(isset($errors['score']) && $errors['score'] == 'digit') { ?>
                            <p class="text-danger">半角数字で入力してください</p>
                          <?php } ?>
                          <?php if(isset($errors['score']) && $errors['score'] == 'over') { ?>
                            <p class="text-danger">100点満点で評価して下さい</p>
                          <?php } ?>

                      <h3>内容</h3>
                        <textarea class="form-control" name="input_feed" cols="65" rows="3"></textarea>
                          <?php if(isset($errors['feed']) && $errors['feed'] == 'blank') { ?>
                            <p class="text-danger">内容を入力してください</p>
                          <?php } ?>

                    </div><!-- /form-group -->
                    <input class="btn btn-primary" type="submit" value="送信">
                  </form>
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
