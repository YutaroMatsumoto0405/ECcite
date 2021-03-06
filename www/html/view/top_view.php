<!DOCTYPE html>
<html lang="ja">
    <head>   
        <meta charset="utf-8">
        <title>トップ</title>
        <link rel='stylesheet' href='/asset/css/top_view.css'/>
    </head>
    <div class="bgcolor"> 
        <body>
            <?php include __DIR__ . '/templates/header.php'; ?>
            <main>
                <?php include __DIR__ . '/templates/search.php';?>
                <article>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'){ ?>
                    <!-- 検索またはカテゴリが押された時と通常の時で条件分岐のif -->
                    <?php if (count($items) > 0){ ?>
                        <div class="flex-container">
                        <?php foreach($items as $item) { ?>
                            <div class="thing clearfix"> 
                            <div class="flex-item">       
                                <p><a href="login.php"><img  src=" <?php print IMAGE_PATH .  $item['img']; ?>" width="280" height="200"></a></p>
                                <p><?php print h($item['name']); ?></p>
                                <p><?php print h(number_format($item['price'])) ; ?>円 </p>
                            </div>    
                            </div>
                        <?php }  ?>
                        </div>
                    <?php } else{ ?>
                            <p>商品はありません</P>
                    <?php } ?>
                    <?php } else  if ($_SERVER['REQUEST_METHOD'] === 'GET') {?>
                        <div class="flex-container">
                            <?php foreach($items as $item) { ?>
                                <div class="thing clearfix"> 
                                <div class="flex-item">       
                                    <p><a href="login.php"><img  src=" <?php print IMAGE_PATH .  $item['img']; ?>" width="280" height="200"></a></p>
                                    <p><?php print h($item['name']); ?></p>
                                    <p><?php print h(number_format($item['price'])) ; ?>円 </p>
                                </div>    
                                </div>
                            <?php }  ?>
                            </div>
                    <?php } ?>
                </article>
            </main>
        </body>
    </div>
</html>