<?php
require_once '/Applications/MAMP/db2_config.php';
$book_title = $_POST['book_title'];
$author = $_POST['author'];
$score = (int) $_POST['score'];
$reading_date = $_POST['reading_date'];
$impressions = $_POST['impressions'];
try {
// データベースに接続
$dbh = new PDO('mysql:host=localhost;dbname=db2;charset=utf8', $user, $pass);
// プリペアドステートメントを利用できるように設定
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// PDO実行時のエラーモード設定
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $sql文の準備
$sql = "INSERT INTO books (book_title, author, score, reading_date, impressions) VALUES(?, ?, ?, ?, ?)";
$stmt = $dbh->prepare($sql);
// プレースホルダの値設定
$stmt->bindValue(1, $book_title, PDO::PARAM_STR);
$stmt->bindValue(2, $author, PDO::PARAM_STR);
$stmt->bindValue(3, $score, PDO::PARAM_INT);
$stmt->bindValue(4, $reading_date, PDO::PARAM_STR);
$stmt->bindValue(5, $impressions, PDO::PARAM_STR);
// SQL文の実行
$stmt->execute();
//　データベースとの接続終了
$dbh = null;
echo "本の登録が完了しました。<br>";
echo "<a href='index.php'>トップページへ戻る</a>";
} catch (Exception $e) {
echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
die();
}