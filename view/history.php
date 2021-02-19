<?php


$img_dir = './img/';


function html_enc($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function cut($space)
{
    return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $space);
}



$host     = 'localhost';
$username = 'codecamp41224';   
$password = 'codecamp41224';       
$dbname   = 'codecamp41224';
$charset  = 'utf8';   
 
    
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 
 
try {
     
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    
    session_start();
    
    // セッション変数からuser_id取得 いきなりここをひらけない処理がここ 変数がないから
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
      $user_id = $_SESSION['user_id'];
      $username = $_SESSION['username'];
    } else {
      // 非ログインの場合、ログインページへリダイレクト
      header('Location: login.php');
      exit;
    }


    // ユーザIDの取得　受け取ったid nameが正しいかどうかの処理がここ
    $sql= 'SELECT id,username FROM users WHERE id = \'' . $user_id . '\' AND username = \'' . $username . '\'';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $data = $rows;
     
    // 一致しなかったら
    if (!isset($data[0]['id'])) {
  
      // ユーザ名が取得できない場合、ログアウト処理へリダイレクト
      header('Location: logout.php');
      exit;
    }    
    
    
    
    
            
$sql = 'select history_id,user_id,item_id,img,name,price from history';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
$data = $rows;
  


} catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();

}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>購入履歴</title>
        <link rel="stylesheet" href="html5reset-1.6.1.css">
        <style type="text/css">
        
            body {
                margin: 0;
                min-width: 960px;
                
            }
            .top {
                background-color: #E1DCDC;
            }
        
            header {
                width: 960px;
                margin: 0 auto;
                
            }
            .logo {
                text-align: center;
                padding: 10px 0;
            }
            .logo>img {
                padding: 10px 0;
            }
            header ul {
                display: flex;
                justify-content: space-around;
                list-style: none;
                margin: 10px 0;
                padding-left: 0;
            }
            header ul a {
                text-decoration: none;
                display: block;
                color: #222222;
            }
            header ul li {
                flex: 1;
                text-align: center;
                font-size: 19px;
                padding-bottom: 3px;
            }
            header ul li+li {
                border-left: solid 1px #cccccc;
            }
            
            .bgcolor {
                background: -webkit-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
                background: -o-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
                background: repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
                border-bottom: ridge 4px;
            }

            main {
                width: 840px;
                margin: 0 auto;
            }
            
            .day {
                text-align: center;
            }
            
            .border {
               border-bottom: ridge 4px;
               
            }
            
            h1 {
                text-align: center;
            }
            
            .all {
                display: flex;
                justify-content: space-around;
                padding: 40px 0;
            } 

            img{
                width: 200px;
                
            }
            
            
            
            .cartIn {
                padding-top: 40px;
            }

            
        </style>
    </head>
    <body>
        <div class="top">
        <header>
            <div class="logo">
                <img src="logo.top.jpg">
            </div>
            <ul>
                <li class="home"><a href="#">ホーム</a></li>
                <li class="register"><a href="cart.php">買い物かご</a></li>
                <li class="login"><a href="history.php">購入履歴</a></li>
                <li class="login"><a href="favorite.php">お気に入り</a></li>
                <li class="cart"><a href="logout.php">ログアウト</a></li>
                </ul>
        </header>
        </div>   

        <div class="border">
            <h1>購入履歴</h1>
        </div>
        
        <div class="bgcolor">
            
            <main>
                
                <p class="day">購入日時</p>
                
                <div class="all">
                
                <?php foreach ($data as $value) { ?>
                
                    <img src="<?php print $img_dir . $value['img']; ?>">
                    
                    <div class="info">
                    
                        <p><?php print html_enc($value['name']); ?></p>
                        
                        <p><?php print $value['price']; ?>円</p>
                        
                        
                    </div>
                    
                    <!--もう一度購入するを押したらカートに入る処理を書く-->
                    <div class="cartIn">
                        <form action="cart.php" method="post">
                            <input type="hidden" name="sql_type" value="cart_in">
                            <input type="hidden" name="id" value="<?php print $value['item_id']; ?>">
                            <input type="submit" name="cart" value="もう1度購入する">
                        </form>
                    </div>    
                <?php } ?>    
                    
                </div>
            </main>
        </div>
             
        
    </body>
</html>