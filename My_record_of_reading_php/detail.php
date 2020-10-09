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
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    // プレースホルダの値設定
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    // SQL文の実行
    $stmt->execute();
    //　SQL文の結果の取り出し
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "タイトル：" . htmlspecialchars($result['book_title'],ENT_QUOTES,'UTF-8') . "<br>\n";
    echo "作者：" . htmlspecialchars($result['author'],ENT_QUOTES,'UTF-8') . "<br>\n";
    echo "点数：" . htmlspecialchars($result['score'],ENT_QUOTES,'UTF-8') . "<br>\n";
    echo "読んだ日：" . htmlspecialchars($result['reading_date'],ENT_QUOTES,'UTF-8') . "<br>\n";
    echo "感想：<br>" . nl2br(htmlspecialchars($result['impressions'],ENT_QUOTES,'UTF-8')) . "<br>\n";
    echo "<a href='index.php'>トップページへ戻る</a>";
    //　データベースとの接続終了
    $dbh = null;
} catch (Exception $e) {
    echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}