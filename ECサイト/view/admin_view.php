<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
    <style type="text/css">
        img{
            width: 150px;
        }
        .close{
            background-color: gray;
        }
    </style>
</head>
<body>

    <h1>商品管理</h1>
    <hr width="100%" solid>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <h2>新規商品追加</h2>
        <form method="post" action="admin_insert_item.php" enctype="multipart/form-data">
            <p> 名前 : <input type="text" name="name" id="name" ></p>
            <p> 値段 : <input type="text" name="price" id="price"></p>
            <p> 個数 : <input type="text" name="stock" id="stock"></p>
            <p><input type="file" name="img" id="img"></p>
            <select name = "status" id="status">
                <option value="open">公開</option>
                <option value="close">非公開</option>
            </select><br>
            <select name = category id="category">
                <option value="0">men</option>
                <option value="1">woman</option>
                <option value="2">kids</option>
                <option value="3">color</option>
                <option value="4">simple</option>
            </select><br>
            <p> 詳細 : <textarea name="comment" id="comment" rows="3" cols="30" wrap="hard"></textarea> </p>
            <p><input type="submit" value="商品を追加"></p>
            <input type="hidden" name="token" value=<?php print $token ?>> 
        </form>
        
    <hr width="100%" solid>
    <h2>商品情報変更</h2>
    <p>商品一覧</p>
    <?php if(count($items) > 0){ ?>
    <table border="1" width="80%">
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
    <?php foreach ($items as $item) { ?>
        <?php if($item['status'] === "open") { ?>
        <tr align = "center">
        <?php } else { ?>
        <tr align = "center" class="close">
        <?php }  ?>
    
            <td><img src=" <?php print(IMAGE_PATH . $item['image']); ?>"></td>
            <td><?php print h($item['name']); ?></td>
            <td><?php print h(number_format($item['price'])); ?>円</td>
            <td>
            <!-- 在庫数の変更 -->
                <form method="post"　action="admin_change_stock.php">
                    <input type="text" name="stock" value = "<?php print h($item['stock']) ; ?>" >個
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                    <input type="hidden" name="token" value=<?php print $token ?>> 
                    <input type="submit" value="変更">
                </form>
            <!-- ステータスの変更 -->
            <form method="post" action="admin_change_status.php">
                <?php if(is_open($item) === true) { ?>
                    <td>
                        <input type="submit" value="公開→非公開">
                        <input type="hidden" name="change_to" value="close" >
                        <input type="hidden" name="token" value=<?php print $token ?>> 
                    </td>
                <?php } else if(is_open($item) === false) { ?>
                    <td>
                        <input type="submit" value="非公開→公開">
                        <input type="hidden" name="change_to" value="open" >
                        <input type="hidden" name="token" value=<?php print $token ?>> 
                    </td>
                <?php } ?>
                <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
            </form>
            <!-- カテゴリの変更 -->
            <form method="post" action="admin_change_catrgory.php">
                <?php if($item['category'] === ITEM_CATEGORY_MEN) { ?>
                    <td>
                        <select name = category onchange="submit(this.form)">
                            <option value="0">men</option>
                            <option value="1">woman</option>
                            <option value="2">kids</option>
                            <option value="3">color</option>
                            <option value="4">simple</option>
                        </select>
                    </td>
                <?php } else if($item['category'] === ITEM_CATEGORY_WOMAN) { ?>
                    <td>
                        <select name = category onchange="submit(this.form)">
                            <option value="1">woman</option>
                            <option value="0">men</option>
                            <option value="2">kids</option>
                            <option value="3">color</option>
                            <option value="4">simple</option>
                        </select>
                    </td>
                <?php }else if($item['category'] === ITEM_CATEGORY_KIDS) { ?>
                    <td>
                        <select name = category onchange="submit(this.form)">
                            <option value="2">kids</option>
                            <option value="0">men</option>
                            <option value="1">woman</option>
                            <option value="3">color</option>
                            <option value="4">simple</option>
                        </select>
                    </td>
                <?php }else if($item['category'] === ITEM_CATEGORY_COLOR) { ?>
                    <td>
                        <select name = category onchange="submit(this.form)">
                            <option value="3">color</option>
                            <option value="0">men</option>
                            <option value="1">woman</option>
                            <option value="2">kids</option>
                            <option value="4">simple</option>
                        </select>
                    </td>
                <?php }else if($item['category'] === ITEM_CATEGORY_SIMPLE) { ?>
                    <td>
                        <select name = category onchange="submit(this.form)">
                            <option value="4">simple</option>
                            <option value="0">men</option>
                            <option value="1">woman</option>
                            <option value="2">kids</option>
                            <option value="3">color</option>
                        </select>
                    </td> 
                <?php } ?>
                <input type="hidden" name="token" value=<?php print $token ?>> 
                <input type="hidden" name="item_id" id="item_id" value="<?php print $item['item_id']; ?>">
            </form> 
            <!-- コメントの変更 -->
            <form method="poset" action="admin_change_comment.php">
                <td>
                    <textarea name="comment" rows="3" cols="30" wrap="hard"><?php print $item['comment']; ?></textarea>
                    <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                    <input type="hidden" name="token" value=<?php print $token ?>> 
                    <input type="submit" value="変更">
                </td>
            </form>
            <!-- 商品の削除 -->
            <form method="post" action="admin_delete_item.php">
                <td>
                    <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
                    <input type="hidden" name="token" value=<?php print $token ?>> 
                    <input type="submit" name="delete" value="削除">
                </td>
            </form>
        </tr>
<?php } ?>
    </table>
    <?php } else { ?>
        <p>商品はありません。</p>
    <?php } ?> 
</body>
</html>