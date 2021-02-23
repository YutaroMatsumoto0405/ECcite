<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>購入完了</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>">
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'finish_view.css'); ?>">
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