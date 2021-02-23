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
            <?php include VIEW_PATH . 'templates/messages.php'; ?>
               <div class="roginInfo">
                    <p>ご登録いただいたユーザーIDとパスワードを入力し、「ログイン」ボタンを押してください。</p>
                    <div class="userBorder">
                        <div class="user">
                            <div class="user2">
                                <h3>ユーザーID(半角)</h3>
                            </div>
                            <form action="login_process.php" method="post">
                                <div class="user3">
                                    <input type="text" name="name" id="name" size="30">
                                </div>
                                <div class="user2">
                                    <h3>パスワード(半角英数字)</h3>
                                </div>
                                <div class="user3">
                                    <input type="password" name="password" id="password" size="30">
                                </div>
                                <div class="Button">
                                    <input type="submit" value="ログイン" class="button">
                                    <input type="hidden" name="token" value=<?php print $token ?>> 
                                </div> 
                            </form>
                        </div> 
                    </div>                         
                        <form action="top_view.php">    
                            <input type="submit" value="ホームに戻る" class="button">
                        </form>
                        <div class="rink">
                            <a href="signup_view.php">新規登録はこちらから</a>
                        </div>
                </div>
            </main>
        </div>
    </body>
</html>