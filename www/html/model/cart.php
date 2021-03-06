<?php
require_once  './model/functions.php';
require_once  './model/db.php';

// ユーザー毎のカート情報の取得、cart_view.phpで表示、viewでは$dataとして参照
function get_user_carts($db,$user_id){
    $sql = "
        SELECT
            items.item_id,
            items.name,
            items.price,
            items.img,
            items.stock,
            items.status,
            carts.user_id,
            carts.amount
        FROM
            items
        INNER JOIN
            carts
        ON
            items.item_id = carts.item_id
        WHERE
            carts.user_id = ?
        ";
    return fetch_all_query($db,$sql,array($user_id));
}

// カートに商品を追加する際、item_idが一致したら個数のupdate、1個もなかったらinsertするために使う
function get_user_cart($db, $user_id, $item_id){
    $sql = "
        SELECT
            items.item_id,
            items.name,
            items.price,
            items.img,
            items.stock,
            items.status,
            carts.cart_id,
            carts.user_id,
            carts.amount
        FROM
            items
        INNER JOIN
            carts
        ON
            items.item_id = carts.item_id
        WHERE
            carts.user_id = ?
        AND
            items.item_id = ?
        ";
        
    return fetch_query($db, $sql,array($user_id,(int)$item_id));
}

//  件数だけをセレクト（数字）
function get_user_cart_count($db, $user_id, $item_id){
    $sql = "
        SELECT
            count(*) as count
        FROM
            items
        INNER JOIN
            carts
        ON
            items.item_id = carts.item_id
        WHERE
            carts.user_id = ?
        AND
            items.item_id = ?
        ";
    return fetch_query($db, $sql,array($user_id,$item_id));
}

// カートに商品がなかった時、カートに新しい商品を追加する文
function insert_cart($db, $user_id, $item_id, $amount = 1){
    $sql = "
        INSERT INTO
            carts(
                user_id,
                item_id,
                amount,
                createdate,
                updatedate
            )
            VALUES(?,?,?,now(),now())
        ";
    return execute_query($db, $sql,array($user_id,$item_id,$amount));
}

// カートに入ってる商品の個数を変更するときの文、「カートに追加」を押して1個増やす処理は関数に＋１と書き足すだけでいい（cart.php）
function update_cart_amount($db,$amount,$item_id){
    $sql = "
        UPDATE
            carts
        SET
            amount = ?,
            updatedate = now()
        WHERE
            item_id = ? 
        LIMIT
            1
        ";
        
    return execute_query($db, $sql,array($amount,$item_id));
}

// カートに追加、入ってなかったら追加で入ってたら数を増やす、add_cartはindex.add.cartにある（カートに追加が成功したか失敗したかを表示したいところに書く）
function add_cart($db, $user_id, $item_id) {
    $cart_count = get_user_cart_count($db, $user_id, $item_id);
    if((int)$cart_count['count'] === 0){
      return insert_cart($db, $user_id, $item_id);
    } else{
        $data = get_user_cart($db, $user_id, $item_id);
        return update_cart_amount($db,$data['amount'] + 1,$data['item_id']);
    }
    
  }

// カート内の商品を削除するボタンが押されたときの文
function delete_cart($db, $item_id){
    $sql = "
        DELETE 
        FROM
            carts
        WHERE
            item_id = ? 
        ";
    return execute_query($db, $sql,array($item_id));
}
// 商品の購入が完了し、カート内の商品を全て削除するときの文
function delete_user_carts($db, $user_id){
    $sql = "
        DELETE 
        FROM
            carts
        WHERE
            user_id = ?
        ";
    execute_query($db, $sql,array($user_id));
}
// historyに追加する文、正規化できるところはあとで行う
function insert_history($db,$user_id) {
    $sql = "
        INSERT INTO
            history(
                user_id,
                buy_date
            )
        VALUES
            (?,now())
        ";
    return execute_query($db,$sql,array($user_id));
}
// detailsを追加するならここに書く
function insert_details($db,$history_id,$item_id,$amount,$price,$img,$name){
    $sql = "
        INSERT INTO
            details(
                history_id,
                item_id,
                amount,
                price,
                img,
                name
            )
        VALUES(?,?,?,?,?,?)
            ";
    return execute_query($db,$sql,array($history_id,$item_id,$amount,$price,$img,$name));
  }

// 購入された時の処理、$cartsに買われたものが入ってる、$cartはhtml.cart.phpにある
function purchase_carts($db, $carts){
    // トランザクション開始
    $db -> beginTransaction();
    try{
        // $carts　finish.phpにある
        if(validate_cart_purchase($carts) === false){
            return false;
        }
        insert_history($db,$carts[0]['user_id']);
            $history_id = $db->lastInsertID();
        // 連番
        foreach($carts as $cart){
          insert_details($db,$history_id,$cart['item_id'],$cart['amount'],$cart['price'],$cart['img'],$cart['name']);
        }
        // update_item_stockはitem.phpで定義、在庫数の変更
        foreach($carts as $cart){
            if(update_item_stock(
                $db, 
                $cart['item_id'], 
                $cart['stock'] - $cart['amount']
            ) === false){
            set_error($cart['name'] . 'の購入に失敗しました。');
            }
        }
        // 購入されたのでカート内を削除
        delete_user_carts($db, $carts[0]['user_id']);
    
        $db->commit();
    } catch (PDOException $e) {
        $db->rollback();
        throw $e;
    }
}

// カートチェック、商品の有無、ステータス、在庫が足りるか
function validate_cart_purchase($carts){
    if(count($carts) === 0){
        set_error('カートに商品が入っていません。');
        return false;
    }
    foreach($carts as $cart){
        
        // ステータスの確認
        if(is_open($cart) === false){
            set_error($cart['name'] . 'は現在購入できません。');
        }
        // 在庫数の確認
        if($cart['stock'] - $cart['amount'] < 0){
            set_error($cart['name'] . 'は在庫が足りません。購入可能数は' . $cart['stock'] . '個です。');
        }
    }
    if(has_error() === true){
        return false;
    }
    return true;
}

// カート内商品の合計金額
function sum_carts($carts){
    $total_price = 0;
    foreach($carts as $cart){
        $total_price += $cart['price'] * $cart['amount'];
    }
    return $total_price;
}

?>