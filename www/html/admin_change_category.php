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
// 管理者でログインしていなかったら、login画面へリダイレクト
if(is_admin($user) === false){
    redirect_to(LOGIN_URL);
}
// post送信された値を変数に格納
$item_id = get_post('item_id');
$category = (int)get_post('category');
$token = get_post('token'); 
 
// カテゴリ変更の処理、item.phpで定義
if(is_valid_csrf_token($token)) { 
    if($category === ITEM_CATEGORY_MEN){
        update_item_category($db, ITEM_CATEGORY_MEN, $item_id);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_WOMAN){
        update_item_category($db, ITEM_CATEGORY_WOMAN, $item_id);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_KIDS){
        update_item_category($db, ITEM_CATEGORY_KIDS, $item_id);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_COLOR){
        update_item_category($db, ITEM_CATEGORY_COLOR, $item_id);
        set_message('カテゴリを変更しました。');
    }else if($category === ITEM_CATEGORY_SIMPLE){
        update_item_category($db, ITEM_CATEGORY_SIMPLE, $item_id);
        set_message('カテゴリを変更しました。');
    }else {
        set_error('不正なリクエストです。');
    }
} else { 
    set_error('不正な操作が行われました'); 
} 

redirect_to(ADMIN_URL);