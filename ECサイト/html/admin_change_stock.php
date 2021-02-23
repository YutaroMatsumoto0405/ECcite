<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();
// ログインしていなかったら、login画面へリダイレクト
if(is_logined() === false){
    redirect_to(LOGIN_URL); 
}
// DBに接続する
$db = get_db_connect();
$user = get_login_user($db);
// ログインしていなかったら、login画面へリダイレクト
if(is_admin($user) === false){
    redirect_to(LOGIN_URL);
}
// post送信された値を変数に格納
$item_id = get_post('item_id');
$stock = get_post('stock');
$token = get_post('token'); 

// 在庫数変更の処理、item.phpで定義
if(is_valid_csrf_token($token)){ 
    if(update_item_stock($db, $item_id, $stock)){
        set_message('在庫数を変更しました。');
    } else {
        set_error('在庫数の変更に失敗しました。');
    }
} else { 
    set_error('不正な操作が行われました'); 
} 

redirect_to(ADMIN_URL);