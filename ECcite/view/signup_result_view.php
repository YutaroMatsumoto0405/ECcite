<!DOCTYPE html>
<html lang="ja">
    <head>
        <?php include VIEW_PATH . 'templates/head.php'; ?>
        <title>登録完了</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
    </head>
    <body>
    <?php include VIEW_PATH . 'templates/header.php'; ?>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'header.css'); ?>">
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