<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
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
$category = get_post('category');
$token = get_post('token'); 
 

// カテゴリ変更の処理、item.phpで定義
if(is_valid_csrf_token($token)) { 
    if($category === ITEM_CATEGORY_MEN){
        update_item_status($db, $item_id, ITEM_CATEGORY_MEN);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_WOMAN){
        update_item_status($db, $item_id, ITEM_CATEGORY_WOMAN);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_KIDS){
        update_item_status($db, $item_id, ITEM_CATEGORY_KIDS);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_COLOR){
        update_item_status($db, $item_id, ITEM_CATEGORY_COLOR);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_SIMPLE){
        update_item_status($db, $item_id, ITEM_CATEGORY_SIMPLE);
        set_message('カテゴリを変更しました。');
    }else {
        set_error('不正なリクエストです。');
    }
} else { 
    set_error('不正な操作が行われました'); 
} 


redirect_to(ADMIN_URL);