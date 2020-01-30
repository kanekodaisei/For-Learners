<?php
session_start();
require('dbconnect.php');

if(!isset($_SESSION)) {
    header('Location:signUp.php');
    exit();
}
if(!empty($_POST)){
    $stmt = $db->prepare('INSERT INTO my_profile 
    SET name=?,email=?,password=?,gender=?,picture=?,skill=?,remarks=?,comment=?'); 
    $stmt->execute(array(
    $_SESSION['name'],
    $_SESSION['email'],
    sha1($_SESSION['password']),
    $_SESSION['gender'],
    $_SESSION['picture'],
    $_SESSION['skill'],
    $_SESSION['remarks'],
    $_SESSION['comment']
));
unset($_SESSION);

header('Location: login.php');
exit();
}


if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION)) {
    $_POST = $_SESSION;
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>empcheck</title>
        <link rel="stylesheet" href="css/stylelog2.css">
    </head>

    <body>
        <div class="container">
        <header>
            <h1>登録内容の確認</h1>
        </header>

        <div class="main">
            <div class="sign">
                <form action="" method="post">
                    <h3>ログイン確認内容</h3>      
                  <input type="hidden" name="action" value="submit">  
                    <dl>
                        <dt>メールアドレス</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['email'], ENT_QUOTES)); ?>
                        </dd>
                    </dl>
                    <dl>
                        <dt>パスワード</dt>
                        <dd>｟表示されません｠</dd>
                    </dl>
            </div>

            <div class="profile">
                    <h3>プロフィール</h3>
                    <dl>
                        <dt>ニックネーム</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['name'], ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>性別</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['gender'],ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>写真</dt>
                        <dd>
                            <?php if($_SESSION['picture'] !== ''): ?>
                              <img src="member_picture/<?php print(htmlspecialchars
                              ($_SESSION['picture'], ENT_QUOTES)); ?>" height="50" width="50"
                              alt="NO IMAGE">
                            <?php endif ?>    
                        </dd>
                    </dl>

                    <dl>
                        <dt>保有している資格・技術</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['skill'], ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>資格・技術に関しての備考</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['remarks'], ENT_QUOTES)); ?>
                        </dd>
                    </dl>

                    <dl>
                        <dt>コメント</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['comment'], ENT_QUOTES)); ?>
                        </dd>       
                    </dl>
                    <div class="btn2"><a class="rewrite" href="signUp.php?action=rewrite">書き直す</a> | <input class="confirm" type="submit" value="登録内容を確定する"></div>
                </form>  　
            </div>
            </div>
        <footer>
            <p>For Learners</p>
        </footer>
        </div>
    </body>
</html>