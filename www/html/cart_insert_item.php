<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';
require_once  './model/cart.php';

session_start();
// ログインしていなかったら、login画面へリダイレクト
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}
// DBに接続する
$db = get_db_connect();
$user = get_login_user($db);

// post送信された値を変数に格納
$item_id = get_post('item_id');
$token = get_post('token'); 

// カートに商品を追加する処理
if(add_cart($db,$user['user_id'], $item_id)){
    set_message('カートに商品を追加しました。');
} else {
    set_error('カートの更新に失敗しました。');
}

redirect_to(LOGIN_TOP_URL);