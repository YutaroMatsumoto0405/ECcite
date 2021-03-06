<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';
require_once  './model/cart.php';
require_once  './model/history.php';
require_once  './model/details_order.php';
 
// ログインしてなかったらログイン画面に
session_start();
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}

// データベースに接続
$db = get_db_connect();
$user = get_login_user($db);
$token = get_post('token');
$item_id = get_post('item_id');


// historyから送られてきたhistory_idの取得
$history_id = get_post('history_id');
// 上に表示する項目の取得
$history = get_history($db,$history_id);
// 購入明細のselect文の関数呼び出し
$details = get_all_details($db,$history_id);

// ステータス的に購入可能な商品
$items = get_item($db, $item_id);

// 上記の変数をviewで使用
include_once VIEW_PATH . 'details_order_view.php';