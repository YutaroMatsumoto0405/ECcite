<!DOCTYPE html>
<html lang="ja">
    <head> 
        <title>カート</title>
        <link rel='stylesheet' href='/asset/css/cart_view.css'/>
    </head>
    <body>
        <?php include __DIR__ . '/templates/header_login.php';?>
        <div class="border">
            <h1>カート内商品の一覧</h1>
        </div>
            <main>
            <div class="bgcolor">
            <?php include __DIR__ .'/templates/messages.php'; ?>
                <div class="all">
                <?php if(count($carts) > 0){ ?>
                    <?php foreach ($carts as $cart) { ?>
                        <img src="<?php print(IMAGE_PATH . $cart['img']); ?>" width="400" height="300">
                        <p><?php print h($cart['name']); ?></p>
                        <p><?php print h(number_format($cart['price'])); ?>円</p>
                        <div class="botton">
                            <!-- 数量変更 -->
                            <form method="post" action="cart_change_amount.php">
                                <input type="number" name="amount" value = "<?php print h($cart['amount']); ?>" >個
                                <input type="hidden" name="item_id" value="<?php print $cart['item_id']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="submit" value="変更">
                            </form>
                        </div>
                        <!--単価×数量の合計金額を表示,-->
                        <p class="cost"><?php print h(number_format($cart['price'] * $cart['amount'])); ?>円</p>
                        <div class="botton">
                            <!--削除ボタン-->
                            <form method="post" action="cart_delete_cart.php">
                                <input type="hidden" name="item_id" value="<?php print $cart['item_id']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="submit" name="delete" value="削除">
                            </form>
                        </div>
                    <?php } ?>
                        <!--トータルの合計金額を表示-->
                        <p class="total">合計金額 <?php print h(number_format($total_price)); ?>円</p>
                        <!--購入するボタン-->
                        <form method="post" action="finish.php">
                            <input type="submit" value="購入する">
                        </form>
                <?php } else { ?>
                    <p>カートに商品はありません</p> 
                <?php } ?>
                </div>
            </main>
        </div>  
    </body>
</html>