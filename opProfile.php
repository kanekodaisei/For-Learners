<?php
require('dbconnect.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: login.php');
    exit();
}

if(empty($_POST['op_id'])){
    header('Location:myPage.php');
    exit();
}else{
    $op_date = $db ->prepare('SELECT * FROM my_profile WHERE id=?');
    $op_date ->execute(array($_POST['op_id']));
    $od = $op_date->fetch();
}

$_SESSION['op_id'] = $od['id'];

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>myPage</title>
        <link rel="stylesheet" href="css/styleprofile.css">
    </head>
    
    <body>
        <div class="container">
        <header>
            <h1>相手のプロフィール</h1>
        </header>

        <div class="main"> 
            <form action="talk.php" method="post">   
                <input type="hidden" name="op_id" value="<?php print(htmlspecialchars($od['id'],ENT_QUOTES)); ?>">
                <input class="talk" type="submit" name="profile" value="<?php print(htmlspecialchars($od['name'],ENT_QUOTES));?>のトークに移動する">
            </form> 
            
            <div class="profile">
                    <dl>
                        <dt>名前(ニックネーム)</dt>
                        <dd>
                            <?php print(htmlspecialchars($od['name'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>性別</dt>
                        <dd>
                            <?php print(htmlspecialchars($od['gender'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>写真</dt>
                        <dd>
                        <img src="member_picture/<?php print(htmlspecialchars($od['picture'],ENT_QUOTES)); ?>" 
                            height="20%" width="20%" alt="NO IMAGE">
                        </dd>
                    </dl>

                    <dl>
                        <dt>保有している資格・技術</dt>
                        <dd>
                            <?php print(htmlspecialchars($od['skill'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>資格・技術に関する備考</dt>
                        <dd>
                            <?php print(htmlspecialchars($od['remarks'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>コメント</dt>
                        <dd>
                            <?php print(htmlspecialchars($od['comment'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>
            </div>
            <a class="return" href="search.php">検索画面に戻る</a>    
        </div>
        <footer>
        <p>For Learners</p>
        </footer>
        </div>
    </body>
</html>
