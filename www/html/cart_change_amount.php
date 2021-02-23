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
// ログイン中ユーザーの情報取得
$user = get_login_user($db); 
// post送信された値を変数に格納
$cart_id = get_post('cart_id');
$amount = get_post('amount');
$token = get_post('token'); 

// カート内商品の数量変更処理
if(is_valid_csrf_token($token)){ 
    if(update_cart_amount($db, $cart_id, $amount)){
        set_message('購入数を更新しました。');
    } else {
        set_error('購入数の更新に失敗しました。');
    }
  } else { 
        set_error('不正な操作が行われました'); 
  } 

redirect_to(CART_URL);
?>