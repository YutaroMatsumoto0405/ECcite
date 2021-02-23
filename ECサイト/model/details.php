<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// detailsの上に表示する
function get_history($db,$history_id){
    $sql =
        "SELECT
            history.history_id,
            history.user_id,
            history.buy_date,
            sum(details.amount * details.price) as total_price
        FROM
            history
        INNER JOIN
            details
        ON
            history.history_id = details.history_id
        GROUP BY
            history.history_id
        HAVING
        history.history_id = ?
        ";

    return fetch_all_query($db,$sql,array($history_id));
}

// detailsの表示内容
function get_details($db,$history_id){
    $sql =
        "SELECT
            ANY_VALUE(details.price) as price,
            ANY_VALUE(details.amount) as amount,
            items.name,
            sum(details.amount * details.price) as subtotal_price
        FROM
            details
        INNER JOIN
            items
        ON
            details.item_id = items.item_id
        WHERE
            details.history_id = ?
        GROUP BY
            details.item_id
        ";
        
    return fetch_all_query($db,$sql,array($history_id));
}

?>