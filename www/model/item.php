<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// あとで探す
function get_item($db, $item_id){
    $sql = "
        SELECT
            item_id, 
            name,
            stock,
            price,
            img,
            status,
            category,
            comment
        FROM
            items
        WHERE
            item_id = ? 
    ";
  
    return fetch_query($db, $sql,array($item_id));
}

// 公開中の商品情報を取得、ユーザーに表示
function get_items($db, $is_open = false){
    $sql = '
        SELECT
            item_id, 
            name,
            stock,
            price,
            img,
            status,
            category,
            comment
        FROM
            items
    ';
    // ステータス的に買えるやつに絞る
    if($is_open === true){
      $sql .= '
        WHERE status = 1
      ';
    }
    return fetch_all_query($db, $sql);
}

// 商品の新規登録
function insert_item($db, $name, $price, $stock, $filename, $status,$category,$comment){
    $status_value = PERMITTED_ITEM_STATUSES[$status];
    $sql = "
        INSERT INTO
            items(
                name,
                price,
                stock,
                img,
                status,
                category,
                comment,
                createdate
            )
        VALUES(?,?,?,?,?,?,?,now()); 
    ";
  
    return execute_query($db, $sql,array($name,$price,$stock,$image,$status,$category,$comment));
}

  // ステータスの変更
function update_item_status($db,$status,$item_id){
    $sql = "
        UPDATE
            items
        SET
            status = ? 
        WHERE
            item_id = ? 
        LIMIT 1
    ";
    
    return execute_query($db, $sql,array($status,$item_id));
}

// 在庫数の変更
function update_item_stock($db,$stock,$item_id){
    $sql = "
        UPDATE
            items
        SET
            stock = ? 
        WHERE
            item_id = ? 
        LIMIT 1
    ";
    
    return execute_query($db, $sql,array($stock,$item_id));
  }
  
// カテゴリの変更sql,時間のアップデートをどうするか
function update_item_category($db,$category,$updatedate,$item_id){
    $sql =  "
        UPDATE
            items
        SET
            category = ?,
            updatedate = ?
        WHERE
            id = ?
    ";
    return execute_query($db, $sql,array($category,$updatedate,$item_id));
}

// 詳細変更のsql
function update_item_comment($db,$comment,$updatedate,$item_id){
    $sql = "
        UPDATE
            items
        SET
            comment = ?,
            updatedate = ?
        WHERE
            id = ?
        ";
    return execute_query($db, $sql,array($comment,$updatedate,$item_id));
}

// itemidに一致する商品の削除
function delete_item($db, $item_id){
    $sql = "
        DELETE FROM
            items
        WHERE
            item_id = ? 
        LIMIT 1 
    ";
    return execute_query($db, $sql,array($item_id));
}
  
// 「検索」が押されたときのsql
function push_search($db,$name){
    $sql = "
        SELECT
            item.id,
            name,
            price,
            img,
            status,
            stock,
            category,
            comment
        FROM
            items
        WHERE
            name LIKE ?,
        AND
            items.status = 1
    ";
    return fetch_all_query($db, array($name));

}
// カテゴリが押されたときのaql
function push_category($db,$category){
    $sql = "
        SELECT
            item_id,
            name,
            price,
            img,
            status,
            stock,
            category,
            comment
        FROM
            items
        WHERE
            category = ?
        AND
            items.status = 1
    ";
    return fetch_all_query($db, array($category));
}

// 商品の並び替え機能
function item_sort($db,$sort,$is_open = false) {
    $sql = "
        SELECT
            item_id,
            name,
            stock,
            price,
            image,
            status
        FROM
            items
            ";
    // ステータス的に買えるやつに絞る、
    if($is_open === true){
        $sql .= '
            WHERE status = 1
        ';
    }
    // 並び替え
    if($sort === 'new' || empty($sort)) {
        $sql .= "
            ORDER BY
                created ASC
                ";
    } else if($sort === 'low'){
        $sql .= "
            ORDER BY
                price ASC
                ";            
    } else if($sort === 'high'){
        $sql .= "
            ORDER BY
                price DESC
                ";                        
    }
    return fetch_all_query($db,$sql);
}

