<!DOCTYPE html>
<html lang="ja">
    <head>  
        <meta charset="utf-8">
        <title>購入履歴</title>
        <link rel='stylesheet' href='/asset/css/history_view.css'/>
    </head>
    <body>
        <!-- 管理者かユーザーかでヘッダーを変える -->
        <div class="top">
            <?php if($user['user_id'] === USER_ID_ADMIN){ ?>
                <?php include __DIR__ . '/templates/admin_header.php';?> 
            <?php } else{ ?>
                <?php include __DIR__ . '/templates/header_login.php';?> 
            <?php } ?>
        </div>   
        <div class="border">
            <h1>購入履歴</h1>
        </div>
        <div class="bgcolor"> 
            <main> 
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
                            <tr name="table">
                                <td><?php print $his['history_id']; ?></td>
                                <td><?php print $his['buy_date']; ?></td>
                                <td><?php print h(number_format($his['total_price'])); ?>円</td>
                                <td>
                                    <form method="post" action="details_order.php">
                                        <input type="hidden" name="history_id" value="<?php print($his['history_id']); ?>">
                                        <input type="submit" value="明細を表示する" class="btn btn-secondary">
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