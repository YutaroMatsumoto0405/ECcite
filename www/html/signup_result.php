<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';

session_start();
// ログインしてたらホームにリダイレクト
if(is_logined() === true){
  redirect_to(LOGIN_TOP_URL);
}
 
// viewファイル出力
include_once VIEW_PATH . 'signup_result_view.php';
