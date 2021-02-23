<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8">
        <title>ログイン</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>"> 
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>" >
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