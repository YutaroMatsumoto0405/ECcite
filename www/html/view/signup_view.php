<!DOCTYPE html>
<html lang="ja">
    <head>  
        <meta charset="utf-8">
        <title>新規登録</title>
        <link rel='stylesheet' href='/asset/css/signup_view.css'/>
    </head>
    <body>
        <?php include __DIR__ . '/templates/header.php';?>
        <h1>新規登録</h1>
        <div class="bgcolor">
            <main>
                <div class="roginInfo">    
                <?php include __DIR__ . '/templates/messages.php'; ?>
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
                                <div class="Button">
                                    <input type="submit" value="新規登録" class="button">
                                    <input type="hidden" name="token" value=<?php print $token ?>>
                                </div>
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