<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'index.php';

session_start();
// ログインしていなかったら、login画面へリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// トークン
$token = get_csrf_token(); 
// DBに接続する
$db = get_db_connect();
// セッションから取得したlogin中のユーザーIDを格納　user.php
$user = get_login_user($db);

// getで送られた値を変数に格納、functionにget_getの処理がある
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
  $sort = get_get('sort');
} 

// 商品を並び替える処理の呼び出し
$items = get_sort_items($db,$sort);

// viewファイル出力
include_once VIEW_PATH . 'login_top_view.php';