<?php
require('dbconnect.php');
session_start();

if(isset($_SESSION['id'])){
    
}else{
    header('Location: login.php');
    exit();
}

$mydate = $db ->prepare('SELECT * FROM my_profile WHERE id=?');
$mydate -> execute(array($_SESSION['id']));
$md = $mydate->fetch();

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
            <h1>マイプロフィール</h1>
        </header>

        <div class="main">
            <div class="profile">
                <form action="" method="post">
                    <dl>
                        <dt>名前(ニックネーム)</dt>
                        <dd>
                            <?php print(htmlspecialchars($md['name'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>性別</dt>
                        <dd>
                            <?php print(htmlspecialchars($md['gender'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>写真</dt>
                        <dd>
                            <img src="member_picture/<?php print(htmlspecialchars($md['picture'],ENT_QUOTES)); ?>" 
                            height="20%" width="20%" alt="NO IMAGE">
                        </dd>
                    </dl>

                    <dl>
                        <dt>保有している資格・技術</dt>
                        <dd>
                            <?php print(htmlspecialchars($md['skill'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>資格・技術に関する備考</dt>
                        <dd>
                            <?php print(htmlspecialchars($md['remarks'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>コメント</dt>
                        <dd>
                            <?php print(htmlspecialchars($md['comment'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>
                </form>  
            </div>
            <div class="btn2"><a class="edit" href="udProfile.php">編集する</a> |
            <a class="return" href="myPage.php">マイページに戻る</a></div>    
        </div>
        <footer>
           <p>For Learners</p>
        </footer>
        </div>
    </body>
</html>
