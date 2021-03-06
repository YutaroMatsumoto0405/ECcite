<!DOCTYPE html>
<html lang="ja"> 
<head>
    <title>管理画面</title>
    <!-- 下は絶対パス -->
    <link rel='stylesheet' href='/asset/css/admin.css'/>
</head>
<body>
    <?php include __DIR__ . '/templates/admin_header.php'; ?>
    <h1>商品管理</h1>
    <hr width="100%" solid>
    <?php include __DIR__ .'/templates/messages.php'; ?>
    <h2>新規商品追加</h2>
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
            <label for="img">商品画像: </label>
            <input type="file" name="img" id="img">
        </div>
        <div class="form-group">
            <label for="status">ステータス: </label>
            <select class="form-control" name="status" id="status">
                <option value="<?php print ITEM_STATUS_OPEN ?>">公開</option>
                <option value="<?php print ITEM_STATUS_CLOSE ?>">非公開</option>
            </select>
        </div>
        <div class="form-group">
            <label for="category">カテゴリ: </label>
            <select class="form-control" name = category id="category">
                <option value="1">men</option>
                <option value="2">woman</option>
                <option value="3">kids</option>
                <option value="4">color</option>
                <option value="5">simple</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comment">商品説明: </label>
            <input class="form-control" type="text" name="comment" id="comment">
        </div>
            <input type="submit" value="商品を追加" class="btn btn-primary">
            <input type="hidden" name="token" value=<?php print $token ?>> 
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
                        <td><img src=" <?php print(IMAGE_PATH . $item['img']); ?>" class="item_image" width="300" height="200"></td>
                        <td><?php print h($item['name']); ?></td>
                        <!-- 商品価格の変更 -->
                        <td>
                            <form method="post" action="admin_change_price.php">
                                <input type="text" name="price" value="<?php print h(number_format($item['price'])); ?>">円
                                <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="submit" value="変更" class="btn btn-secondary">
                            </form>
                        </td>
                        <!-- 在庫数の変更 -->
                        <td>
                            <form method="post" action="admin_change_stock.php">
                                <input type="text" name="stock" value = "<?php print h($item['stock']) ; ?>" >個
                                <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>"> 
                                <input type="submit" value="変更" class="btn btn-secondary">
                            </form>
                        </td>
                        <!-- ステータスの変更 -->
                        <td>
                            <form method="post" action="admin_change_status.php"  class="operation">
                                <?php if(is_open($item) === true) { ?>
                                        <input type="submit" value="公開→非公開">
                                        <input type="hidden" name="changes_to" value="close" >
                                        <input type="hidden" name="token" value=<?php print $token ?>> 
                                <?php } else if(is_open($item) === false) { ?>
                                        <input type="submit" value="非公開→公開">
                                        <input type="hidden" name="changes_to" value="open" >
                                        <input type="hidden" name="token" value="<?php print $token ?>">
                                <?php } ?>
                                <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                            </form>
                        </td>
                        <!-- カテゴリ変更、selectedで最初に表示 -->
                        <td>
                            <form method="post" action="admin_change_category.php">
                                <select name = "category" onchange="submit(this.form)">
                                    <option value="1" <?php if($item['category'] === ITEM_CATEGORY_MEN){print "selected";} ?>>men</option>
                                    <option value="2" <?php if($item['category'] === ITEM_CATEGORY_WOMAN){print "selected";} ?>>woman</option>
                                    <option value="3" <?php if($item['category'] === ITEM_CATEGORY_KIDS){print "selected";} ?>>kids</option>
                                    <option value="4" <?php if($item['category'] === ITEM_CATEGORY_COLOR){print "selected";} ?>>color</option>
                                    <option value="5" <?php if($item['category'] === ITEM_CATEGORY_SIMPLE){print "selected";} ?>>simple</option>
                                </select>
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="hidden" name="item_id" id="item_id" value="<?php print $item['item_id']; ?>">
                            </form> 
                        </td>
                        <!-- 商品説明の変更 -->
                        <td>
                            <form method="post" action="admin_change_comment.php">
                                <textarea name="comment" rows="3" cols="30" wrap="hard"><?php print $item['comment']; ?></textarea>
                                <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>"> 
                                <input type="submit" value="変更" class="btn btn-secondary">
                            </form>
                        </td>
                            <!-- 商品の削除 -->
                        <td>
                            <form method="post" action="admin_delete_item.php">
                                <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                                <input type="hidden" name="token" value="<?php print $token ?>">
                                <input type="submit" name="delete" value="削除" class="btn-secondary">
                            </form>
                        </td>
                    </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>商品はありません。</p>
    <?php } ?> 
</body>
</html>