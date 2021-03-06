<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';

// セッションスタート
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
$changes_to = get_post('changes_to');
$token = get_post('token'); 
 
// ステータス変更の処理、item.phpで定義
if(is_valid_csrf_token($token)) { 
    if($changes_to === 'open'){
        update_item_status($db,ITEM_STATUS_OPEN,$item_id);
        set_message('ステータスを変更しました。');
    }else if($changes_to === 'close'){
        update_item_status($db,ITEM_STATUS_CLOSE,$item_id);
        set_message('ステータスを変更しました。');
    }else {
        set_error('不正なリクエストです。');
    }
} else { 
    set_error('不正な操作が行われました'); 
} 

redirect_to(ADMIN_URL);