<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
// セッション関数を空っぽに
$_SESSION = array();
$params = session_get_cookie_params();
// クッキーの有効期限を過去にして無効化する
setcookie(session_name(), '', time() - 42000,
    $params["path"], 
    $params["domain"],
    $params["secure"], 
    $params["httponly"]
);
// セッション破棄
session_destroy();

redirect_to(LOGIN_URL);