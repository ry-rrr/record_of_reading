<?php
require_once '/Applications/MAMP/db2_config.php';
try {
    if (empty($_GET['id'])) throw new Exception('ID不正');
    $id = (int) $_GET['id'];
    // データベースに接続
    $dbh = new PDO('mysql:host=localhost;dbname=db2;charset=utf8', $user, $pass);
    // プリペアドステートメントを利用できるように設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // PDO実行時のエラーモード設定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $sql文の準備
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    // プレースホルダの値設定
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    // SQL文の実行
    $stmt->execute();
    //　データベースとの接続終了
    $dbh = null;
    echo "ID: " . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "削除が完了しました。<br>"; 
    echo "<a href='index.php'>トップページへ戻る</a>";
} catch (Exception $e) {
    echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}