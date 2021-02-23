<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>詳細</title>
        <link rel="stylesheet" href="html5reset-1.6.1.css">
        <style type="text/css">
            body {
                margin: 0;
                min-width: 960px;    
            }
            .bgcolor {
                background: -webkit-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
                background: -o-repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
                background: repeating-linear-gradient(-45deg,#EEEEEE 0,#EEEEEE 2px,#fff 2px,#fff 20px);
            }
            main {
                display: flex;
                width: 960px;
                margin: 0 auto;
                padding-top: 30px;   
            }
            article {
                margin: 0 auto;
            }
            img{
                width: 400px;   
            }
            .product {
                padding: 20px 0;
            }
            .color {
                color: red;
            }
            
        </style>
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