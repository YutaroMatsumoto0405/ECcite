<?php


$img_dir = './img/';
$date = date('Y-m-d H:i:s');
$err_msg =[];

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
    
    
    
    
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['sql_type']) === TRUE) {
        $sql_type = $_POST['sql_type'];
    }
    
    // 削除
    if($sql_type === 'data_delete') {
        if(isset($_POST['favorite_id']) === TRUE) {
            $favorite_id = $_POST['favorite_id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['delete']) === TRUE) {
            $delete = $_POST['delete'];
            $success_msg[] = '削除しました';
            
        if(count($err_msg) === 0) {
            try {
                $sql = 'DELETE 
                        FROM favorite
                        WHERE favorite_id = ?';
                        
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$favorite_id, PDO::PARAM_INT);
                $stmt->execute();
                   
            } catch (PDOException $e) {
                
              throw $e;
              
            }
        }
        }
        
    } else if ($sql_type === 'favorite_in'){
        if(isset($_POST['id']) === TRUE){
            $item_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['favorite']) === TRUE) {
            $favorite = $_POST['favorite'];
        }
        
        try {
            
            $sql = 'select user_id,item_id from favorite where user_id = '. $user_id . ' and item_id = '. $item_id . '';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $data = $rows;
            
            
            if(count($data) === 0) {
                $sql = 'insert into favorite(user_id , item_id, createdate) values(?,?,?)';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$user_id, PDO::PARAM_INT);
                $stmt->bindValue(2,$item_id, PDO::PARAM_INT);
                $stmt->bindValue(3,$date, PDO::PARAM_STR);
                $stmt->execute();
                
                
            } else {
                $sql = 'DELETE 
                        FROM favorite
                        WHERE favorite_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$item_id, PDO::PARAM_INT);
                $stmt->execute();
            }
                   
        } catch (PDOException $e) {
            throw $e;
              
        }
  
            }
    
    
}    
    
        $sql = 'select items.id , items.name , items.price , items.img  , favorite.user_id  from items inner join favorite on items.id = favorite.item_id where user_id = '. $user_id . '';
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
        <title>お気に入り</title>
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
            
            .border {
                border-bottom: ridge 4px;
               
            }
            
            h1 {
                text-align: center;
            }
            
            .all {
                text-align: center;
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
                <li class="home"><a href="login_top.php">ホーム</a></li>
                <li class="register"><a href="cart.php">買い物かご</a></li>
                <li class="login"><a href="history.php">購入履歴</a></li>
                <li class="login"><a href="favorite.php">お気に入り</a></li>
                <li class="cart"><a href="logout.php">ログアウト</a></li>
                </ul>
        </header>
        </div>

        <div class="border">
            <h1>お気に入り商品一覧</h1>
        </div>
            
        <div class="bgcolor">
            
          <main>
                
                <div class="all">
                
                <?php foreach ($data as $value) { ?>
                
                    <img src="<?php print $img_dir . $value['img']; ?>">
                    
                    <div class="info">
                    
                        <p><?php print html_enc($value['name']); ?></p>
                        
                        <p><?php print $value['price']; ?>円</p>
                        
                        <form method="post" action="favorite.php">
                            <input type="hidden" name="sql_type" value="data_delete">
                            <input type="hidden" name="favorite_id" value="<?php print $value['id']; ?>">
                            <input type="submit" name="delete" value="削除">
                        </form>
                        
                    </div>
                    
                    
                    
                    <div class="cartIn">
                         <form action="cart.php" method="post">
                            <input type="hidden" name="sql_type" value="cart_in">
                            <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                            <input type="submit" name="cart" value="カートに追加">
                        </form>
                    </div>    
                    
                <?php } ?> 
                    
                </div>
            </main>
        </div>
             
        
    </body>
</html>