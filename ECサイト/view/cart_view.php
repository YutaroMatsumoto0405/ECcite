<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>カート</title>
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
        .all {   
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
            <div class="all">
            <?php if(count($carts) > 0){ ?>
                <?php foreach ($carts as $cart) { ?>
                        <img src="<?php print(IMAGE_PATH . $cart['img']); ?>">
                    <div class="info">
                        <p><?php print h($cart['name']); ?></p>
                        <p><?php print h(number_format($cart['price'])); ?>円</p>
                        <!--削除ボタン-->
                        <form method="post" action="cart_delete_cart.php">
                            <input type="hidden" name="item_id" value="<?php print $cart['item_id']; ?>">
                            <input type="hidden" name="token" value="<?php print $token ?>">">
                            <input type="submit" name="delete" value="削除">
                        </form>
                    </div>
                        <form method="post" action="cart_change_amount.php">
                            <input type="number" name="amount" value = "<?php print h($cart['amount']); ?>" >個
                            <input type="hidden" name="cart_id" value="<?php print $cart['cart_id']; ?>">
                            <input type="hidden" name="token" value="<?php print $token ?>">
                            <input type="submit" value="変更">
                        </form>
                    <!--単価×数量の合計金額を表示,-->
                    <p class="cost"><?php h(number_format($cart['price'] * $cart['amount'])); ?>円</p>
                <?php } ?> 
                    <!--購入するボタン、cssを後で整える-->
                    <form method="post" action="finish.php">
                        <input type="submit" value="購入する">
                    </form>
                    <!--トータルの合計金額を表示-->
                    <p class="total">合計金額<?php print h(number_format($total_price)); ?>円</p>
            <?php } else { ?>
                <p>カートに商品はありません</p>
            <?php } ?>
            </div>
        </main>
        </div>  
    </body>
</html>