<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// 特定のユーザーの全お気に入りを取得
function check_all_favorite($db,$user_id){
    $sql = "
        SELECT
            user_id,
            item_id,
            img,
            createdate
        FROM
            favorite
        INNER JOIN
            items
        ON
            favorite.item_id = items.item_id
        WHERE
            $user_id = ?
    ";
    return fetch_all_query($db, $sql,array($user_id));
}

// 特定の商品がお気に入りに入っているかの確認
function check_favorite($db,$user_id,$item_id){
    $sql = "
        SELECT
            user_id,
            item_id,
            img,
            createdate
        FROM
            favorite
        WHERE
            $user_id = ?
        AND
            $item_id =?
    ";
    return fetch_all_query($db, $sql,array($user_id,$item_id));
}

// お気に入りに追加する処理
function insert_favorite($db,$user_id,$item_id){
    $sql = "
        INSERT INTO
            favorite(
                user_id,
                item_id,
                img,
                createdate
            )
        VALUES
            (?,?,?,now())
    ";
    return execute_query($db, $sql,array($user_id,$item_id));
}

// お気に入りから削除する処理
function delete_favorite($db,$item_id){
    $sql = "
        DELETE FROM 
            favorite
        WHERE item_id = ?
    ";
    return execute_query($db, $sql,array($item_id));
}






?>