<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>購入完了</title>
        <link rel="stylesheet" href="html5reset-1.6.1.css">
        <style type="text/css">
        body {
            min-width: 960px;
            margin: 0;
        }    
        .bgcolor {
            background: -webkit-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
            background: -o-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
            background: repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
            border-bottom: ridge 4px;
        }
        main {
            width: 840px;
            margin: 0 auto;
        }
        .result {
            text-align: center;
        }
        .all {
            display: flex;
            justify-content: space-around;
            padding: 40px 0;
        }    
        img{
            width: 200px;   
        }
        .amount {
            margin-top: 40px;
        }
        .cost {
            margin-top: 40px;
        }
        .total {
            width: 400px;
            float: right;
            padding-top: 30px;
        }    
        </style>
    </head>
    <body>
        <?php include VIEW_PATH . 'headers/header_login.php';?>
        <div class="bgcolor">
        <main>
        <?php include VIEW_PATH . 'templates/messages.php'; ?>
            <p class="result">以下の商品を購入しました。</p>
            <div class="all">
                <?php foreach ($carts as $cart) { ?>
                        <img src="<?php print $cart['img']; ?>">
                    <div class="info">
                        <p><?php print $cart['name'];?></p>
                    </div>
                        <p>数量<?php print $cart['amount']; ?>個</p>
                    <p class="cost"><?php print $cart['price']; ?>円</p>
                    <?php  $cart['amount'] * $cart['price'] ?>
                <?php } ?>
            </div>
        </main>
        </div>
        <p class="total">合計金額<?php $total_price ?>円</p>
    </body>
</html>