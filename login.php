<?php  
session_start();
require('dbconnect.php');

if($_COOKIE['email'] !=='') {
    $email = $_COOKIE['email'];
}

if (!empty($_POST)) {
    $email = $_POST['email'];
    $email = $_POST['email'];

  
    if ($_POST['email'] !== '' && $_POST['password'] !== '') {
        $login = $db->prepare('SELECT * FROM my_profile WHERE email=? AND password=?');
        $login->execute(array( $_POST['email'], sha1($_POST['password'])));
        $member = $login->fetch();
    
  
      if ($member) {
          $_SESSION['id'] = $member['id'];
          $_SESSION['time'] = time();  

         if ($_POST['save'] ==='on') {
             setcookie('email', $_POST['email'],time()+60*60*24*30);
         }

        header('Location:myPage.php');
        exit();
        
      }else {
        $error['login'] = 'failed'; 
      }
  
  
    }else{
      $error['login'] = 'blank';
    }
  }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
        <meta charset="utf-8">
        <title>loginPage</title>
        <link rel="stylesheet" href="css/stylelog.css">
</head>

<body>
    <div class="container">
    <header>
        <h1 class="login-title">For Learners</h1>    
    </header>

    <div class="main">
        <div class="top-message">
            <p>このサービスは学ぶ人たちのサポートを目的としています。<br>
            お互い学びを深めるために積極的に交流しましょう！！</p>
        </div>
    
        <div class="entry">
            <h3 class="login">ログイン入力欄</h3>
             <p class="login-message">次のフォームに必要事項を記入してください</p>
             <a href="signUp.php">登録がお済でない方はこちら</a>
             
             <form action="" method="post" enctype="multipart/form-data">  
             <?php if ($error['login'] === 'blank'): ?>
                        <p class="error">※メールアドレスとパスワードをご記入ください</p>
                    <?php endif ?>
                    <?php if ($error['login'] === 'failed'): ?>
                        <p class="error">※ログインに失敗しました。正しい情報を入力してください</p>
                    <?php endif ?>
             <dl>
                <dt>メールアドレス</dt> 
                <dd>
                    <input class="email" type="text" name="email" size="35" maxlength="255" 
                    value="<?php print(htmlspecialchars($email,ENT_QUOTES)); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>パスワード</dt>
                <dd>
                    <input class="password" type="password" name="password" size="35" maxlength="255" 
                    value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES)); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>ログイン情報の保存</dt>
                <dd>
                    <input type="checkbox" name="save" value="on">
                    <lavel for="save">次回から自動的にログインする</lavel>
                </dd>
            </dl>
                <input class="btn" type="submit" value="ログイン" />
           </form>
       </div>
    </div>
    <footer>
        <p>For Learners</p>
    </footer>
    </div>
   </body>
</html>