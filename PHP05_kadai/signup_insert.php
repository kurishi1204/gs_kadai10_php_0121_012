<?php
//1. POSTデータ取得
$name   = $_POST['name'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$admin_flg = $_POST['admin_flg'];

//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO user(name,lid,lpw,admin_flg)VALUES(:name,:lid,:lpw,:admin_flg);');
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':admin_flg', $admin_flg, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('index.php');
}
