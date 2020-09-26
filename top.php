<?php
$filename = 'hisohiso.csv';
$comment='';
$comment_max = 100;
$log = date('(-Y-m-d H:i:s)');
// $_SESSION["username"] = 'username';

session_start();

if(isset($_POST['logout'])){
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}
$fp = fopen($filename, 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $comment = htmlspecialchars($_POST['comment']);
    if (!empty($comment)) {
    fputcsv($fp, [$name, $comment,$log]);
    }
    rewind($fp);
}
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
fclose($fp);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link href="style.php" rel="stylesheet" type="text/css" media="all">
<title>ひそひそ掲示板</title>
</head>
<header>
  <div><img src="logo.jpeg" alt=""class="logo"></div>
  <h2><?php print $_SESSION['username']; ?>さんでログイン中</h2>
  <h3><form method="post" action="login.php">
      <input type="submit" name="logout" value="ログアウト">
  </form></h3>
</header>
<body>
  <article class="main">
    <h1><img src="hisohiso-image.png" alt=""></h1>
    <section class="toukou">
      <h4>新規投稿</h4>
      <?php if (mb_strlen($comment) > $comment_max){?>
      <p><?php print 'ひとことは100文字以内で入力してください';?></p>
      <?php } ?>
      <?php if(mb_strlen($comment) === 0){?>
      <p><?php print 'ひとことを入力してください';?></p>
      <?php } ?>
      <form action="" method="post">
        <div class="honbun">
        <span>ひそひそ一言</span>
        <div><textarea name="comment" cols="30"  wrap="hard" placeholder="100字以内で入力してください。"></textarea></div>
        <input type="submit" value="投稿">
      </div>
      </form>
    </section>
    <section class="itiran">
      <h4>投稿一覧</h4>
      <?php
      if (!empty($rows)) {
        foreach ($rows as $row) { ?>
        <li><?php print $_SESSION['username'].":"; ?> <?php print $row[1]; ?> <?php print $row[2]; ?></li>
        <?php
        }
      }
      else {
      print '投稿がありません';
      } ?>
    </section>
  </article>
</body>
</html>
