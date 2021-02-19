<?php


// 数量の正規表現
// トランザクション
// デザイン修正


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
$search = '';

    
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 
 
try {
     
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['sql_type'])) {
            $sql_type = html_enc($_POST['sql_type']);
        }
        
        // data_searchがクリックされたときにsearchに値が入っていたら
        if($sql_type === 'data_search'){
            if(isset($_POST['search'])) {
                $search = html_enc($_POST['search']);
            }
            
            // \ (option + ¥) これが必要な理由調べる
            $sql = 'select id,name,price,img,status,stock,category,comment from items WHERE name LIKE \'%'.$search.'%\' and items.status = 1';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $data = $rows;
       
        } else {
            $sql = 'select id,name,price,img,status,stock,category,comment from items WHERE category = '.$sql_type.' and items.status = 1';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $data = $rows;
    
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
        <title>トップ</title>
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
            
            .home {
                /*background-image: url(home_icon.png);*/
                background-size: contain;
                background-repeat: no-repeat;
                background-position: 150px;
                display: block;
                /*padding-left: 25px;*/
            }
            .register {
                /*background-image: url(register_icon.png);*/
                background-size: contain;
                background-repeat: no-repeat;
                background-position: 185px;
                display: block;
                padding-left: 25px;
            }
            .login {
                /*background-image: url(rogin_icon.png);*/
                background-size: contain;
                background-repeat: no-repeat;
                background-position: 180px;
                display: block;
                padding-left: 25px;
            }
            .cart {
                background-image: url(cart_icon.png);
                background-size: contain;
                background-repeat: no-repeat;
                background-position: 185px;
                display: block;
                padding-left: 25px;
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
            
            .masc {
                width: 730px;
            }
            
            .item img {
                width: 150px;
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
                    <li class="home"><a href="top.php">ホーム</a></li>
                    <li class="register"><a href="register.php">新規登録</a></li>
                    <li class="login"><a href="login.php">ログイン</a></li>
                    <!--<li class="cart"><a href="cart.php">買い物かご</a></li>-->
                </ul>
            </div>
            </header>
            
            <div class="bgcolor">
            <main>
                <nav>
                    <div class="frame1">
                    <h2>SEARCH</h2>
                    
                    <form action="top.php" method="post">
                        <input type="text" name="search">
                        <input type="hidden" name="sql_type" value="data_search">
                        <input type="submit" value="探す" />
                    </form>
                    </div>
                    <div class="frame">
                    <h2>CATEGORY</h2>
                    <ul>
                        
                        <form method="post" name="men" action="top.php">
                            <li><a href="javascript:men.submit()">men</a></li>
                            <input type="hidden" name="sql_type" value="0">
                        </form>

                        <form method="post" name="woman" action="top.php">
                            <li><a href="javascript:woman.submit()">woman</a></li>
                            <input type="hidden" name="sql_type" value="1">
                        </form>

                        <form method="post" name="kids" action="top.php">
                            <li><a href="javascript:kids.submit()">kids</a></li>
                            <input type="hidden" name="sql_type" value="2">
                        </form>

                        <form method="post" name="color" action="top.php">
                            <li><a href="javascript:color.submit()">color</a></li>
                            <input type="hidden" name="sql_type" value="3">
                        </form>

                        <form method="post" name="simple" action="top.php">
                            <li><a href="javascript:simple.submit()">simple</a></li>
                            <input type="hidden" name="sql_type" value="4">
                        </form>
                        
                    </div>
                    </ul>
                    
                </nav>
                
                <article>
                    
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'){ ?>
                        <?php if(isset($_POST['sql_type']) === TRUE) { ?>
                                
                                <div class="thing clearfix">
                                    
                                <?php foreach ($data as $value) { ?>
                                
                                
                                <div class="item">
                                    <p><a href="login.php"><img  src=" <?php print $img_dir . $value['img']; ?>"></a></p>
                                    <p><?php print html_enc($value['name']); ?></p>
                                    <p><?php print $value['price'] ; ?>円 </p>
                                </div>
                                
                                </div>
                                <?php } ?>
                            <?php } ?>
                    <?php  } else {?>
                             <img class="masc" src="bara-buri-1NPbmHxl_VE-unsplash (1).jpg">
                    <?php } ?>
                    
                </article>
                
            </main>
            </div>
    
        </body>
</html>