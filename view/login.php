<?php


$host     = 'localhost';
$dbusername = 'codecamp41224';   
$dbpassword = 'codecamp41224';       
$dbname   = 'codecamp41224';
$charset  = 'utf8';   
 
    
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 

$error_flag = FALSE;

 
session_start();
// セッション変数からログイン済みか確認
if (isset($_SESSION['user_id'])) {
  // ログイン済みの場合、ホームページへリダイレクト
  header('Location: login_top.php');
  exit;
}
// Cookie情報から名前を取得
if (isset($_COOKIE['username'])) {
  $username = $_COOKIE['username'];
} else {
  $username = '';
}

if (isset($_SESSION['error_flag'])) {
    $error_flag = $_SESSION['error_flag'];
    // FALSEはエラーがない状態になるので、再表示してもエラーメッセージは出ない
    $_SESSION['error_flag'] = FALSE;
} 

  
// ログイン処理
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
try {
     
    $dbh = new PDO($dsn, $dbusername, $dbpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    
    // POST値取得
    $username  = get_post_data('username');  
    $password = get_post_data('password'); 
    
    setcookie('username', $username, time() + 60 * 60 * 24 * 365);
    // ユーザIDの取得
    $sql= 'SELECT id,username FROM users WHERE username = \'' . $username . '\' AND password = \'' . $password . '\'';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $data = $rows;
     
    // 一致したら
    if (isset($data[0]['id'])) {
        // セッション変数にuser_idを保存
        $_SESSION['user_id'] = $data[0]['id'];
        $_SESSION['username'] = $data[0]['username'];
        // ログイン済みユーザのホームページへリダイレクト
        header('Location: login_top.php');
        
        exit;
    } else {
        $_SESSION['error_flag'] = TRUE;
        // ログインページへリダイレクト
        header('Location: login.php');
        exit;
    }    
} catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();

}                
    
}

//POSTデータから任意データの取得
function get_post_data($key) {
  $str = '';
  if (isset($_POST[$key])) {
    $str = $_POST[$key];
  }
  return $str;
}


?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ログイン</title>
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
            
            .rink {
                padding: 30px 0;
                text-align: right;
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
        <h1>ログイン</h1>
        <div class="bgcolor">
            
            <main>
                
                <?php if($error_flag) { ?>
                        <p><?php print 'ログインに失敗しました' ;?></p>
                <?php } ?> 
                        
                
                <div class="roginInfo">
                    <p>ご登録いただいたユーザーIDとパスワードを入力し、「ログイン」ボタンを押してください。</p>
                    
                    <div class="userBorder">
                        <div class="user">
                            <div class="user2">
                                <h3>ユーザーID(半角)</h3>
                            </div>
                                <div class="user3">
                                <form action="login.php" method="post">
                                    <input type="text" name="username" size="30">
                                </div>
                                
                                <div class="user2">
                                    <h3>パスワード(半角英数字)</h3>
                                </div>
                            
                                <div class="user3">
                                    <input type="password" name="password" size="30">
                                </div>
                                
                        </div> 
                    </div>
                        <div class="Button">
                                <input type="submit" value="ログイン" class="button">
                                <input type="hidden" name="sql_type" value="login" >
                            </form>
                            
                            
                            <form action="top.php">    
                                <input type="submit" value="ホームに戻る" class="button">
                            </form>
                        </div>
                            
                        <div class="rink">
                            <a href="register.php">新規登録はこちらから</a>
                        </div>
                </div>
            </main>
        </div>
    </body>
</html>