<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'history.php';

session_start();
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}
// データベース接続
$db = get_db_connect();
$user = get_login_user($db);

// 管理者かログイン中ユーザーかをidで分岐
if($user['user_id'] === USER_ID_ADMIN){
    $history = get_all_history($db);
} else {
    $history = get_user_history($db,$user['user_id']);
}

include_once VIEW_PATH . 'history_view.php';