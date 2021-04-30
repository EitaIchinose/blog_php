<?php

Class Dbc{

  protected $table_name;

  // データベース機能
  protected function dbConnect() {

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

  public function getAll() {

    $dbh = $this->dbConnect();
    // SQL文の準備
    $sql = "SELECT * FROM $this->table_name";
    // SQL文の実行
    $stmt = $dbh->query($sql);
    // SQLの結果を受け取る
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
    $dbh = null;
  }

  public function getById($id) {

    if(empty($id)) {
      exit('IDが不正です');
    }
    
    $dbh = $this->dbConnect();
    
    // SQL準備
    $stmt = $dbh->prepare("SELECT * FROM $this->table_name Where id = :id");
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
}
?>
