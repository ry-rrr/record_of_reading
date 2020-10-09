<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>読んだ本の一覧</title>
    </head>
    <body>
        <h1>読んだ本の一覧</h1>
        <a href="form.html">読んだ本の新規登録</a>
    </body>
</html>

<?php
require_once '/Applications/MAMP/db2_config.php';
try{
    //　データベースに接続
    $dbh = new PDO('mysql:host=localhost;dbname=db2;charset=utf8', $user, $pass);
    //　PDO実行時のエラーモード設定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //　SQL文の準備
    $sql = "SELECT * FROM books";
    //　SQL文の実行
    $stmt = $dbh->query($sql);
    //　SQL文の結果の取り出し
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<table>\n";
    echo "<tr>\n";
    echo "<th>タイトル</th><th>作者</th><th>点数</th>\n";
    echo "</tr>\n";
    foreach ($result as $row) {
        echo "<tr>\n";
        echo "<td>" . htmlspecialchars($row['book_title'],ENT_QUOTES,'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['author'],ENT_QUOTES,'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['score'],ENT_QUOTES,'UTF-8') . "</td>\n";
        echo "<td>\n";
        echo "<a href=detail.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8',) . ">詳細</a>\n";
        echo "<a href=edit.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8',) . ">変更</a>\n";
        echo "<a href=delete.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8',) . ">削除</a>\n";
        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</table>\n";
    //データベースとの接続終了
    $dbh = null;
} catch (Exception $e) {
    echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}
?>