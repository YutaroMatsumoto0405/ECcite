<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'history.php';
require_once MODEL_PATH . 'details.php';
 
// ログインしてなかったらログイン画面に
session_start();
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}

// データベースに接続
$db = get_db_connect();
$user = get_login_user($db);


// historyから送られてきたorder_idの取得
$history_id = get_post('history_id');
// 上に表示する項目の取得
$history = get_history($db,$history_id);
// 購入明細のselect文の関数呼び出し
$details = get_details($db,$history_id);

// 上記の変数をviewで使用
include_once VIEW_PATH . 'details_order_view.php';