<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';

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
$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');
$image = get_file('img');
$category = get_post('category');
$comment = get_post('comment');
// トークン
$token = get_post('token');

// 商品登録の処理、トークンが一致したら実行される
if(is_valid_csrf_token($token)){ 
    if(regist_item($db, (string)$name, (int)$price, (int)$stock,(int)$status,$image, (int)$category, $comment)){
        set_message('商品を登録しました。');
    }else {
        set_error('商品の登録に失敗しました。');
    }
} else { 
    set_error('不正な操作が行われました'); 
} 

redirect_to(ADMIN_URL);