<!DOCTYPE html>
<html lang="ja"> 
<head>
    <?php include VIEW_PATH . 'templates/head.php'; ?>
    <title>管理画面</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
    <h1>商品管理</h1>
    <hr width="100%" solid>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <h2>新規商品追加</h2>
    <!-- css -->
    <form method="post" action="admin_insert_item.php" enctype="multipart/form-data"　class="add_item_form col-md-6">
        <div class="form-group">
            <label for="name">名前: </label>
            <input class="form-control" type="text" name="name" id="name">
        </div>
        <div class="form-group">
            <label for="price">価格: </label>
            <input class="form-control" type="number" name="price" id="price">
        </div>
        <div class="form-group">
            <label for="stock">在庫数: </label>
            <input class="form-control" type="number" name="stock" id="stock">
        </div>
        <div class="form-group">
            <label for="image">商品画像: </label>
            <input type="file" name="image" id="image">
        </div>
        <div class="form-group">
            <label for="status">ステータス: </label>
            <select class="form-control" name="status" id="status">
                <option value="open">公開</option>
                <option value="close">非公開</option>
            </select>
        </div>
        <div class="form-group">
            <label for="category">カテゴリ: </label>
            <select class="form-control" name = category id="category">
                <option value="0">men</option>
                <option value="1">woman</option>
                <option value="2">kids</option>
                <option value="3">color</option>
                <option value="4">simple</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comment">商品説明: </label>

            <input type="submit" value="商品を追加" class="btn btn-primary">
            <input type="hidden" name="token" value=<?php print $token ?>> 
        </div>
    </form>
        

    <?php if(count($items) > 0){ ?>
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>ステータス</th>
                    <th>カテゴリ</th>
                    <th>詳細</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <!-- css -->
                    <tr class="<?php print(is_open($item) ? '' : 'close_item'); ?>">
                        <td><img src=" <?php print(IMAGE_PATH . $item['img']); ?>" class="item_image"></td>
                        <td><?php print h($item['name']); ?></td>
                        <td><?php print h(number_format($item['price'])); ?>円</td>
                        <td>
                        <!-- 在庫数の変更 -->
                            <form method="post"　action="admin_change_stock.php">
                                <input type="text" name="stock" value = "<?php print h($item['stock']) ; ?>" >個
                                <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                                <input type="hidden" name="token" value=<?php print $token ?>> 
                                <input type="submit" value="変更" class="btn btn-secondary">
                            </form>
                        <!-- ステータスの変更 css-->
                        <form method="post" action="admin_change_status.php"  class="operation">
                            <?php if(is_open($item) === true) { ?>
                                    <input type="submit" value="公開→非公開">
                                    <input type="hidden" name="change_to" value="close" >
                                    <input type="hidden" name="token" value=<?php print $token ?>> 
                            <?php } else if(is_open($item) === false) { ?>
                                    <input type="submit" value="非公開→公開">
                                    <input type="hidden" name="change_to" value="open" >
                                    <input type="hidden" name="token" value=<?php print $token ?>> 
                            <?php } ?>
                            <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                        </form>
    <!-- ここを聞く　カテゴリの変更 -->
                        <form method="post" action="admin_change_catrgory.php">
                            <?php if($item['category'] === ITEM_CATEGORY_MEN) { ?>
                                    <select name = category onchange="submit(this.form)">
                                        <option value="0">men</option>
                                        <option value="1">woman</option>
                                        <option value="2">kids</option>
                                        <option value="3">color</option>
                                        <option value="4">simple</option>
                                    </select>
                            <?php } else if($item['category'] === ITEM_CATEGORY_WOMAN) { ?>
                                    <select name = category onchange="submit(this.form)">
                                        <option value="1">woman</option>
                                        <option value="0">men</option>
                                        <option value="2">kids</option>
                                        <option value="3">color</option>
                                        <option value="4">simple</option>
                                    </select>
                            <?php }else if($item['category'] === ITEM_CATEGORY_KIDS) { ?>
                                    <select name = category onchange="submit(this.form)">
                                        <option value="2">kids</option>
                                        <option value="0">men</option>
                                        <option value="1">woman</option>
                                        <option value="3">color</option>
                                        <option value="4">simple</option>
                                    </select>
                            <?php }else if($item['category'] === ITEM_CATEGORY_COLOR) { ?>
                                    <select name = category onchange="submit(this.form)">
                                        <option value="3">color</option>
                                        <option value="0">men</option>
                                        <option value="1">woman</option>
                                        <option value="2">kids</option>
                                        <option value="4">simple</option>
                                    </select>
                            <?php }else if($item['category'] === ITEM_CATEGORY_SIMPLE) { ?>
                                    <select name = category onchange="submit(this.form)">
                                        <option value="4">simple</option>
                                        <option value="0">men</option>
                                        <option value="1">woman</option>
                                        <option value="2">kids</option>
                                        <option value="3">color</option>
                                    </select>
                            <?php } ?>
                            <input type="hidden" name="token" value=<?php print $token ?>> 
                            <input type="hidden" name="item_id" id="item_id" value="<?php print $item['item_id']; ?>">
                        </form> 
                        <!-- 商品説明の変更 -->
                        <form method="post" action="admin_change_comment.php">
                            <textarea name="comment" rows="3" cols="30" wrap="hard"><?php print $item['comment']; ?></textarea>
                            <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                            <input type="hidden" name="token" value=<?php print $token ?>> 
                            <input type="submit" value="変更" class="btn btn-secondary">
                        </form>
                        <!-- 商品の削除 -->
                        <form method="post" action="admin_delete_item.php">
                            <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                            <input type="hidden" name="token" value=<?php print $token ?>> 
                            <input type="submit" name="delete" value="削除" class="btn-secondary">
                        </form>
                    </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>商品はありません。</p>
    <?php } ?> 
</body>
</html>