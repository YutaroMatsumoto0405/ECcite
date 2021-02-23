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
$token = get_post('token'); 

// 商品削除の処理、item.phpで定義
if(is_valid_csrf_token($token)){ 
    if(destroy_item($db, $item_id) === true){
        set_message('商品を削除しました。');
    } else {
        set_error('商品削除に失敗しました。');
    }
} else { 
    set_error('不正な操作が行われました'); 
} 

redirect_to(ADMIN_URL);