<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8">
        <title>詳細</title>
        <link rel='stylesheet' href='/asset/css/details_item_view.css'/>
    </head>
    <body>
        <?php include __DIR__ . '/templates/header_login.php';?>
        <div class="bgcolor">
        <main>
        <?php include __DIR__ . '/templates/login_search.php';?>
        <?php include __DIR__ .'/templates/messages.php'; ?>
            <article>
                <?php foreach ($item_details as $item) { ?>
                    <p><img  src=" <?php print IMAGE_PATH .  $item['img']; ?>" width="400" height="300"></p>
                    <p class="product"><?php print h($item['name']); ?></p>
                    <p class="product"><?php print h(number_format($item['price'])); ?>円</p>    
                    <p class="product"><?php print $item['comment']; ?></p>
                    <?php if($item['stock'] === 0) { ?>
                        <?php print '売り切れ' ?>
                    <?php } else { ?>
                        <div class="botton">
                            <form action="cart_insert_item.php" method="post">
                                <input type="hidden" name="item_id" id="item_id" value="<?php print $item['item_id']; ?>">
                                <input type="hidden" name="img" id="img" value="<?php print $item['img']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="submit" name="cart" value="カートに追加">
                            </form>
                        </div>
                    <?php } ?> 
                    <!-- favoriteをselectして追加か外すかの分岐 -->
                    <?php if(count($check_favorite) === 0){ ?>
                        <div class="botton">
                            <form action="favorite_insert.php" method="post">
                                <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                                <input type="hidden" name="img" id="img" value="<?php print $item['img']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="submit" name="favorite" value="お気に入りに追加">
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="botton">
                            <form action="favorite_delete.php" method="post">
                                <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="submit" name="favorite" value="お気に入りから外す">
                            </form> 
                        </div>
                    <?php } ?>
                <?php } ?>
            </article>
        </main>
        </div>
    </body>
</html>