<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();
// ログインしていなかったら、ホームへリダイレクト
if(is_logined() === false){
    redirect_to(HOME_URL);
}

// 変数に格納
$token = get_csrf_token(); 
$db = get_db_connect();
$user = get_login_user($db);
$name = get_post('name');
$category = get_post('category');

// 検索orカテゴリが押された時
if(is_valid_csrf_token($token)){ 
    if(push_category($db,$category)){
        $items = push_category($db,$category);
    } else if(push_search($db,$name)) {
        $items = push_search($db,$name);
    }
} else { 
    set_error('不正な操作が行われました');  
} 


include_once VIEW_PATH . 'top_view.php';
?>
