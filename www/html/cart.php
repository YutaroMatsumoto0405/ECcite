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

$token = get_csrf_token();
// DBに接続
$db = get_db_connect();
// ログイン中ユーザーの情報取得
$user = get_login_user($db);

// ユーザー毎のカート情報を取得、viewで表示
$carts = get_user_carts($db, $user['user_id'],$item_id);

// カート内の合計金額を取得 
$total_price = sum_carts($carts);

include_once VIEW_PATH . 'cart_view.php';
?>