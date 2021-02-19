
<?php


$img_dir = './img/';
$err_msg = [];

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



    
        if(isset($_GET['sql_type'])) {
            $sql_type = html_enc($_GET['sql_type']);
        }
        
        // topで画像がクリックされた時の処理
        if($sql_type === 'item_img'){
            if(isset($_GET['id'])) {
                $select_id = $_GET['id'];
            } else {
                $err_msg[] = '不正な処理です';
            }
            
            
            if(count($err_msg) === 0) {
                try {
                
                    // ここ
                    $sql = 'select id,name,price,img,status,stock,category,comment 
                            from items 
                            WHERE id = '. $select_id .'';
                            
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    $data = $rows;

                } catch (PDOException $e) {
                    $dbh->rollback();
                    throw $e;
                }
            }
            
            
        }            
    

    
} catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();

}            

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>詳細</title>
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
            }

            main {
                display: flex;
                width: 960px;
                margin: 0 auto;
                padding-top: 30px;
                
            }
            nav {
                width: 210px;
                padding-right: 20px;
            }
            nav ul li {
                border-bottom: dotted 1px #DDDDDD;
                margin: 15px 0;
                font-size: 18px;
                list-style: none;
            }
            nav ul li a {
                text-decoration: none;
                color: #333333;
            }
            
            .frame1 {
                padding-bottom: 60px;
            }
            h2 {
                text-align: center;
                padding-bottom: 15px;
            }
            .search {
                height: 23px;
                border-radius: 10px;
            }
            
            article {
                margin: 0 auto;
            }
            
            img{
                width: 400px;
                
            }
            
            .product {
                padding: 20px 0;
            }
            
            .color {
                color: red;
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
                <!--ログイン中はlogin.topに、ログアウト中はtop.phpに-->
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
            <nav>
                <div class="frame1">
                <h2>SEARCH</h2>
                    
                <form action="login_top.php" method="post">
                    <input type="text" name="search">
                    <input type="hidden" name="sql_type" value="data_search">
                    <input type="submit" value="探す" />
                </form>
                </div>
                <div class="frame">
                    <h2>CATEGORY</h2>
                <ul>
                    <!--aタグをpost、どうやる？-->
                    <form method="post" name="men" action="login_top.php">
                        <li><a href="javascript:men.submit()">men</a></li>
                        <input type="hidden" name="sql_type" value="0">
                    </form>
                    <form method="post" name="woman" action="login_top.php">
                        <li><a href="javascript:woman.submit()">woman</a></li>
                        <input type="hidden" name="sql_type" value="1">
                    </form>

                    <form method="post" name="kids" action="login_top.php">
                        <li><a href="javascript:kids.submit()">kids</a></li>
                        <input type="hidden" name="sql_type" value="2">
                    </form>

                    <form method="post" name="color" action="login_top.php">
                        <li><a href="javascript:color.submit()">color</a></li>
                        <input type="hidden" name="sql_type" value="3">
                    </form>
                    <form method="post" name="simple" action="login_top.php">
                        <li><a href="javascript:simple.submit()">simple</a></li>
                        <input type="hidden" name="sql_type" value="4">
                    </form>
                        
                </div>
                </ul>
                    
            </nav>
                <article>

                    <?php foreach ($data as $value) { ?>
                    
                        <img src="<?php print $img_dir . $value['img']; ?>">
                    
                            <p class="product"><?php print html_enc($value['name']); ?></p>
                            
                            <p class="product"><?php print $value['price']; ?>円</p>
                                
                            <p class="product"><?php print $value['comment']; ?></p>
                        
                        <div class="color">
                            <?php if($value['stock'] === 0) { ?>
                                <?php print '売り切れ' ?>
                            <?php } else { ?>
                                        <form action="cart.php" method="post">
                                            <input type="hidden" name="sql_type" value="cart_in">
                                            <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                                            <input type="submit" name="cart" value="カートに追加">
                                        </form>
                            <?php } ?>
                        <form action="favorite.php" method="post">
                            <input type="hidden" name="sql_type" value="favorite_in">
                            <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                            <input type="submit" name="favorite" value="お気に入り">
                        </form>
                        
                        <?php } ?>
                            
                </article>
            
        </main>
        </div>
          
    </body>
</html>