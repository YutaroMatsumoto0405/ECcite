<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// ユーザー毎のカート情報の取得、cart_view.phpで表示、viewでは$dataとして参照
function get_user_carts($db,$user_id){
    $sql = "
        SELECT
            items.item_id,
            items.name,
            items.price,
            items.img,
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
            cart.cart_id,
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
    return execute_query($db, $sql,array($item_id,$user_id,$amount));
}

// カートに入ってる商品の個数を変更するときの文、「カートに追加」を押して1個増やす処理は関数に＋１と書き足すだけでいい（cart.phpの63行目）
// item_idで判断するのかcart_idで判断するのかをあとで決める、limitが必要かどうかもあとで判断
// updatedateの追加をする
function update_cart_amount($db, $cart_id, $amount){
    $sql = "
        UPDATE
            carts
        SET
            amount = ?
            updatedate = ? 
        WHERE
            cart_id = ? 
        LIMIT
            1
        ";
    return execute_query($db, $sql,array($cart_id,$amount));
}

// カートに追加、入ってなかったら追加で入ってたら数を増やす、add_cartはindex.add.cartにある（カートに追加が成功したか失敗したかを表示したいところに書く）
function add_cart($db, $user_id, $item_id) {
    $cart = get_user_cart($db, $user_id, $item_id);
    if($cart === false){
      return insert_cart($db, $user_id, $item_id);
    }
    return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
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
function insert_history($db,$user_id,$item_id,$image,$name,$price) {
    $sql = "
        INSERT INTO
            history(
                user_id,
                item_id,
                img,
                name,
                price,
                createdate
            )
        VALUES
            (?,?,?,?,?,now())
        ";
    return execute_query($db,$sql,array($user_id,$item_id,$image,$name,$price));
}
// ecサイトの方のhistory文
// function insert_history($db,$user_id) {
//     $sql = "
//         INSERT INTO
//             history(
//                 user_id,
//                 buy_date
//             )
//             VALUES(?,now())
//             ";
//     return execute_query($db,$sql,array($user_id));
//   }


// detailsを追加するならここに書く
function insert_details($db,$history_id,$item_id,$amount,$price){
    $sql = "
        INSERT INTO
            details(
                history_id,
                item_id,
                amount,
                price
            )
        VALUES(?,?,?,?)
            ";
    return execute_query($db,$sql,array($history_id,$item_id,$amount,$price));
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
        insert_history($db,$carts[0]['user_id'],$carts[0]['item_id'],$carts[0]['img'],$carts[0]['name'],$carts[0]['price']);
            $order_id = $db->lastInsertID();
        // detailsを作るなら、上のlastInsertID含めて必要
        foreach($carts as $cart){
          insert_details($db,$order_id,$cart['item_id'],$cart['amount'],$cart['price']);
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

// カート内商品の合計金額
function sum_carts($carts){
    $total_price = 0;
    foreach($carts as $cart){
        $total_price += $cart['price'] * $cart['amount'];
    }
    return $total_price;
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

?>