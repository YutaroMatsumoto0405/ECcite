<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>トップ</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>">
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'top_view.css'); ?>">
    </head> 
        <body>
            <?php include VIEW_PATH . 'templates/header.php'; ?>
            <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'header.css'); ?>">
            <div class="bgcolor">
            <main>
                <?php include VIEW_PATH . 'templates/search.php';?>
                <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <article>
                    <!-- 検索またはカテゴリが押された時と通常の時で条件分岐のif -->
                    <?php if (count($items) > 0){ ?>
                        <?php foreach($items as $item) { ?> 
                            <div class="thing clearfix">        
                            <div class="item">
                                <p><a href="login_view.php"><img  src=" <?php print $item['img']; ?>"></a></p>
                                <p><?php print h($item['name']); ?></p>
                                <p><?php print $item['price'] ; ?>円 </p>
                            </div>    
                            </div>
                        <?php } ?>
                    <?php  } else {?>
                            <!-- トップ画像の読み込み -->
                             <img class="masc" src="bara-buri-1NPbmHxl_VE-unsplash (1).jpg">
                    <?php } ?>
                </article>
            </main>
            </div>
        </body>
</html>