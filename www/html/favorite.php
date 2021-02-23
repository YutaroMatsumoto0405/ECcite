<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'favorite.php';

session_start();
// ログインしていなかったら、login画面へリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// トークン
$token = get_csrf_token(); 
// DBに接続する
$db = get_db_connect();
$user = get_login_user($db);

$check_all_favorite = check_all_favorite($db,$user['user_id']);

// viewファイル出力
include_once VIEW_PATH . 'favorite_view.php';