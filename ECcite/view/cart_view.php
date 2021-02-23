<!DOCTYPE html>
<html lang="ja">
    <head> 
    <?php include VIEW_PATH . 'templates/head.php'; ?>
        <title>カート</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>">
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart_view.css'); ?>">
        
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