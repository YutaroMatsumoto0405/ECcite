<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8">
        <title>ログイントップ</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>">
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'login_top_view.css'); ?>">
    </head>
    <body>
    <?php include VIEW_PATH . 'templates/header_login.php';?>
        <div class="bgcolor">
        <main>
        <?php include VIEW_PATH . 'templates/search.php';?>
            <article>
            <!-- 検索かカテゴリが押されたらこれ、押されない時はしたのおすすめが表示される -->
            <form method="get" >
                <select name="sort">
                    <option value="new" <?php if($sort === 'new') { ?> selected <?php } ?>>新着順</option>
                    <option value="low" <?php if($sort === 'low') { ?> selected <?php } ?>>価格の安い順</option>
                    <option value="high" <?php if($sort === 'high') { ?> selected <?php } ?>>価格の高い順</option>
                </select>
                <input type="submit" name="sort_button" value="並び替え">
            </form>
            <div class="card-deck">
                <div class="row">
                <?php foreach($items as $item){ ?>
                        <div class="col-6 item">
                        <div class="card h-100 text-center">
                            <div class="card-header">
                                <?php print h(($item['name'])); ?> 
                            </div>
                            <figure class="card-body">
                                <form method="post">
                                    <a href="details_item_view.php"><img class="card-img" src="<?php print(IMAGE_PATH . $item['img']); ?>"></a>
                                    <input type="hidden" name="item_id" id="item_id" value="<?php print $item['item_id']; ?>">
                                </form>
                            <figcaption>
                                <?php print h(number_format($item['price'])); ?>円 
                <?php } ?>    
                        </div>
                        </div>
                </div>
            </div>         
            </article>
        </main>
        </div>
    </body>
</html>