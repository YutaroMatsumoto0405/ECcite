<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';

session_start();
// ログインしてたらホームにリダイレクト
if(is_logined() === true){
    redirect_to(LOGIN_TOP_URL);
}

// 送られてくる値を変数に格納
$token = get_post('token'); 
$name = get_post('name');
$password = get_post('password');
// DBに接続する
$db = get_db_connect();

// ログイン処理
if(is_valid_csrf_token($token)) {   
    $user = login_as($db, $name, $password);
    if($user === false){
        set_error('ログインに失敗しました。');
        // ログインに失敗したらログイン画面に戻る
        redirect_to(LOGIN_URL);
    } else {
        set_message('ログインしました。');
        // user_id = 1　管理者なら
        if ($user['user_id'] === USER_ID_ADMIN){
            redirect_to(ADMIN_URL);
        } else
            redirect_to(LOGIN_TOP_URL);
    }
} else { 
    set_error('不正な操作が行われました'); 
} 