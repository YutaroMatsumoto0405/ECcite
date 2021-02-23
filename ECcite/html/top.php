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

// 変数に格納
$token = get_csrf_token(); 
$db = get_db_connect();
$user = get_login_user($db);
$name = get_post('name');
$category = get_post('category');

// 検索されたときの処理
$items = push_search($db,$name);
// カテゴリが押されたときの処理
$items = push_category($db,$category);


include_once VIEW_PATH . 'top_view.php';
?>


<!-- 検索されたときの処理と、カテゴリが押されたときの処理を書く  -->