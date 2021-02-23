<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();
// ログインしていなかったら、login画面へリダイレクト
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}
// DBに接続する
$db = get_db_connect();
// ログイン中ユーザーの情報取得
$user = get_login_user($db);
// post送信された値を変数に格納
$cart_id = get_post('cart_id');
$item_id = get_post('item_id');
$token = get_post('token'); 

// cart_idからitem_idに変更した
// カートから削除のボタンが押されたときの処理
if(is_valid_csrf_token($token)){ 
    if(delete_cart($db, $item_id)){
        set_message('カートを削除しました。');
    } else {
        set_error('カートの削除に失敗しました。');
    }
} else { 
    set_error('不正な操作が行われました'); 
}  

redirect_to(CART_URL);