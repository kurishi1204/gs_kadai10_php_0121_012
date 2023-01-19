<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>サインアップ</title>
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
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <form method="POST" action="signup_insert.php">
        <div class="jumbotron">
            <fieldset>
                <legend>新規ユーザー登録フォーム</legend>
                <label>ユーザーネーム：<input type="text" name="name"></label><br>
                <label>ID:<input type="text" name="lid"></label><br>
                <label>PW:<input type="password" name="lpw"></label><br>
                <input type="hidden" name="admin_flg" value=1>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->
</body>

</html>
