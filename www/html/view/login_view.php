<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8"> 
        <title>ログイン</title>
        <link rel='stylesheet' href='/asset/css/login_view.css'/>
    </head>
    <body>
        <?php include __DIR__ . '/templates/header.php';?>
        <h1>ログイン</h1>
        <div class="bgcolor">
            <main>   
            <?php include __DIR__ .'/templates/messages.php'; ?>
               <div class="roginInfo"> 
                    <p>ご登録いただいたユーザーIDとパスワードを入力し、「ログイン」ボタンを押してください。</p>
                    <div class="userBorder">
                        <div class="user">
                            <form method="post" action="login_process.php">
                                <div class="user2">
                                    <h3>ユーザーID(半角)</h3>
                                </div>
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
                    <div class="Button">                
                        <form action="top.php">    
                            <input type="submit" value="ホームに戻る" class="button">
                        </form>
                    </div>
                    <div class="rink">
                        <a href="signup.php">新規登録はこちらから</a>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>