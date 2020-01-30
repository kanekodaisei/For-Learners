<?php
session_start();
require('dbconnect.php');

if(isset($_SESSION['id'])) {
    $op_id = $_REQUEST['op_id'];

        $del = $db ->prepare('DELETE FROM talk_list WHERE user_id=? AND op_id=? ');
        $del ->execute(array($_SESSION['id'],$op_id));
}

header('Location: talklist.php');
exit();
?>