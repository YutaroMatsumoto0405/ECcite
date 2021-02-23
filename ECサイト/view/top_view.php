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

            .masc {
                width: 730px;
            }
            .item img {
                width: 150px;
            }
        </style>
    </head> 
        <body>
            <?php include VIEW_PATH . 'templates/header.php'; ?>
            <div class="bgcolor">
            <main>
                <?php include VIEW_PATH . 'templates/search.php';?>
                <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <article>
                    <!-- 検索またはカテゴリが押された時と通常の時で条件分岐のif -->
                    <?php if (count($items) > 0){ ?>
                        <?php foreach($items as $item) { ?> 
                            <div class="thing clearfix">        
                            <div class="item">
                                <p><a href="login_view.php"><img  src=" <?php print $item['img']; ?>"></a></p>
                                <p><?php print h($item['name']); ?></p>
                                <p><?php print $item['price'] ; ?>円 </p>
                            </div>    
                            </div>
                        <?php } ?>
                    <?php  } else {?>
                            <!-- トップ画像の読み込み -->
                             <img class="masc" src="bara-buri-1NPbmHxl_VE-unsplash (1).jpg">
                    <?php } ?>
                </article>
            </main>
            </div>
        </body>
</html>