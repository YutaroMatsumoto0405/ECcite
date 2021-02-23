<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>購入履歴</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'body.css'); ?>">
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'history_view.css'); ?>">
    </head>
    <body>
        <div class="top">
            <?php include VIEW_PATH . 'headers/header_login.php';?> 
        </div>   
        <div class="border">
            <h1>購入履歴</h1>
        </div>
        <div class="bgcolor"> 
            <main> 
                <p class="day">購入日時</p>
                <div class="all">

                <?php if(count($history) > 0) { ?>
                
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>注文番号</th>
                            <th>購入日時</th>
                            <th>合計金額</th>
                            <th>購入明細</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($history as $his) { ?>
                            <tr>
                                <td><?php print $his['history_id']; ?></td>
                                <td><?php print $his['buy_date']; ?></td>
                                <td><?php print $his['total_price']; ?></td>
                                <td>
                                    <form method="post" action="details_order_view.php">
                                        <input type="submit" value="明細を表示する" class="btn btn-secondary">
                                        <input type="hidden" name="history_id" value="<?php print($his['history_id']); ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>購入履歴はありません</p>
            <?php } ?>
                </div>
            </main>
        </div>
        
    </body>
</html>