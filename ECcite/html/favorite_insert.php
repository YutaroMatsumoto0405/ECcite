<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'favorite.php';

session_start();
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}
// データベース接続
$db = get_db_connect();
$user = get_login_user($db);
$items = get_post('item_id');

// お気に入りに登録
$insert_favorite = insert_favorite($db,$user_id,$item_id,$item_id);

include_once VIEW_PATH . 'favorite_view.php';