<?php
session_start();

    if(!isset($_SESSION['register'])) {
      header("Location:signup.php");
      exit();
    }

    $name = $_SESSION['register']['name'];
    $email = $_SESSION['register']['email'];
    $user_password = $_SESSION['register']['password'];
    $img_name = $_SESSION['register']['img_name'];

    if(!empty($_POST)) {

        require('../dbconnect.php');
        $sql = 'INSERT INTO `users` SET `name`=?, `email`=?, `password`=?, `img_name`=?, `created`=NOW()';
        $data = array($name, $email, password_hash($user_password, PASSWORD_DEFAULT), $img_name);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

         $dbh = null;

        unset($_SESSION['register']);

        header('Location: thanks.php');
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

    <title>BookOn</title>

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

        <div class="row form-login">
          <div class="thumbnail" style="margin-bottom: 0px;">
            <h2 class="text-center content_header">アカウント情報確認</h2>
            <div class="row">
              <div class="col-xs-4">
                <img src="../user_profile_img/<?php echo htmlspecialchars($img_name); ?>" class="img-responsive img-thumbnail">
              </div>
              <div class="col-xs-8">
                <div>
                  <span>ユーザー名</span>
                  <p class="lead"><?php echo htmlspecialchars($name); ?></p>
                </div>
                <div>
                  <span>メールアドレス</span>
                  <p class="lead"><?php echo htmlspecialchars($email); ?></p>
                </div>
                <div>
                  <span>パスワード</span>
                  <!-- ② -->
                  <p class="lead">●●●●●●●●</p>
                </div>
                <!-- ③ -->
                <form method="POST" action="">
                  <!-- ④ -->
                  <a href="signup.php" class="btn btn-default">&laquo;&nbsp;戻る</a> | 
                  <!-- ⑤ -->
                  <input type="hidden" name="action" value="submit">
                  <input type="submit" class="btn btn-primary" value="ユーザー登録">
                </form>
              </div>
            </div>
          </div>
        </div>
      
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
