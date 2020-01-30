<?php
require('dbconnect.php');
session_start();

if (isset($_SESSION['id'])) {
    $members = $db ->prepare('SELECT * FROM my_profile WHERE id=?');
    $members -> execute(array($_SESSION['id']));
    $member = $members ->fetch();
}else{
    header('Location:login.php');
    exit();
}

if(isset($_SESSION['op_id'])) {
    $op_member = $db-> prepare('SELECT * FROM my_profile WHERE id=?');
    $op_member ->execute(array($_SESSION['op_id']));
    $om = $op_member ->fetch();
}


if (!empty($_POST)) {
    if($_POST['message'] !== '') {
        $message_store = $db ->prepare('INSERT INTO message_store SET message=?, member_id=?, op_member_id=?, created=NOW()');
        $message_store ->execute(array(
            $_POST['message'], 
            $member['id'],
            $om['id']
        ));
        header('Location: talk.php');
        exit();
    } 
}

$display_message = $db -> query('SELECT mp.name, mp.picture, ms.* FROM my_profile mp, message_store ms 
WHERE mp.id=ms.member_id ORDER BY ms.created DESC');

$talk_list = $db ->prepare('INSERT INTO talk_list SET user_id=?,op_id=?,op_name=?');
$talk_list ->execute(array($_SESSION['id'],$_SESSION['op_id'],$om['name']));

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>talk_room</title>
        <link rel="stylesheet" href="css/styletalk.css">
    </head>
    <body>
        <div class="container">
        <header>
            <h1>トークルーム</h1>
        </header>
        <div class="main">
            <div class="content">
                <form action="" method="post">
                    <dl>
                        <dt>メッセージ記入欄</dt>
                        <dd>
                            <textarea class="text" name="message" cols="50" rows="5" ></textarea>
                        </dd>
                    </dl>
                    <p class="btn"><input class="send" type="submit" value="送信">  |  <a href="myPage.php">マイページに戻る</a> | <a href="talklist.php">トークリスト</a></p>
                </form>
            

            <div class="messages">
                <h3>コメント</h3>
            <?php foreach ($display_message as $dm): ?>
                <?php if(($dm['member_id'] === $member['id'] || $dm['member_id'] === $om['id'])
                && ($dm['op_member_id'] === $member['id'] || $dm['op_member_id'] === $om['id'] )): ?>
                <div class="message">
                    <img class="picture" src="member_picture/<?php print(htmlspecialchars($dm['picture'],ENT_QUOTES));?>" 
                    height="40" width="40" alt="NO IMAGE">
                    <div class="sentence">
                    <p>(<?php print(htmlspecialchars($dm['name'],ENT_QUOTES));?>)
                    <?php print(htmlspecialchars($dm['message'],ENT_QUOTES));?></p>

                    <p class="time"><?php print(htmlspecialchars($dm['created'],ENT_QUOTES));?></p>
                    </div>
                    <hr>
                </div>
                <?php endif ?>
            <?php endforeach ?> 
            </div>

            </div>
        </div>

        <footer>
            <p>For Learners</p>
        </footer>
        </div>
    </body>
</html>