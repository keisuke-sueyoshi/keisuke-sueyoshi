<?php
$filename = 'HisoHiso.csv';
$name='';
$comment='';
$name_max = 20;
$comment_max = 100;
$log = date('(-Y-m-d H:i:s)');

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
    if (!empty($name) and !empty($comment)) {
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
<title>掲示板</title>
</head>
<body>
  <p><?php print $_SESSION['username']; ?>さんでログイン中</p>
  <br>
  <form method="post" action="login.php">
      <input type="submit" name="logout" value="ログアウト">
  </form>
<h1>掲示板</h1>
<section>
    <h2>新規投稿</h2>
    <?php if (mb_strlen($name) > $name_max){?>
    <p><?php print '名前は20文字以内で入力してください';?></p>
    <?php } ?>
    <?php if(mb_strlen($name) === 0){?>
    <p><?php print '名前を入力してください';?></p>
    <?php } ?>
    <?php if (mb_strlen($comment) > $comment_max){?>
    <p><?php print 'ひとことは100文字以内で入力してください';?></p>
    <?php } ?>
    <?php if(mb_strlen($comment) === 0){?>
    <p><?php print 'ひとことを入力してください';?></p>
    <?php } ?>

    <form action="" method="post">
        <div class="name"><span class="label">お名前:</span><input type="text" name="name" value=""></div>
        <div class="honbun"><span class="label">本文:</span><textarea name="comment" cols="30" rows="3" wrap="hard" placeholder="100字以内で入力してください。"></textarea></div>
        <input type="submit" value="投稿">
    </form>
</section>
<section class="toukou">
  <h2>投稿一覧</h2>
  <?php
    if (!empty($rows)) {
      foreach ($rows as $row) { ?>

  <li><?php print $row[0].":"; ?> <?php print $row[1]; ?> <?php print $row[2]; ?></li>
  <?php
        }
      }
      else {
        print '投稿がありません';
      }
  ?>

</body>
</html>
