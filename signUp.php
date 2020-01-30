<?php
session_start();
require('dbconnect.php');


if (!empty($_POST)){
    if($_POST['name'] === '') {
        $error['name'] = 'blank';
    }
    if($_POST['email'] === '' ) {
        $error['email'] = 'blank';
    }
    if(strlen($_POST['password']) < 4 ) {
        $error['password'] = 'length';
    }
    if($_POST['password'] === '' ) {
        $error['password'] = 'blank';
    }

    if(!isset($_POST['gender'])) {
        $error['gender'] = 'blank';
    }
    if(!empty($_POST['picture'])) {
        $ext = substr($_POST['picture'],-3);
        if($ext != 'jpg' && $ext != 'png') {
            $error['picture'] = 'type';
        }
    }

    if(empty($error)) {
        $member = $db->prepare('SELECT COUNT(*) AS cnt
        FROM my_profile WHERE email=?');

        $member->execute(array($_POST['email']));
        $record = $member->fetch();
        if($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }
    }


    if(empty($error)) {
        $picture = date('YmdHis') . $_FILES['picture']['name'];
        move_uploaded_file($_FILES['picture']['tmp_name'],
        'member_picture/'. $picture);
        $_SESSION = $_POST;
        $_SESSION['picture'] = $picture;
        header('Location:sucheck.php');
        exit();
    }

}

if($_REQUEST['action']  == 'rewrite') {
    $_POST = $_SESSION;
}

$records = $db -> query('SELECT * FROM select_skill');
?>



<!DOCTYPE html>
<html lang="ja">
    <head>    
        <meta charset="utf-8">
        <title>editMyProfile</title>
        <link rel="stylesheet" href="css/stylelog2.css">
    </head>

    <body>
        <div class="container">
        <header>
            <h1>新規登録</h1>
        </header>

        <div class="main">
            <form action="" method="post" enctype="multipart/form-data">
            <a  class="return" href="login.php">前の画面に戻る</a>

            <h3>ログイン確認内容</h3>

            <dl>
                <dt>メールアドレス<span>(必須)</span></dt>
                <dd>
                    <input class="email" type="text" name="email" size="30" maxlength="100"
                    value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES)); ?>">
                    <?php if($error['email'] ==='blank'): ?>
                        <p class="error">※メールアドレスを記入してください</p>
                    <?php endif ?>    
                    <?php if($error['email'] ==='duplicate'):?>
                        <p class="error">※こちらのアドレスはすでに利用されています</p>
                    <?php endif ?>    
                </dd>
            </dl>

            <dl>
                <dt>パスワード<span>(必須)</span></dt>
                <dd>
                    <input class="password" type="password" name="password" size="30" maxlength="30" 
                    value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES)); ?>">
                    <?php if ($error['password'] ==='blank'): ?>
                        <p class="error">※パスワードを記入してください</p>
                    <?php endif ?>
                    <?php if ($error['password'] === 'length'): ?>
                        <p class="error">※パスワードは4文字以上で設定してください</p>                        
                    <?php endif ?>
                </dd>
            </dl>

　　　　　　　<h3>プロフィール内容</h3>　
　　　　　　　<p>※ログイン後、プロフィールは編集できます</p>

            <dl>
                <dt>ニックネーム<span>(必須)</span></dt>
                <dd>
                    <input class="name" type="text" name="name" size="30" 
                     maxlength="30" placeholder="名前を入力" 
                    value="<?php print(htmlspecialchars($_POST['name'])); ?>">
                    <?php if($error['name'] === 'blank'): ?>
                        <p class="error">※ニックネームを入力してください</p>
                    <?php endif ?>    
                </dd>
            </dl>
　　　　

            <dl>
                <dt>性別<span>(必須)</span></dt>
                <dd>
                    <p>
                       <input class="gender" type="radio" name="gender" value="男性">男性
                       /
                       <input class="gender" type="radio" name="gender" value="女性">女性
                       /
                       <input class="gender" type="radio" name="gender" value="その他">その他
                    </p>
                    <?php if($error['gender'] === 'blank'):?>
                        <p class="error">※申し訳ございませんが再度性別を選択してください</p>
                    <?php endif ?>       
                </dd>
            </dl>

            <dl>
                <dt>写真</dt>
                <dd>
                    <input class="picture" type="file" name="picture" size="1" value="default">
                    <?php if($error['picture'] === 'type'): ?>
                        <p class="error">※「.jpg」または「.png」で選択してください</p>
                    <?php endif ?>
                    <?php if(!empty($error)): ?>
                        <p class="error">※申し訳ございません。画像を選択される場合、再度、指定してください</p>
                    <?php endif ?>    
                </dd>
                </dl>

            <dl>
                <dt>指導できる資格・技術</dt>
                <dd>
                    <select class="skill" name="skill">
                    <?php while($record = $records->fetch()):?> 
                        <option value="<?php print(htmlspecialchars($record['skill_name'],ENT_QUOTES). "\n");?>"><?php print(htmlspecialchars($record['skill_name'],ENT_QUOTES) . "\n");?></option>
                    <?php endwhile ?>        
                    </select>  
                </dd>

                <dt>資格・技術に関して備考</dt>
                <dd>
                    <input class="remarks" type="text" name="remarks" size="30" maxlength="30"placeholder="例：簿記3級"
                    value="<?php print(htmlspecialchars($_POST['remarks'],ENT_QUOTES)); ?>">
                </dd>
            </dl>

            <dl>
                <dt>コメント</dt>
                <dd>
                    <textarea class="comment" name="comment" cols="50" rows="4" 
                    placeholder="※教えられる内容などについて簡単に紹介文を書いてください"
                    value="<?php print(htmlspecialchars($_POST['comment'],ENT_QUOTES)); ?>"></textarea>
                </dd>
            </dl>
                <div><input class="btn" type="submit" value="新規登録"></div>
            </form>
        </div>

        <footer>
            <p>For Learners</p>
        </footer>

        </div>
    </body>
</html>