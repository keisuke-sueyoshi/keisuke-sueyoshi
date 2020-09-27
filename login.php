<?php
$post_user = $_POST["user"];
$post_pass = $_POST["password"];
$post_submit = $_POST["login"];

session_start();
$_SESSION['username'] = 'iihito';

if(isset($post_submit)){
  if($post_user === "iihito" && $post_pass === "amema"){
    header('location:top.php');
    exit();
  }else{
    echo "IDまたはパスワードが間違っています";
    exit();
  }
}
?>
<html>
  <head>
    <title>ログイン</title>
  </head>

  <body>
    <form action="" method="POST">
        <input type="text" name="user" placeholder="user"><br>
        <input type="password" name="password" placeholder="Password"><br>

        <input type="submit" name="login" value="ログイン">
    </form>
  </body>
</html>
