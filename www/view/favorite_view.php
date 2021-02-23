<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>お気に入り</title> 
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'favorite_view.css'); ?>">
    </head>
    <body>
    <?php include VIEW_PATH . 'templates/header_login.php';?>
        <?php include VIEW_PATH . 'templates/search.php';?>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'search.css'); ?>">
        <div class="border">
            <h1>お気に入り商品一覧</h1>
        </div>
        <div class="bgcolor">
          <main>
          <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <div class="all">
                <?php foreach ($check_all_favorite as $all) { ?>
                    <img src="<?php print $all['img']; ?>">   
                    <div class="info">    
                        <p><?php print h($all['name']); ?></p>    
                        <p><?php print $all['price']; ?>円</p>   
                        <form method="post" action="favorite_delete.php">
                            <input type="hidden" name="item_id" value="<?php print $all['item_id']; ?>">
                            <input type="submit" name="delete" value="お気に入りから外す">
                        </form>
                    </div>
                    <div class="cartIn">
                         <form method="post" action="add_item_cart.php">
                            <input type="hidden" name="item_id" value="<?php print $al['item_id']; ?>">
                            <input type="submit" name="cart" value="カートに追加">
                        </form>
                    </div>    
                <?php } ?> 
                </div>
            </main>
        </div>
    </body>
</html>