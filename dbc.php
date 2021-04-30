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

function getBlog($id) {

  if(empty($id)) {
    exit('IDが不正です');
  }
  
  $dbh = dbConnect();
  
  // SQL準備
  $stmt = $dbh->prepare('SELECT * FROM blog Where id = :id');
  $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
  
  // SQLを実行
  $stmt->execute();
  // 結果を取得
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if(!$result) {
    exit('ブログがありません');
  }

  return $result;
}

?>
