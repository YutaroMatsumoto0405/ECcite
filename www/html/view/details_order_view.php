<!DOCTYPE html> 
<html lang="ja">
    <head>   
        <title>購入明細</title>
    </head>
    <body>
        <!-- ユーザーか管理者かでヘッダー変える -->
        <?php if($user['user_id'] === USER_ID_ADMIN){ ?>
            <?php include __DIR__ . '/templates/admin_header.php';?> 
        <?php } else{ ?>
            <?php include __DIR__ . '/templates/header_login.php';?> 
        <?php } ?>
            <?php include __DIR__ .'/templates/messages.php'; ?>
            <h1>購入明細</h1>
                <?php foreach($history as $his) { ?>
                    <p>注文番号 <?php print $his['history_id']; ?></p>
                    <p>購入日時 <?php print $his['buy_date']; ?></p>
                    <p>合計金額 <?php print h(number_format($his['total_price'])); ?>円</p>
                <?php } ?>
                <?php if($user['user_id'] !== USER_ID_ADMIN) { ?>
                    <table class ="table table-bordered">
                        <thead class ="thead-light">
                            <tr>
                                <th>商品画像</th>
                                <th>商品名</th>
                                <th>商品価格</th>
                                <th>購入数</th>
                                <th>小計</th>
                                <th>再購入</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($details as $det) { ?>
                            <tr>
                                <td>
                                    <?php if($det['wii'] === 0){ ?>
                                            <img src="<?php print(IMAGE_PATH . $det['img']); ?>"  width="300" height="200">
                                    <?php }else if($det['wii'] === 1) {?>
                                            <p>商品画像はありません</p>
                                    <?php } ?>
                                </td>
                                    <td><?php print $det['name'];  ?></td>
                                    <td><?php print h(number_format($det['price'])); ?></td>
                                    <td><?php print $det['amount'];  ?></td>
                                    <td><?php print h(number_format($det['subtotal_price']));?>円</td>
                                <!-- index_add_cartにidが送られる -->
                                <td>
                                    <?php if($det['switch'] === 0) { ?>
                                        <form method="post" action="cart_insert_item.php">
                                            <input type="hidden" name="token" value="<?php print $token ?>">
                                            <input type="hidden" name="item_id" id="item_id" value="<?php print $det['item_id']; ?>">
                                            <input type="submit" name="cart" value="もう1度購入する">
                                        </form>
                                    <?php } else if($det['switch'] === 1) { ?>
                                            <p>こちらの商品は購入できません。</p>
                                    <?php } ?>
                                </td> 
                            </tr>
                            <?php } ?>
                        <tbody>
                    </table>
                <?php } else { ?>
                    <table class ="table table-bordered">
                        <thead class ="thead-light">
                            <tr>
                                <th>商品画像</th>
                                <th>商品名</th>
                                <th>商品価格</th>
                                <th>購入数</th>
                                <th>小計</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($details as $det) { ?>
                            <tr>
                                <td>
                                    <?php if($det['wii'] === 0){ ?>
                                            <img src="<?php print(IMAGE_PATH . $det['img']); ?>"  width="300" height="200">
                                    <?php }else if($det['wii'] === 1) {?>
                                            <p>商品画像はありません</p>
                                    <?php } ?>
                                </td>
                                <td><?php print $det['name'];  ?></td>
                                <td><?php print h(number_format($det['price']));  ?></td>
                                <td><?php print $det['amount'];  ?></td>
                                <td><?php print h(number_format($det['subtotal_price'])); ?></td>
                            </tr>
                            <?php } ?>
                        <tbody>
                    </table>
                <?php } ?>
    </body>
</html>