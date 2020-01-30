<?php
require('dbconnect.php');
session_start();

if(isset($_SESSION['id'])){
    
}else{
    header('Location: login.php');
    exit();
}

$records = $db -> query('SELECT * FROM select_skill');

$mydate = $db ->prepare('SELECT * FROM my_profile WHERE id=?');
$mydate -> execute(array($_SESSION['id']));
$md = $mydate->fetch();



if(!empty($_POST)) {
    if($_POST['name'] === '') {
        $error['name'] = 'blank';
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
        $picture = date('YmdHis') . $_FILES['picture']['name'];
        move_uploaded_file($_FILES['picture']['tmp_name'],'member_picture/'. $picture);
        $_SESSION['picture'] = $picture;

        $update = $db ->prepare('UPDATE my_profile SET name=?, gender=?, picture=?, skill=?, remarks=?, comment=? WHERE id=?');
        $update -> execute(array(
            $_POST['name'],
            $_POST['gender'],
            $_SESSION['picture'],
            $_POST['skill'],
            $_POST['remarks'],
            $_POST['comment'],
            $_SESSION['id']
        ));

        header('Location:myProfile.php');
        exit();
    } 
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>myPage</title>
        <link rel="stylesheet" href="css/stylelog2.css">
    </head>
    
    <body>
        <div class="container">
        <header>
            <h1>プロフィール編集</h1>
        </header>

        <div class="main">
            <div class="profile">
                <form action="" method="post" enctype="multipart/form-data">
                    <dl>
                        <dt>名前(ニックネーム)</dt>
                        <dd>
                            <input class="name" type="text" name="name" size="30" maxlength="30" value="<?php print(htmlspecialchars($md['name'],ENT_QUOTES)); ?>">
                            <?php if($error['name'] === 'blank'): ?>
                                <p class="error">※ニックネームを入力してください</p>
                            <?php endif ?>    
                        </dd>
                    </dl>

                    <dl>
                        <dt>性別</dt>
                        <dd>
                            <p>
                               <input class="gender" type="radio" name="gender" value="男性">男性
                               /
                               <input class="gender" type="radio" name="gender" value="女性">女性
                               /
                               <input class="gender" type="radio" name="gender" value="その他">その他
                            </p>
                            <?php if($error['gender'] === 'blank'): ?>
                                <p class="error">※申し訳ございませんが性別を選択してください</p>
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
                        <dt>保有している資格・技術</dt>
                        <dd>
                        　　<select class="skill" name="skill">
                            <?php while($record = $records->fetch()):?>
                                <option value="<?php print(htmlspecialchars($record['skill_name'],ENT_QUOTES). "\n");?>"><?php print(htmlspecialchars($record['skill_name'],ENT_QUOTES). "\n");?></option>
                            <?php endwhile ?>
                            </select>
                        </dd>
                    </dl>

                    <dl>
                        <dt>資格・技術に関する備考</dt>
                        <dd>
                            <input class="remarks" type="text" name="remarks" size="30" maxlength="30"
                            value="<?php print(htmlspecialchars($md['remarks'],ENT_QUOTES)); ?>">
                        </dd>
                    </dl>

                    <dl>
                        <dt>コメント</dt>
                        <dd>
                            <textarea class="comment" name="comment" cols="50" rows="4"><?php 
                            print(htmlspecialchars($md['comment'],ENT_QUOTES)); ?></textarea>
                        </dd>
                    </dl>
                    <input class="btn" type="submit" value="保存する">
                </form>  
            </div>
        </div>
        <footer>
           <p>For Learners</p>
        </footer>
        </div>
    </body>
</html>
