<!DOCTYPE html> 
<html lang="ja">
    <head>
        <?php include VIEW_PATH . 'templates/head.php'; ?>
        <title>購入明細</title>
    </head>
    <body> 
        <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
            <?php include VIEW_PATH . 'templates/messages.php'; ?>
            <h1>購入明細</h1>
                <?php foreach($order as $ord) { ?>
                    <p>注文番号 <?php print $ord['order_id']; ?></p>
                    <p>購入日時 <?php print $ord['buy_date']; ?></p>
                    <p>合計金額 <?php print $ord['total_price']; ?></p>
                <?php } ?>
            <table class ="table table-bordered">
                <thead class ="thead-light">
                    <tr>
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
                        <td><?php print $det['name'];  ?></td>
                        <td><?php print $det['price'];  ?></td>
                        <td><?php print $det['amount'];  ?></td>
                        <td><?php print $det['subtotal_price']; ?></td>
                        <td>
                        <!-- index_add_cartにidが送られる -->
                            <form　method="post" action="details.php">
                                <input type="hidden" name="item_id" id="item_id" value="<?php print $det['item_id']; ?>">
                                <input type="submit" name="cart" value="もう1度購入する">
                            </form>
                        </td> 
                    </tr>
                    <?php } ?>
                <tbody>
            </table>
    </body>
</html>