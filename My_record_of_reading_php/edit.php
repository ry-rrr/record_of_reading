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
    //　データベースとの接続終了
    $dbh = null;
} catch (Exception $e) {
    echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>登録内容変更</title>
    </head>
    <body>
        登録内容の変更<br>
        <form method="post" action="update.php">
            タイトル：<input type="text" name="book_title" value="<?php echo htmlspecialchars($result['book_title'], ENT_QUOTES, 'UTF-8'); ?>">
            <br>
            作者：<input type="text" name="author" value="<?php echo htmlspecialchars($result['author'], ENT_QUOTES, 'UTF-8'); ?>">
            <br>
            点数：<input type="number" name="score" value="<?php echo htmlspecialchars($result['score'], ENT_QUOTES, 'UTF-8'); ?>">点
            <br>
            読んだ日：<input type="text" name="reading_date" value="<?php echo htmlspecialchars($result['reading_date'], ENT_QUOTES, 'UTF-8'); ?>">
            <br>
            感想：
            <textarea name="impressions" cols="50" rows="5" maxlength="200"><?php echo htmlspecialchars($result['impressions'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <!--IDの受け渡し-->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="submit" value="登録">
            <br>
            <a href="index.php">トップページへ戻る</a>
        </form>
    </body>
</html>