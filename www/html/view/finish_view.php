<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>購入完了</title>
        <link rel='stylesheet' href='/asset/css/finish_view.css'/>
    </head>
    <body>
        <?php include __DIR__ . '/templates/header_login.php';?>
        <div class="bgcolor">
        <main>
        <?php include __DIR__ .'/templates/messages.php'; ?>
            <p class="result">以下の商品を購入しました。</p>
            <div class="all">
                <?php foreach ($carts as $cart) { ?>
                    <img src="<?php print(IMAGE_PATH . $cart['img']); ?>" width="300" height="200">
                    <div class="info">
                        <p><?php print $cart['name'];?></p>
                    </div>
                        <p>数量<?php print $cart['amount']; ?>個</p>
                    <p class="cost"><?php print h(number_format($cart['price'] * $cart['amount'])); ?>円</p>
                <?php } ?>
            </div>
        </main>
        </div>
        <p class="total">合計金額 <?php print h(number_format($total_price)); ?>円</p>
    </body>
</html>