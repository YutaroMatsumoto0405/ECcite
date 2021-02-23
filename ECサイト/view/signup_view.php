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
    <?php include VIEW_PATH . 'templates/header.php';?>
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
                <?php include VIEW_PATH . 'templates/messages.php'; ?>
                    <p>登録情報の入力をしてください。下記必要事項を入力し、新規登録ボタンを押してください。</p>   
                    <div class="userBorder">
                        <div class="user">       
                            <div class="user2">
                                <h3>ユーザー名(半角)</h3>
                            </div>            
                            <form method="post" action="signup_process.php">
                                <div class="user3">
                                    <input type="text" name="name" id="name" size="30">
                                </div>     
                                <div class="user2">
                                    <h3>パスワード(半角英数字)</h3>
                                </div>         
                                <div class="user3">
                                    <input type="password" name="password" id="password" size="30">
                                </div>             
                                <div class="user2">
                                    <h3>パスワード(確認)</h3>
                                </div>         
                                <div class="user3">
                                    <input type="password" name="password_confirmation" id="password_confirmation" size="30">
                                </div>
                                <input type="submit" value="新規登録" class="button">
                                <input type="hidden" name="token" value=<?php print $token ?>>
                            </form>       
                        </div> 
                    </div>   
                    <div class="Button">
                        <form action="top_view.php">
                            <input type="submit" value="戻る" class="button">
                        </form>   
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>