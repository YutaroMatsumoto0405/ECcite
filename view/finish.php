<?php


$img_dir = './img/';
$err_msg = [];
$date = date('Y-m-d H:i:s');
$sum = 0;

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
    
    
    // ここに「購入する」が押された時の処理を書く
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
    
    if($sql_type === 'purchase') {
       
        
        if(count($err_msg) === 0) {
    
            try {
                $sql = 'select items.id , items.name , items.price , items.img  , carts.user_id , carts.amount from items inner join carts on items.id = carts.item_id where user_id = '. $user_id . '';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $data = $rows;
               
                
                foreach($data as $value) {
                    $item_id = $value['id'];
                    $name = $value['name'];
                    $price = $value['price'];
                    $amount = $value['amount'];
                    $remain_amount = $amount - 1;
                    $item_name = $value['name'];
                    $img = $value['img'];
                    
                    try {
                        // ストック更新
                        $sql = 'UPDATE items 
                                SET stock = stock-?,
                                    updatedate = ?
                                WHERE id = ?';
                        $stmt = $dbh->prepare($sql);
                        $stmt->bindValue(1,$amount, PDO::PARAM_STR);
                        $stmt->bindValue(2,$date, PDO::PARAM_STR);
                        $stmt->bindValue(3,$item_id, PDO::PARAM_INT);
                        $stmt->execute();
                            
                    } catch (PDOException $e) {
                        
                        throw $e;
                    }
                
                    try {
                        // 履歴追加
                        $sql = 'insert into history(user_id,item_id ,img, name, price , createdate) values(?,?,?,?,?,?)';
                        $stmt = $dbh->prepare($sql);
                        $stmt->bindValue(1,$user_id, PDO::PARAM_INT);
                        $stmt->bindValue(2,$item_id, PDO::PARAM_INT);
                        $stmt->bindValue(3,$img, PDO::PARAM_STR);
                        $stmt->bindValue(4,$name, PDO::PARAM_STR);
                        $stmt->bindValue(5,$price, PDO::PARAM_INT);
                        $stmt->bindValue(6,$date, PDO::PARAM_INT);
                        $stmt->execute();
                                
                    } catch (PDOException $e) {
                        
                        throw $e;
                    }
                        
                    
                }
            
            } catch (PDOException $e) {
                            
                throw $e;
            }


                
            // カート中削除
            try {
                $sql = 'DELETE 
                        FROM carts
                        WHERE user_id = ?';
                        
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$user_id, PDO::PARAM_INT);
                $stmt->execute();
                  
                
            } catch (PDOException $e) {
                    
                throw $e;
            }
   
        }      
    }
}

        // $sql = 'select items.id , items.name , items.price , items.img  , carts.user_id , carts.amount from items inner join carts on items.id = carts.item_id where user_id = '. $user_id . '';
        // $stmt = $dbh->prepare($sql);
        // $stmt->execute();
        // $rows = $stmt->fetchAll();
        // $data = $rows;
 
 



} catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();


}


?>



<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>購入完了</title>
        <link rel="stylesheet" href="html5reset-1.6.1.css">
        <style type="text/css">
            
        body {
            min-width: 960px;
            margin: 0;
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
        
        .result {
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
        
        .amount {
            margin-top: 40px;
        }
        
        .cost {
            margin-top: 40px;
        }
        
        .total {
            width: 400px;
            float: right;
            padding-top: 30px;
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
        <div class="bgcolor">
        <main>
            
            <p class="result">以下の商品を購入しました。</p>
            
            <div class="all">
                <?php if(count($err_msg) === 0) { ?>
                    
                    <?php foreach ($data as $value) { ?>
                            
                            <img src="<?php print $img_dir . $value['img'] ; ?>">
                                
                        <div class="info">
                        
                            <p><?php print html_enc($value['name']);?></p>
                            
                        </div>
                        
                        
                            <p>数量<?php print $value['amount']; ?>個</p>
                        
                        
                        <p class="cost"><?php print $value['price']; ?>円</p>
                        
                        <?php $sum += $value['price'] * $value['amount'] ?>
                    
                    <?php } ?>
                
                <?php } ?>
            </div>
            
            
        </main>
        </div>
        
        <p class="total">合計金額<?php print $sum ?>円</p>
        
    </body>
</html>