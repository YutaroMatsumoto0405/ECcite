<?php


$img_dir = './img/';
$date = date('Y-m-d H:i:s');
$sum = 0;
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
        if(isset($_POST['cart_id']) === TRUE) {
            $cart_id = $_POST['cart_id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['delete']) === TRUE) {
            $delete = $_POST['delete'];
            
            
        if(count($err_msg) === 0) {
            try {
                $sql = 'DELETE 
                        FROM carts
                        WHERE item_id = ? and user_id = ?';
                        
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$cart_id, PDO::PARAM_INT);
                $stmt->bindValue(2,$user_id, PDO::PARAM_INT);
                $stmt->execute();
                   
            } catch (PDOException $e) {
                throw $e;
              
            }
        }
        }
        
    }  else if ($sql_type === 'cart_in'){
        if(isset($_POST['id']) === TRUE){
            $item_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        
        
        try {
            // カートテーブル 「ユーザーid　アイテムid 量　日付２つ」　「カートボタンが押されたのが1回目なら、インサート　量は１」　「2回目以降ならアップデートをかく　量はぷらす１ずつ」　セレクトでユーザーidとアイテムidが合致したらすでに入ってることになる
            
            $sql = 'select user_id,item_id,amount from carts where user_id = '. $user_id . ' and item_id = '. $item_id . '';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $data = $rows;
            
            
            
            
            if(count($data) === 0 ) {
                $sql = 'insert into carts(user_id , item_id , amount , createdate , updatedate) values(?,?,1,?,?)';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$user_id, PDO::PARAM_INT);
                $stmt->bindValue(2,$item_id, PDO::PARAM_INT);
                $stmt->bindValue(3,$date, PDO::PARAM_STR);
                $stmt->bindValue(4,$date, PDO::PARAM_STR);
                $stmt->execute();
                
                
                
            } else  {
                
                $amount = $data[0]['amount'];
                $total_amount = $amount + 1;
                // whereの中身
                $sql = 'update carts set amount = '. $total_amount .' , updatedate = ?  where item_id = ? ';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$date, PDO::PARAM_STR);
                $stmt->bindValue(2,$item_id, PDO::PARAM_INT);
                $stmt->execute();
                
            }
            
        } catch (PDOException $e) {
            throw $e;
        }
        
    } else if ($sql_type === 'update_amount'){
        if(isset($_POST['id']) === TRUE){
            $update_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['amount']) === TRUE) {
            $change_amount = $_POST['amount'];
            if (preg_match('/^[0-9]+$/',$change_amount) !== 1) {
                $err_msg[]  = '個数は0以上の半角数字で入力してください';
            } 
            
            if(count($err_msg) === 0) {
                try {
                    $sql =  'UPDATE carts 
                            SET amount = ?,
                            updatedate = ?
                            WHERE item_id = ? and user_id = ?';
                    $stmt = $dbh->prepare($sql);
                    // bibdvalue セキュリティ面
                    $stmt->bindValue(1,$change_amount, PDO::PARAM_STR);
                    $stmt->bindValue(2,$date, PDO::PARAM_INT);
                    $stmt->bindValue(3,$update_id, PDO::PARAM_INT);
                    $stmt->bindValue(4,$user_id, PDO::PARAM_INT);
                    $stmt->execute();
                
                    
                
                } catch (PDOException $e) {
                    
                    throw $e;
                }
            }
        }
    }  
}    
    

        $sql = 'select items.id , items.name , items.price , items.img  , carts.user_id , carts.amount from items inner join carts on items.id = carts.item_id where user_id = '. $user_id . '';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $data = $rows;
 
 var_dump($data);
            
} catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();
}


?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>カート</title>
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
        
        .all {
            
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
            <div class="all">
        
                <?php foreach ($data as $value) { ?>
            
                <img src="<?php print $img_dir . $value['img']; ?>">
                
                <div class="info">
                
                    <p><?php print html_enc($value['name']); ?></p>
                    
                    <p><?php print $value['price']; ?>円</p>
                    
                    <!--削除ボタン-->
                    <form method="post" action="cart.php">
                        <input type="hidden" name="sql_type" value="data_delete">
                        <input type="hidden" name="cart_id" value="<?php print $value['id']; ?>">
                        <input type="submit" name="delete" value="削除">
                    </form>
                    
                </div>
                
                <!--デフォルトで1個、数量を変更するボタンを設置-->
                <form method="post" action="cart.php">
                    <input type="text" name="amount" value = "<?php print $value['amount'] ; ?>" ><label>個</label>
                    <input type="hidden" name="sql_type" value="update_amount">
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                    <input type="submit" value="変更">
                </form>
               
                
                <?php var_dump($value['amount']); ?>
              
                <!--単価×数量の合計金額を表示,-->
                <p class="cost"><?php $sum += $value['price'] * $value['amount'] ?></p>
                
                
                <?php } ?> 
                
            </div>
        
            
        </main>
        </div>
            <!--購入するボタン、cssを後で整える-->
            <form action="finish.php" method="post">
                <input type="hidden" name="sql_type" value="purchase">
                <!--ないなら-->
                <input type="submit" value="購入する">
            </form>
 
        
        <!--トータルの合計金額を表示-->
        <p class="total">合計金額<?php print $sum ?>円</p>
        
    </body>
</html>