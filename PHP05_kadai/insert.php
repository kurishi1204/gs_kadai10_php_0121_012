<?php
session_start();
require_once('funcs.php');

$bookname = $_POST['bookname'];
$content  = $_POST['content'];
$img = '';

// echo $bookname;
// echo $content;

// 簡単なバリデーション処理追加。
// if (trim($bookname) === '' || trim($content) === '') {
//     redirect('index.php?err');
// }

// **** macはimagesfフォルダの書き込み権限の変更が必要ですので忘れずに。*****
if ($_SESSION['post']['image_data'] !== ""){
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
$stmt = $pdo->prepare('INSERT INTO content(bookname,content,img,indate)VALUES(:bookname,:content,:img,sysdate());');
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':img', $img, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}
