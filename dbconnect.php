<?php
try{
    $db = new PDO('mysql:dbname=fl_bbs;host=127.0.0.1;
    charset=utf8','root','');
}catch (PDOExeption $e) {
    print('DB接続エラー :' . $e->getMessage());
}
?>