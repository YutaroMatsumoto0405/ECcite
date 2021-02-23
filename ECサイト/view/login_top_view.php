<!DOCTYPE html>
<html lang="ja">
    <head> 
        <meta charset="utf-8">
        <title>ログイントップ</title>
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
            nav {
                width: 210px;
                padding-right: 20px;
            }
            nav ul li {
                border-bottom: dotted 1px #DDDDDD;
                margin: 15px 0;
                font-size: 18px;
                list-style: none;
            }
            nav ul li a {
                text-decoration: none;
                color: #333333;
            }
            
            .frame1 {
                padding-bottom: 60px;
            }
            h2 {
                text-align: center;
                padding-bottom: 15px;
            }
            .search {
                height: 23px;
                border-radius: 10px;
            }
            article {
                margin: 0 auto;
            }
            .item img {
                width: 150px;
            }
            .clearfix::after {
                display: block;
                content: "";
                clear: both;
            }
            .item{
                width: 180px;
                float: left;
                text-align: center; 
            }
            
        </style>
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