<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

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
include_once '../view/finish_view.php';