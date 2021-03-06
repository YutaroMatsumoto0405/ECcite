<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';
require_once  './model/cart.php';
require_once  './model/favorite.php';
 
session_start();
// ログインしてなかったらログイン画面に
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);
// postで受け取り
$token = get_post('token'); 

// クリックされた商品の詳細をselect
if(is_valid_csrf_token($token)){ 
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['item_id']) === true){
            $item_id = get_post('item_id');
            $item_details = get_details_items($db, $item_id);
        }
    } else {
        set_error('商品説明が表示されませんでした');
    }
} else { 
    set_error('不正な操作が行われました'); 
}  

// favoriteをselectして登録されてる時とまだされてないときの分岐
$check_favorite = check_favorite($db,$user['user_id'],$item_id);


include_once VIEW_PATH . 'details_item_view.php';

