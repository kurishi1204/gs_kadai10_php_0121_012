<?php
session_start();
require_once('funcs.php');
loginCheck();

//1. POSTデータ取得
$bookname   = $_POST['bookname'];
$content = $_POST['content'];
$id     = $_POST['id'];
$img = '';

var_dump(($_FILES));

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


// **** macはimagesfフォルダの書き込み権限の変更が必要ですので忘れずに。*****
if ($_SESSION['post']['image_data'] !== ""){
    $pdo = db_conn();
    // まず保存された画像があれば削除する。
    // まず画像があるか確認
    $stmt = $pdo->prepare("SELECT img FROM content WHERE id=" . $id . ';');
    $status = $stmt->execute();

    // もし画像がある場合
    if ($status) {
        $row = $stmt->fetch();
        $imgName = $row['img'];
        // unlink()で削除
        unlink('images/' . $imgName);
    }

    $img = date('YmdHis') . '_' . $_SESSION['post']['file_name'];
    // file_put_contents('../images/' . $img, $_SESSION['post']['image_data']); //2つ目のものをどこに置くか、最初の方が保存先
    file_put_contents("images/$img", $_SESSION['post']['image_data']); //上でもOK。下が主流の書き方。
}

// echo '<pre>';
// var_dump(($_SESSION));
// echo '</pre>';
// exit();


//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE content SET bookname=:bookname,content=:content,img=:img WHERE id=:id;');
$stmt->bindValue(':bookname',   $bookname,   PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id',     $id,     PDO::PARAM_INT);
$stmt->bindValue(':img', $img, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}
