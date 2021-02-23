<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>登録完了</title>
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
            .registerText {
                width: 710px;
                margin: 0 auto;
            }
            .registerText p {
                text-align: center;
                padding-top: 40px;
            }
            .registerText a {
                text-decoration: none;
                color: #008BBB;
                transition: 0.2s;
            }
            .registerText a:hover {
                color: #FF69A3;
            }
            .goLogin {
                text-align: right;
                padding: 30px 0;
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
        <div class="bgcolor">
            <main>    
                <div class="registerText">  
                    <p>アカウントの作成が完了しました。</p>       
                    <p>ログインページからログインしてください。</p>    
                    <div class="goLogin">
                        <a href="login_view.php">ログインページへ</a>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>