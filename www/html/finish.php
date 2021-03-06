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


// ユーザー毎のカート情報を取得
$carts = get_user_carts($db, $user['user_id']);
// 購入の処理
if(purchase_carts($db, $carts) === false){
    set_error('商品が購入できませんでした。');
    redirect_to(CART_URL);
} 
// カート内の合計金額を取得
$total_price = sum_carts($carts);
// viewファイル出力
include_once VIEW_PATH . 'finish_view.php';
