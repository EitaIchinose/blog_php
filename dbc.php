<?php

// データベース機能
function dbConnect() {

  $dsn = 'mysql:host=localhost;dbname=blog_app;charset=utf8';
  $user = 'blog_user';
  $pass = 'deluhi1215';

  try {
    $dbh = new PDO($dsn, $user, $pass,[
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
  } catch(PDOException $e) {
    echo '接続失敗'. $e->getMessage();
    exit();
  }

  return $dbh;
}

// データを取得する

function getAllBlog() {

  $dbh = dbConnect();
  // SQL文の準備
  $sql = 'SELECT * FROM blog';
  // SQL文の実行
  $stmt = $dbh->query($sql);
  // SQLの結果を受け取る
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $result;
  $dbh = null;
}

// 取得したデータを表示
$blogData = getAllBlog();

// カテゴリー名を表示する
function setCategoryName($category) {
  if ($category == 1) {
    return 'ブログ';
  } elseif ($category == 2) {
    return '日常';
  } else {
    return 'その他';
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ブログ一覧</title>
</head>
<body>
  <h2>ブログ一覧</h2>
  <table>
    <tr>
      <th>No</th>
      <th>タイトル</th>
      <th>カテゴリ</th>
    </tr>
    <?php foreach($blogData as $column): ?>
    <tr>
      <td><?php echo $column['id']; ?></td>
      <td><?php echo $column['title']; ?></td>
      <td><?php echo setCategoryName($column['category']); ?></td>
      <td><a href="/detail.php?id=<?php echo $column['id']; ?>">詳細</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>