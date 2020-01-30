<?php
session_start();
require('dbconnect.php');

$records = $db -> query('SELECT * FROM select_skill');

if(isset($_SESSION['id'])){ 
}else{
    header('Location: login.php');
    exit();
}

if(!empty($_POST)){
    $_SESSION['skill'] = $_POST['skill'];
    header('Location:search.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>myPage</title>
        <link rel="stylesheet" href="css/stylemp.css">
    </head>
    <body>
        <div class="container">
        <header>
            <h1>マイページ</h1>
        </header>
        <div class="main">
            <div class="logout"><a href="logout.php">ログアウト</a></div>
            <div class="search">
                <h3 class="title">検索</h3>
                <p>キーワードから自分の学びたい内容に関して教えてくれそうな人を探します</p>
                <form action="" method="post" enctype="multipart/form-data">
                    <dl>
                        <dt>指導できる資格・技術</dt>
                        <dd>
                            <select class="skill" name="skill">
                            <?php while($record = $records->fetch()):?> 
                                <option value="<?php print(htmlspecialchars($record['skill_name'],ENT_QUOTES) . "\n");?>"><?php 
                                    print(htmlspecialchars($record['skill_name'],ENT_QUOTES) . "\n");?></option>
                            <?php endwhile ?>        
                            </select>  
                        </dd>
                        <input class="btn" type="submit" value="検索">
                    </dl>
                </form>            
            </div>

            <div class="talk">
                <h3 class="title">トーク</h3>
                <p>過去に会話した人の履歴</p>
                <a href="talklist.php">トークリスト</a>
            </div>    

            <div class="profile">
　　　　　　　　　<h3 class="title">プロフィール</h3>
                <p>自分の学びなどに付いての紹介</p>
                <a href="myProfile.php">プロフィールの編集</a>
            </div> 
        </div>
        <footer>
            <p>For Learners</p>
        </footer>
        </div>
        
    </body>
</html>