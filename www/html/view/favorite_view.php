<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8">
        <title>お気に入り</title>
        <link rel='stylesheet' href='/asset/css/favorite_view.css'/>
    </head>
    <body>
    <?php include __DIR__ . '/templates/header_login.php';?>
        <div class="border">
            <h1>お気に入り商品一覧</h1>
        </div>
        <div class="bgcolor">
          <main>
          <?php include __DIR__ .'/templates/messages.php'; ?>
                <div class="all">
                    <?php if (isset($check_all_favorite)) { ?>
                        <?php if(count($check_all_favorite) > 0) { ?>
                            <?php foreach ($check_all_favorite as $all) { ?>
                                <p><img  src=" <?php print IMAGE_PATH .  $all['img']; ?>" width="300" height="200"></p>
                                <div class="info">    
                                    <p><?php print h($all['name']); ?></p>    
                                    <p><?php print h(number_format($all['price'])); ?>円</p>   
                                    <form method="post" action="favorite_delete.php">
                                        <input type="hidden" name="item_id" value="<?php print $all['item_id']; ?>">
                                        <input type="hidden" name="token" value="<?php print $token ?>">
                                        <input type="submit" name="delete" value="お気に入りから外す">
                                    </form>
                                </div>
                                <div class="cartIn">
                                    <form method="post" action="cart_insert_item.php">
                                        <input type="hidden" name="item_id" value="<?php print $all['item_id']; ?>">
                                        <input type="submit" name="cart" value="カートに追加">
                                    </form>
                                </div>    
                            <?php } ?> 
                        <?php } else { ?>
                                <p>登録されている商品はありません</p>
                        <?php } ?>
                    <?php } ?>
                </div>
            </main>
        </div>
    </body>
</html>