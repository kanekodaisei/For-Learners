<?php
require('dbconnect.php');
session_start();

if(isset($_SESSION['id'])){
    $talk_list = $db -> prepare('SELECT DISTINCT tl.op_id , mp.name, mp.picture, mp.skill, mp.remarks FROM my_profile mp, talk_list tl 
    WHERE mp.id=tl.op_id AND tl.user_id=?');
    $talk_list -> execute(array(
        $_SESSION['id']
    ));
}else{
    header('Location:login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>myPage</title>
        <link rel="stylesheet" href="css/stylesearch.css">
    </head>

    <body>
        <div class="container">
        <header>
            <h1>トークリスト</h1>
        </header>

        <div class="main">
                <?php while ($tl = $talk_list->fetch()): ?>
                    
                    <div class="sentence">
                    　　 <p class="name">名前  ：  <?php print(htmlspecialchars($tl['name'],ENT_QUOTES));?></p>
                        <p class="skill">資格・技術  ：  <?php print(htmlspecialchars($tl['skill'],ENT_QUOTES));?></p>   
                        <p class="remarks">備考  ：  <?php print(htmlspecialchars($tl['remarks'],ENT_QUOTES));?></p>
                        <img class="picture" src="member_picture/<?php print(htmlspecialchars($tl['picture'],ENT_QUOTES)); ?>" 
                            height="20%" width="20%" alt="NO IMAGE">
                    </div> 
                    
                    
                    
                <div class="input">
                    <form action="opProfile2.php" method="post">  
                        <input type="hidden" name="op_id" value="<?php print(htmlspecialchars($tl['op_id'],ENT_QUOTES));?>">        
                        <input class="profile" type="submit" value="プロフィールの表示">
                        <div class="delete">【 <a href="delete.php?op_id=<?php print(htmlspecialchars($tl['op_id'],ENT_QUOTES)); ?>">削除</a> 】</div>
                    </form>
                    
                </div>
                
                <?php endwhile ?>       
            <a class="return" href="myPage.php">マイページに戻る</a>
        </div>

        <footer>
           <p>For Learners</p>
        </footer>
        </div>
    </body>
</html>