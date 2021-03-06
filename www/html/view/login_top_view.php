<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8">
        <title>ログイントップ</title>
        <link rel='stylesheet' href='/asset/css/login_top_view.css'/>
    </head>
    <body>
    <?php include __DIR__ . '/templates/header_login.php';?>
    <?php include __DIR__ .'/templates/messages.php'; ?>
        <main>
        <div  class="clearfix">
            <?php include __DIR__ . '/templates/login_search.php';?>
                <article>
                    <!-- ソート -->
                    <form method="post" >
                        <select name="sort">
                            <option value="new" <?php if($sort === 'new') { ?> selected <?php } ?>>新着順</option>
                            <option value="low" <?php if($sort === 'low') { ?> selected <?php } ?>>価格の安い順</option>
                            <option value="high" <?php if($sort === 'high') { ?> selected <?php } ?>>価格の高い順</option>
                        </select>
                        <input type="hidden" name="sqltype" value="sort">
                        <input type="submit" name="sort_button" value="並び替え">
                    </form>
                        <?php if (count($items) > 0){ ?>
                            <div class="flex-container">
                                <?php foreach($items as $item) { ?>
                                    <form method="post" action="details_item.php">
                                        <div class="thing clearfix">        
                                        <div class="flex-item">
                                            <p><img  src=" <?php print IMAGE_PATH .  $item['img']; ?>" width="300" height="200"></p>
                                            <p><?php print h($item['name']); ?></p>
                                            <p><?php print h(number_format($item['price'])) ; ?>円 </p>
                                            <input type="hidden" name="item_id" id="item_id" value="<?php print $item['item_id']; ?>">
                                            <input type="hidden" name="token" value="<?php print $token ?>">
                                            <input type="submit" value="商品説明を表示">
                                        </div>  
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                            <?php } else{ ?>
                                        <p>商品はありません</p>
                            <?php } ?>
                                </div>
                </article>
        </div>   
        </main>
    </body>
</html>