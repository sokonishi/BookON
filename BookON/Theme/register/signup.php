<?php
    session_start();
    $errors = array();

    if (!empty($_POST)) {
        $name = $_POST['input_name'];
        $email = $_POST['input_email'];
        $password = $_POST['input_password'];

        $count = strlen($password);
        $namecount = strlen($name);

        // ユーザー名の空チェック
        if ($name == '') {
            $errors['name'] = 'blank';
        }
        elseif($namecount < 4){
            $errors['name'] = 'length';
        }

        if ($email == '') {
            $errors['email'] = 'blank';
        }
        //アドレスが重複しているかどうか
        else{

            require('../dbconnect.php');

            $sql = 'SELECT COUNT(*) as `cnt` FROM `users` WHERE `email` = ?';
            $data = array($email);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $dbh = null;

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ( $rec['cnt'] > 0){
              //アドレスが重複しているかどうか
              $errors['email'] = 'duplicate';
            }
        }

        if ($password == '') {
            $errors['password'] = 'blank';
        }
        elseif($count < 4 || $count > 16) {
            $errors['password'] = 'length';
        }

        //画像名を取得
        $file_name = $_FILES[
          'input_img_name']['name'];
          if(!empty($file_name)) {
            //拡張子チェック
            $file_type = substr($file_name, -4);
            //画像の後ろから小文字4文字
            $file_type = strtolower($file_type);
            //比較するために取得した拡張子を小文字に変換する

            if( $file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
              $errors['img_name'] = 'type';
            }
          }
          else {
            $errors['img_name']='blank';
          }


          if(empty($errors)) {
            date_default_timezone_set('Asia/Manila');
            $date_str = date('YmdHis');
            //この行を実行した日時を取得
            $submit_file_name = $date_str.$file_name;
            echo $date_str;
            echo "<br>";
            echo $submit_file_name;
            //move_uploaded_file(テンポラリパス、保存したい場所、ファイル名)

            move_uploaded_file($_FILES['input_img_name']['tmp_name'], '../user_profile_img/'.$submit_file_name);

            var_dump($_FILES);

            $_SESSION['register']['name'] = $_POST['input_name'];
            $_SESSION['register']['email'] = $_POST['input_email'];
            $_SESSION['register']['password'] = $_POST['input_password'];
            $_SESSION['register']['img_name'] = $submit_file_name;

            header('Location: check.php');
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
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

    <div id="login-page">
      <div class="container">
          <form method="POST" class="form-login" action="signup.php" enctype="multipart/form-data">
            <h2 class="form-login-heading">acount Registration</h2>
            <div class="login-wrap">

                <input type="text" name="input_name" class="form-control" placeholder="User name" autofocus>
                  <?php if(isset($errors['name']) && $errors['name'] == 'blank') { ?>
                    <p class="text-danger">ユーザー名を入力してください</p>
                  <?php } ?> 

                  <?php if(isset($errors['name']) && $errors['name'] == 'length') { ?>
                    <p class="text-danger">ユーザー名は4文字以上入力してください</p>
                  <?php } ?>
                <br>

                <input type="text" name="input_email" class="form-control" placeholder="example@gmail.com">
                  <?php if(isset($errors['email']) && $errors['email'] == 'blank') { ?>
                    <p class="text-danger">メールアドレスを入力してください</p>
                  <?php } ?>
                  <?php if (isset($errors['email']) && $errors['email'] == 'duplicate') { ?>
                    <p class="text-danger">すでに登録してされているメールアドレスです</p>
                  <?php } ?>
                <br>

                <input type="password" name="input_password" class="form-control" placeholder="4 ~ 16文字のパスワード">
                  <?php if(isset($errors['password']) && $errors['password'] == 'blank') { ?>
                    <p class="text-danger">パスワードを入力してください</p>
                  <?php } ?> 

                  <?php if(isset($errors['password']) && $errors['password'] == 'length') { ?>
                    <p class="text-danger">パスワードは4 ~ 16文字で入力してください</p>
                  <?php } ?>
                <br>

                <div class="form-group">
                  <label for="img_name">プロフィール画像</label>
                  <input type="file" name="input_img_name" id="img_name" accept="image/*">
                  <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type') { ?>
                    <p class="text-danger">拡張子が「jpg」「png」「gif」「jpeg」の画像を選択してください</p>
                  <?php } ?>
                  <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank') { ?>
                    <p class="text-danger">画像を選択してください</p>
                  <?php } ?>
                </div>

                <label class="checkbox">
                    <span class="pull-right">
                        <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
    
                    </span>
                </label>
                <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> conform</button>
                <hr>
                
                <div class="login-social-link centered">
                <p>or you can sign in via your social network</p>
                    <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
                    <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
                </div>
                <div class="registration">
                    Don't have an account yet?<br/>
                    <a class="" href="#">
                        Create an account
                    </a>
                </div>
    
            </div>
    
              <!-- Modal -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title">Forgot Password ?</h4>
                          </div>
                          <div class="modal-body">
                              <p>Enter your e-mail address below to reset your password.</p>
                              <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
    
                          </div>
                          <div class="modal-footer">
                              <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                              <button class="btn btn-theme" type="button">Submit</button>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- modal -->
    
          </form>     
      
      </div>
    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="../assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("../assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
