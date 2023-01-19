<?php
session_start();
require_once('funcs.php');
loginCheck();

//1. POSTデータ取得
$id = $_GET['id'];

//2. DB接続します
require_once('funcs.php');
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


//３．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM content WHERE id = :id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}
