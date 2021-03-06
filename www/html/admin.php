<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';

session_start();
// ログインしていなかったら、login画面へリダイレクト　functionにあり
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}
// トークン　function.php
$token = get_csrf_token(); 
// DBに接続する　db.phpにあり
$db = get_db_connect();
$user = get_login_user($db);
// ログインしていなかったら、login画面へリダイレクト
if(is_admin($user) === false){
    redirect_to(LOGIN_URL);
}
// select文で取得した全商品データを格納　item.phpにあり
$items = get_all_items($db);
// viewファイル出力
include_once VIEW_PATH . '/admin_view.php';