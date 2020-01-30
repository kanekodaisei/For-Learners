<?php
require('dbconnect.php');
session_start();

$search = $db->prepare('SELECT * FROM my_profile WHERE skill=?');
$search -> execute(array(
    $_SESSION['skill']
));

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
            <h1>教えてくれる友達を探す</h1>
        </header>

        <div class="main">
                <?php while ($sc = $search->fetch()): ?>
                    
                    <div class="sentence">
                    　　 <p class="name">名前  ：  <?php print(htmlspecialchars($sc['name'],ENT_QUOTES));?></p>
                        <p class="skill">資格・技術  ：  <?php print(htmlspecialchars($sc['skill'],ENT_QUOTES));?></p>   
                        <p class="remarks">備考  ：  <?php print(htmlspecialchars($sc['remarks'],ENT_QUOTES));?></p>
                    </div> 
                    
                    <img class="picture" src="member_picture/<?php print(htmlspecialchars($sc['picture'],ENT_QUOTES)); ?>" 
                            height="20%" width="20%" alt="NO IMAGE">

                <div class="input">            
                    <form action="opProfile.php" method="post">  
                        <input type="hidden" name="op_id" value="<?php print(htmlspecialchars($sc['id'],ENT_QUOTES));?>">        
                        <input class="profile" type="submit" value="プロフィールの表示">
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