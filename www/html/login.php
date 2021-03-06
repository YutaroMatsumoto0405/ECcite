<?php
require_once './conf/const.php';
require_once  './model/functions.php';

session_start();

// ログインしてたらホームにリダイレクト
if(is_logined() === true){
    redirect_to(LOGIN_TOP_URL);
}
$token = get_csrf_token(); 

// viewファイル出力
include_once VIEW_PATH . 'login_view.php';