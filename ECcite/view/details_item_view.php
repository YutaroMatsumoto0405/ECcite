<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8">
        <title>詳細</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>">
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'details_item_view.css'); ?>">
    </head>
    <body>
        <?php include VIEW_PATH . 'templates/header_login.php';?>
        <div class="bgcolor">
        <main>
        <?php include VIEW_PATH . 'templates/search.php';?>
        <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <article>
                    <?php foreach ($item_details as $item) { ?>
                        <img src="<?php print $item['img']; ?>">
                            <p class="product"><?php print h($item['name']); ?></p>
                            <p class="product"><?php print $item['price']; ?>円</p>    
                            <p class="product"><?php print $item['comment']; ?></p>
                        <div class="color">
                            <?php if($item['stock'] === 0) { ?>
                                <?php print '売り切れ' ?>
                            <?php } else { ?>
                                        <form action="add_item_cart.php" method="post">
                                            <input type="hidden" name="item_id" id="item_id" value="<?php print $item['item_id']; ?>">
                                            <input type="submit" name="cart" value="カートに追加">
                                        </form>
                            <?php } ?>
                    <?php } ?> 
                        <!-- favoriteをselectして追加か外すかの分岐 -->
                            <?php if(count($check_favorite) === 0){ ?>
                                <form action="favorite_insert.php" method="post">
                                    <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                                    <input type="submit" name="favorite" value="お気に入りに追加">
                                </form>
                            <?php } else { ?>
                                <form action="favorite_delete.php" method="post">
                                    <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                                    <input type="submit" name="favorite" value="お気に入りから外す">
                                </form> 

                            <?php } ?>
                </article>
        </main>
        </div>
    </body>
</html>