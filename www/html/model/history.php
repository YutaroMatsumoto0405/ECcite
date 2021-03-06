<?php
require_once  './conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// 管理者用の購入履歴
function get_all_history($db){
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
        ORDER BY
            history.buy_date DESC
        ";

    return fetch_all_query($db,$sql);
}

// ログイン中ユーザーの購入履歴
function get_user_history($db,$user_id){
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
            history.user_id = ?
        ORDER BY
            history.buy_date DESC
        ";

    return fetch_all_query($db,$sql,array($user_id));
}

?>