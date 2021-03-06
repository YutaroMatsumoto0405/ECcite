<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';
require_once  './model/cart.php';
require_once  './model/favorite.php';

// ログインしてなかったらログイン画面に
session_start();
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}
// データベース接続
$db = get_db_connect();
$user = get_login_user($db);
$item_id = get_post('item_id');
$img = get_post('img');
$token = get_post('token'); 

// お気に入りに登録
if(is_valid_csrf_token($token)){ 
    if($insert_favorite = insert_favorite($db,$user['user_id'],$item_id,$img)){
        set_message('お気に入りに登録しました');
    } else {
        set_error('お気に入りの登録に失敗しました');
    }
    $check_all_favorite = check_all_favorite($db,$user['user_id']);
} else { 
    set_error('不正な操作が行われました');  
}  

include_once VIEW_PATH . 'favorite_view.php'; 