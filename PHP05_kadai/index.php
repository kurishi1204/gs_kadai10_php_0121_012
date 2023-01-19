<?php
session_start();
require_once('funcs.php');

// $_SESSIONに情報がなければの処理を以下二行で実施。
$title = '';
$content = '';

if (isset($_SESSION['post']['title'])) {
    $title = $_SESSION['post']['title'];
}
if (isset($_SESSION['post']['content'])) {
    $content = $_SESSION['post']['content'];
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">ブックマーク一覧</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- // もしURLパラメータがある場合 -->
    <?php if(isset($_GET['error'])) : ?>
        <p class = 'text-danger'>記入内容を確認してください。</p>
    <?php endif ?>

    <!-- Main[Start] -->
    <form method="POST" action="confirm.php" enctype="multipart/form-data">
        <div class="jumbotron">
            <fieldset>
                <legend>書籍情報登録フォーム</legend>
                <label>書籍名：<input type="text" name="bookname"></label><br>
                <label>書籍内容メモ：<textArea name="content" rows="4" cols="40"></textArea></label><br>
                <label for="title" class="form-label">カバー画像：<input type="file" name="img"></label><br>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->
</body>

</html>
