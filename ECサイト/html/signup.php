<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
// ログインしてたらホームにリダイレクト
if(is_logined() === true){
    redirect_to(HOME_URL);
}
$token = get_csrf_token();  
// viewファイル出力
include_once VIEW_PATH . 'signup_view.php';