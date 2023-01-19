<?php
// confirm.phpの中身は、ほとんどpost.phpに似ています。

session_start();
require_once('funcs.php');

// post受け取る
$bookname = $_POST['bookname'];
$content = $_POST['content'];

// postというものの中にタイトル、コンテンツを入れることでわかりやすくしている。postの中に入れなくても良い。
$_SESSION['post']['bookname'] = $_POST['bookname'];
$_SESSION['post']['content'] = $_POST['content'];


var_dump(($_FILES));

// 簡単なバリデーション処理。
if (trim($bookname) === '' || trim($content) === '') {
    redirect('index.php?error');
}

// imgある場合。issseの場合は""という何も入っていない状況もあるよねという形ですり抜けてしまうのでここでは使わない。
if ($_FILES['img']['name'] !=="") {
    // $_SESSION['post']['file_name'] = $_FILES['img']['name'];
    // $file_name = $_FILES['img']['name'];

    $file_name = $_SESSION['post']['file_name'] = $_FILES['img']['name'];

    // 画像データを取得、tmp_nameはvar_dumpで見ると入っているのがわかる。
    $image_data = $_SESSION['post']['image_data'] = file_get_contents($_FILES['img']['tmp_name']); 

    // 画像タイプを取得
    $image_type = $_SESSION['post']['image_type'] = exif_imagetype($_FILES['img']['tmp_name']);
} 
else {
    $file_name = $_SESSION['post']['file_name'] = '';
    $image_data = $_SESSION['post']['image_data'] = '';
    $image_type = $_SESSION['post']['image_type'] = '';
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <title>記事管理</title>
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

    <!-- Main[Start] -->
    <form method="POST" action="insert.php" enctype="multipart/form-data">
        <div class="jumbotron">
            <fieldset>
                <legend>書籍情報登録フォーム</legend>

                <label>書籍名：</label>
                <input type="hidden"name="bookname" value="<?= $bookname ?>">
                <p><?= $bookname ?></p>

                <label>書籍内容メモ：</label>
                <input type="hidden"name="content" value="<?= $content ?>">
                <p><?= nl2br($content) ?></p>

                <label>カバー画像：</label>
                <?php if ($image_data) : ?>
                <!-- 写真を表示してください。 -->
                <div class="mb-3">
                    <img src="image.php">
                </div>  
                <?php endif ?>

                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->

    <a href="index.php?re-register=true">前の画面に戻る</a>
</body>
</html>
