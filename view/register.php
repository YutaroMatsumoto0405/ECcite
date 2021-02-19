<?php

$name = 0;
$date = date('Y-m-d H:i:s');
$data = array();
$err_msg =[];
$success_msg = [];

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
  


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['sql_type']) === TRUE) {
        $sql_type = $_POST['sql_type'];
    }
    if($sql_type === 'register') {
        if(isset($_POST['username'])) {
            $username = $_POST['username'];
            
        try {    
            
            $sql = 'select username from users where username = \''. $username . '\'';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $data = $rows;
            
            
            if(count($data) !== 0){
                $err_msg[] = 'このユーザー名は既に使用されています';
            }
        
        } catch (PDOException $e) {
            print 'err';
            throw $e;
        }
        
            
                // 半角英数字エラー
                if(mb_strlen($username) <= 6) {
                    $err_msg[] = '文字数は6文字以上で入力してください';
                }else if(!preg_match('/^[0-9a-zA-Z]*$/',$username) || cut($username) === ''){
                    $err_msg[] = 'ユーザー名は半角英数字で入力してください';
                }
        }
        
        if(isset($_POST['password'])) {
            $password = $_POST['password'];
            
                // 半角英数字エラー
                 if(mb_strlen($password) <= 6) {
                    $err_msg[] = 'パスワードは6文字以上で入力してください';
                }else if(!preg_match('/^[0-9a-zA-Z]*$/',$password) || cut($password) === ''){
                    $err_msg[] = 'パスワードは半角英数字で入力してください';
                }
        }
        
        if(isset($_POST['password2'])) {
            $password2 = $_POST['password2'];
                if($password !== $password2) {
                    $err_msg[] = 'パスワードが一致しません';
                }
        }
        
    
        try {
            if(count($err_msg) === 0 ) {
                // var_dump($username);
                // var_dump($password);
                $sql = 'insert into users(username , password , createdate) values(?,?,?)';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$username, PDO::PARAM_STR);
                $stmt->bindValue(2,$password, PDO::PARAM_STR);
                $stmt->bindValue(3,$date, PDO::PARAM_STR);
                $stmt->execute();
                
                // エラーなければ登録完了ページに移動
                header("Location:register_result.php");
                exit;
         
                
            }
            
        } catch (PDOException $e) {
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
        <title>新規登録</title>
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
            
            .bgcolor {
                background: -webkit-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
                background: -o-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
                background: repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
            }
            
            h1 {
                text-align: center;
                padding: 30px;
                margin-top: 0;
                border-bottom: ridge 2px;
            }
            
            .roginInfo {
                width: 710px;
                margin: 0 auto;
            }
            
            .roginInfo p {
                padding: 30px 0;
            }
            
            .roginInfo a {
                text-decoration: none;
                color: #008BBB;
                transition: 0.2s;
                
            }
            
            .roginInfo a:hover {
                color: #FF69A3;
            }
            
            .userBorder {
                border: ridge 4px;
            }
            
            .user {
                display: flex;
                flex-wrap: wrap;
                background-color: #EEEEEE;
                
            }
            
            .user2 {
                width: 350px;
                text-align: center;
            }
            
            
            .user3 {
                width: 350px;
                line-height: 64px;
                
            }
            
            .Button {
               display: flex;
               justify-content: space-around;
               padding: 40px 0;
               
            }
            
            .button {
                border-radius: 10%;
                font-size: 16px;
                background-color: #DCDCDC;
                box-shadow: 2px 2px 2px #A9A9A9;
                transition    : 0.3s;      
            }
            
            .button:hover {
                box-shadow    : none;     
                opacity       : 1;    
            }
            
        </style>
    </head>
    <body>
        <div class="top">
        <header>
        
            <div class="logo">
                <img src="logo.top.jpg">
            </div>
            
        </header>
        </div>
        <h1>新規登録</h1>
        <div class="bgcolor">
            
            <main>
                
                
                <div class="roginInfo">
                    
                <ul>
                    <?php foreach ($err_msg as $remark) { ?>
                        <li>
                            <?php print $remark ?>
                        </li>
                          
                    <?php } ?>
                </ul>
 
                 
                    
                    <p>登録情報の入力をしてください。下記必要事項を入力し、新規登録ボタンを押してください。</p>
                    
                    <div class="userBorder">
                        <div class="user">
                        
                            <div class="user2">
                                <h3>ユーザー名(半角)</h3>
                            </div>
                            
                            
                            <form method="POST">
                            <div class="user3">
                                <input type="text" name="username" size="30">
                            </div>
                        
                            <div class="user2">
                                <h3>パスワード(半角英数字)</h3>
                            </div>
                            
                            <div class="user3">
                                <input type="password" name="password" size="30">
                            </div>
                                
                            <div class="user2">
                                <h3>パスワード(確認)</h3>
                            </div>
                            
                            <div class="user3">
                                <input type="password" name="password2" size="30">
                            </div>
                            <input type="submit" value="新規登録" class="button">
                                <input type="hidden" name="sql_type" value="register" >
                            </form>
                            
                        </div> 
                    </div>
                    
                    <div class="Button">

                                
 
                        <form action="top.php">
                            <input type="submit" value="戻る" class="button">
                        </form>
                       
                    </div>
                    
                </div>
            </main>
        </div>
    </body>
</html>