// ステータス的に買える商品の情報を取得
function get_sort_items($db,$sort){
    return item_sort($db,$sort,true);
}


// 全部の商品情報を取得
function get_all_items($db){
    return get_items($db);
}
// ステータス的に買える商品の情報を取得
function get_open_items($db){
    return get_items($db, true);
}

// 調べる
function destroy_item($db, $item_id){
    $item = get_item($db, $item_id);
    if($item === false){
         false;
    }
    $db->beginTransaction();
    if(delete_item($db, $item['item_id'])
        && delete_image($item['img'])){
        $db->commit();
        return true;
    }
    $db->rollback();
    return false;
}
 
function is_open($item){
    return $item['status'] === 1;
}

// 商品の登録、画像登録の処理をよく見直す、トランザクションまでする必要ある？
function regist_item($db,$name,$price,$stock,$status,$image,$category,$comment){
    $filename = get_upload_filename($image);
    if(validate_item($name, $price, $stock, $filename, $status,$category,$comment) === false){
        return false;
    }
    return regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename,$category,$comment);
}

// トランザクション
function regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename,$category,$comment){
    $db->beginTransaction();
    if(insert_item($db, $name, $price, $stock, $filename, $status,$category,$comment) 
        && save_image($image, $filename)){
        $db->commit();
        return true;
    }
    $db->rollback();
    return false;
}

// 商品情報のバリデーション(入力内容が問題ないか、文字数や半角など)
function validate_item($name, $price, $stock, $filename, $status,$category,$comment){
    $is_valid_item_name = is_valid_item_name($name);
    $is_valid_item_price = is_valid_item_price($price);
    $is_valid_item_stock = is_valid_item_stock($stock);
    $is_valid_item_filename = is_valid_item_filename($filename);
    $is_valid_item_status = is_valid_item_status($status);
    $is_valid_item_category = is_valid_item_category($category);
    $is_valid_item_comment = is_valid_item_comment($comment);
  
    return $is_valid_item_name
        && $is_valid_item_price
        && $is_valid_item_stock
        && $is_valid_item_filename
        && $is_valid_item_status
        && $is_valid_item_category
        && $is_valid_item_comment;
}

// 初期値にtrueを設定
// nameのバリデーション、100文字以下1文字以上
function is_valid_item_name($name){
    $is_valid = true;
    if(is_valid_length($name, ITEM_NAME_LENGTH_MIN, ITEM_NAME_LENGTH_MAX) === false){
        set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
        $is_valid = false;
    }
    return $is_valid;
}
// priceのバリデーション
function is_valid_item_price($price){
    $is_valid = true;
    if(is_positive_integer($price) === false){
        set_error('価格は0以上の整数で入力してください。');
        $is_valid = false;
    }
    return $is_valid;
  }
// stockのバリデーション
function is_valid_item_stock($stock){
    $is_valid = true;
    if(is_positive_integer($stock) === false){
        set_error('在庫数は0以上の整数で入力してください。');
        $is_valid = false;
    }
    return $is_valid;
}
// filenameのバリデーション
function is_valid_item_filename($filename){
    $is_valid = true;
    if($filename === ''){
        $is_valid = false;
    }
    return $is_valid;
}
// statusのバリデーション
function is_valid_item_status($status){
    $is_valid = true;
    if(isset(PERMITTED_ITEM_STATUSES[$status]) === false){
        $is_valid = false;
    }
    return $is_valid;
}
// カテゴリ
function is_valid_item_category($category){
    $is_valid = true;
    if(isset(PERMITTED_ITEM_CATEGORY[$category]) === false){
        $is_valid = false;
    }
    return $is_valid;
}

// コメントのバリデーション
function is_valid_item_comment($comment){
    $is_valid = true;
    if(is_valid_length($comment, ITEM_COMMENT_LENGTH_MIN, ITEM_COMMENT_LENGTH_MAX) === false){
        set_error('商品名は'. ITEM_COMMENT_LENGTH_MIN . '文字以上、' . ITEM_COMMENT_LENGTH_MAX . '文字以内にしてください。');
        $is_valid = false;
    }
    return $is_valid;
}

?>